<?php

namespace App\Support\Payments;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\PaymentAttempt;
use App\Support\Shop\CartCheckout;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Support\Shop\CheckoutException;
use App\Support\Shop\CouponUnavailableException;
use App\Support\Shop\CartItemPricing;
use Carbon\Carbon;

/**
 * Same flow as jojo-be PaymentsService (pay before order):
 * - Stripe: create attempt + PaymentIntent; the order is created only from a signed
 *   `payment_intent.succeeded` webhook whose amount/currency/metadata match the attempt.
 * - PayPal: create attempt + PayPal order; the server captures it, verifies the capture
 *   and creates the order.
 * Pending, failed or abandoned attempts never create an order, take stock or clear the cart.
 */
class CheckoutPaymentService
{
    private const STRIPE_EVENTS = [
        'payment_intent.processing',
        'payment_intent.payment_failed',
        'payment_intent.canceled',
        'payment_intent.succeeded',
    ];

    private StripeGateway $stripe;
    private PayPalGateway $paypal;
    private RefundService $refunds;

    public function __construct(StripeGateway $stripe, PayPalGateway $paypal, RefundService $refunds)
    {
        $this->stripe = $stripe;
        $this->paypal = $paypal;
        $this->refunds = $refunds;
    }

    public static function currency(): string
    {
        return strtoupper((string) config('services.shop_currency', 'USD'));
    }

    /** Only a publishable key may reach the browser; a misplaced secret key disables card payment. */
    public static function stripePublishableKey(): ?string
    {
        $key = (string) config('services.stripe.key');
        return Str::startsWith($key, 'pk_') ? $key : null;
    }

    public static function stripeEnabled(): bool
    {
        return (bool) config('services.stripe.enabled') && config('services.stripe.secret') && self::stripePublishableKey();
    }

    public static function paypalEnabled(): bool
    {
        return (bool) config('services.paypal.enabled') && config('services.paypal.client_id') && config('services.paypal.client_secret');
    }

    public function startAttempt(Cart $cart, string $provider, string $idempotencyKey, string $shippingAddress, ?string $couponCode, Carbon $checkoutExpires, float $expectedTotal): array
    {
        if ($provider === PaymentAttempt::STRIPE && !self::stripeEnabled()) abort(503, 'Card payment is temporarily unavailable.');
        if ($provider === PaymentAttempt::PAYPAL && !self::paypalEnabled()) abort(503, 'PayPal is temporarily unavailable.');
        abort_unless(preg_match('/^[a-zA-Z0-9_-]{8,80}$/', $idempotencyKey), 400, 'Valid idempotency key required.');

        $existing = $this->findByKey($cart, $idempotencyKey);
        if ($existing) {
            abort_if($existing->provider !== $provider || $existing->shipping_address !== $shippingAddress ||
                (int) round((float) $existing->total_amount * 100) !== (int) round($expectedTotal * 100),
                409, 'Checkout details changed. Please start a new payment.');
            return $this->resume($existing);
        }

        // The server always prices the cart; client totals are display-only.
        $priced = CartCheckout::price($cart, $couponCode);
        if ((int) round($priced['total'] * 100) !== (int) round($expectedTotal * 100)) throw new CheckoutException('Your cart total has changed. Please review the updated total before paying.');
        foreach ($cart->items as $item) {
            $nextChange = CartItemPricing::nextPriceChange($item);
            if ($nextChange && Carbon::parse($nextChange)->lt($checkoutExpires)) $checkoutExpires = Carbon::parse($nextChange);
        }
        abort_if($priced['total'] <= 0, 400, 'This order has nothing to pay online.');
        $currency = self::currency();

        try {
            $attempt = PaymentAttempt::create([
                'cart_id' => $cart->id,
                'user_id' => CartCheckout::userId(),
                'idempotency_key' => $idempotencyKey,
                'provider' => $provider,
                'status' => PaymentAttempt::PENDING,
                'currency' => $currency,
                'total_amount' => $priced['total'],
                'amount_minor' => $provider === PaymentAttempt::PAYPAL
                    ? PaymentMoney::paypalMinor($priced['total'], $currency)
                    : PaymentMoney::stripeMinor($priced['total'], $currency),
                'shipping_address' => $shippingAddress,
                'cart_snapshot' => $priced,
                'expires_at' => $checkoutExpires,
            ]);
        } catch (QueryException $e) {
            if (!$this->isUniqueConflict($e)) throw $e;
            $attempt = $this->findByKey($cart, $idempotencyKey);
            if (!$attempt) throw $e;
            abort_if($attempt->provider !== $provider || $attempt->shipping_address !== $shippingAddress ||
                (int) round((float) $attempt->total_amount * 100) !== (int) round($expectedTotal * 100),
                409, 'Checkout details changed. Please start a new payment.');
        }

        return $this->resume($attempt);
    }

    public function capturePayPal(PaymentAttempt $attempt, string $paypalOrderId): array
    {
        abort_if($attempt->provider !== PaymentAttempt::PAYPAL || $attempt->provider_payment_id !== $paypalOrderId, 404, 'PayPal payment not found.');
        if (in_array($attempt->status, [PaymentAttempt::PAID, PaymentAttempt::REFUND_PENDING, PaymentAttempt::REFUNDED], true)) return $this->publicStatus($attempt);
        if ($attempt->expires_at && $attempt->expires_at->isPast()) {
            $capture = $this->paypal->retrieveOrderCapture($paypalOrderId);
            abort_unless($capture, 410, 'This checkout has expired. Please start again.');
        } else {
            $capture = $this->paypal->captureOrder($paypalOrderId);
        }
        $this->finalizePayPalCapture($attempt, $capture);
        return $this->publicStatus($attempt->fresh());
    }

    public function reconcilePayPal(PaymentAttempt $attempt): void
    {
        if ($attempt->provider !== PaymentAttempt::PAYPAL || !$attempt->provider_payment_id ||
            !in_array($attempt->status, [PaymentAttempt::PENDING, PaymentAttempt::PROCESSING, PaymentAttempt::EXPIRED], true)) return;
        PaymentAttempt::whereKey($attempt->id)->update(['paypal_checked_at' => now()]);
        $capture = $this->paypal->retrieveOrderCapture($attempt->provider_payment_id);
        if ($capture) {
            $this->finalizePayPalCapture($attempt, $capture);
        } elseif ($attempt->expires_at && $attempt->expires_at->isPast()) {
            PaymentAttempt::whereKey($attempt->id)->whereIn('status', [PaymentAttempt::PENDING, PaymentAttempt::PROCESSING])
                ->update(['status' => PaymentAttempt::EXPIRED]);
        }
    }

    private function finalizePayPalCapture(PaymentAttempt $attempt, array $capture): void
    {
        if ($capture['id'] !== $attempt->provider_payment_id || $capture['status'] !== 'COMPLETED' || empty($capture['capture_id'])) {
            Log::warning('PayPal capture does not match the payment attempt', ['attempt' => $attempt->id, 'capture' => $capture]);
            abort(400, 'PayPal payment does not match this order.');
        }
        if ($capture['amount_minor'] !== $attempt->amount_minor || strtoupper($capture['currency']) !== $attempt->currency) {
            DB::transaction(function () use ($attempt, $capture) {
                $locked = PaymentAttempt::whereKey($attempt->id)->lockForUpdate()->firstOrFail();
                if (!$locked->order_id && !in_array($locked->status, [PaymentAttempt::REFUND_PENDING, PaymentAttempt::REFUNDED], true)) {
                    $locked->fill(['provider_capture_id' => $capture['capture_id'], 'status' => PaymentAttempt::REFUND_PENDING, 'failure_code' => 'payment_mismatch', 'paid_at' => now()])->save();
                }
            });
        } else {
            DB::transaction(fn () => $this->fulfillPaidAttempt($attempt->id, $capture['capture_id'], $capture['captured_at'] ?? null));
        }
        $this->refunds->retry($attempt->id);
    }

    public function handleStripeWebhook(string $rawBody, string $signature): void
    {
        $event = $this->stripe->parseWebhook($rawBody, $signature);

        $refundAttemptId = null;
        try {
            DB::transaction(function () use ($event, &$refundAttemptId) {
                if (DB::table('stripe_webhook_events')->where('id', $event['event_id'])->exists()) return;
                DB::table('stripe_webhook_events')->insert([
                    'id' => $event['event_id'],
                    'type' => $event['type'],
                    'provider_created_at' => $event['provider_created_at'],
                    'created_at' => now(),
                ]);
                $markProcessed = fn () => DB::table('stripe_webhook_events')->where('id', $event['event_id'])->update(['processed_at' => now()]);
                if (!in_array($event['type'], self::STRIPE_EVENTS, true)) return $markProcessed();

                $intent = $event['intent'];
                $attemptId = $intent['metadata']['paymentAttemptId'] ?? null;
                abort_unless($attemptId, 400, 'Stripe payment attempt metadata is missing');
                $attempt = PaymentAttempt::whereKey($attemptId)->lockForUpdate()->first();
                abort_unless($attempt && $attempt->provider === PaymentAttempt::STRIPE, 400, 'Stripe payment attempt was not found');
                if (
                    ($intent['metadata']['cartId'] ?? null) !== (string) $attempt->cart_id ||
                    ($attempt->provider_payment_id && $attempt->provider_payment_id !== $intent['id'])
                ) {
                    abort(400, 'Stripe payment details do not match the attempt');
                }
                if (!$attempt->provider_payment_id) $attempt->provider_payment_id = $intent['id'];
                if ($intent['amount_minor'] !== $attempt->amount_minor || strtoupper($intent['currency']) !== $attempt->currency) {
                    if ($event['type'] !== 'payment_intent.succeeded') abort(400, 'Stripe payment details do not match the attempt');
                    if (!$attempt->order_id && !in_array($attempt->status, [PaymentAttempt::REFUND_PENDING, PaymentAttempt::REFUNDED], true)) {
                        $attempt->fill(['status' => PaymentAttempt::REFUND_PENDING, 'failure_code' => 'payment_mismatch', 'paid_at' => now()])->save();
                    }
                    $refundAttemptId = $attempt->id;
                    return $markProcessed();
                }

                if ($event['type'] === 'payment_intent.processing') {
                    if (!in_array($attempt->status, [PaymentAttempt::PAID, PaymentAttempt::REFUND_PENDING, PaymentAttempt::REFUNDED], true)) $attempt->status = PaymentAttempt::PROCESSING;
                    $attempt->save();
                } elseif ($event['type'] === 'payment_intent.succeeded') {
                    $attempt->save();
                    $this->fulfillPaidAttempt($attempt->id, null, $event['provider_created_at'] ? $event['provider_created_at'] . ' UTC' : null);
                    $refundAttemptId = $attempt->id;
                } elseif (!in_array($attempt->status, [PaymentAttempt::PAID, PaymentAttempt::REFUND_PENDING, PaymentAttempt::REFUNDED], true)) {
                    $attempt->fill([
                        'status' => PaymentAttempt::FAILED,
                        'failure_code' => $intent['failure_code'] ? mb_substr($intent['failure_code'], 0, 80) : null,
                        'failure_message' => $intent['failure_message'] ? mb_substr($intent['failure_message'], 0, 500) : null,
                    ])->save();
                }

                $markProcessed();
            });
        } catch (QueryException $e) {
            // Only acknowledge a duplicate after the exact event was processed.
            if (!$this->isUniqueConflict($e) || !DB::table('stripe_webhook_events')->where('id', $event['event_id'])->whereNotNull('processed_at')->exists()) throw $e;
        }
        if ($refundAttemptId) $this->refunds->retry($refundAttemptId);
    }

    public function publicStatus(PaymentAttempt $attempt): array
    {
        $refundReason = [
            'out_of_stock' => 'the product is out of stock',
            'checkout_expired' => 'the checkout expired',
            'cart_changed' => 'the cart changed before the payment was confirmed',
            'order_cancelled' => 'the order was cancelled',
            'payment_mismatch' => 'the payment details did not match the order',
            'coupon_unavailable' => 'the coupon is no longer available',
        ][$attempt->failure_code] ?? 'the order could not be completed';
        return [
            'paymentAttemptId' => $attempt->id,
            'provider' => $attempt->provider,
            'status' => $attempt->status,
            'currency' => $attempt->currency,
            'total' => (float) $attempt->total_amount,
            'orderId' => $attempt->order_id,
            'failureMessage' => $attempt->status === PaymentAttempt::FAILED ? $attempt->failure_message : null,
            'expiresAt' => $attempt->expires_at ? $attempt->expires_at->toIso8601String() : null,
            'refundMessage' => $attempt->status === PaymentAttempt::REFUNDED
                ? 'Your payment was refunded because ' . $refundReason . '.'
                : ($attempt->status === PaymentAttempt::REFUND_PENDING
                    ? ($attempt->refund_last_error ? 'Your refund needs further processing. Please contact support if it does not complete.' : 'Your payment is being refunded because ' . $refundReason . '.')
                    : null),
        ];
    }

    /** Must run inside a transaction. Creates the order exactly once from the paid snapshot. */
    private function fulfillPaidAttempt(string $attemptId, ?string $captureId = null, ?string $paidAt = null): void
    {
        $attempt = PaymentAttempt::whereKey($attemptId)->lockForUpdate()->firstOrFail();
        if ($attempt->order_id || in_array($attempt->status, [PaymentAttempt::REFUND_PENDING, PaymentAttempt::REFUNDED], true)) return;

        $paidTime = ($paidAt ? Carbon::parse($paidAt) : now())->setTimezone(config('app.timezone'));
        $attempt->provider_capture_id = $captureId;
        if ($attempt->expires_at && $paidTime->gte($attempt->expires_at)) {
            $attempt->fill(['status' => PaymentAttempt::REFUND_PENDING, 'failure_code' => 'checkout_expired', 'paid_at' => $paidTime])->save();
            return;
        }

        $cart = Cart::whereKey($attempt->cart_id)->lockForUpdate()->first();
        $snapshotItems = $attempt->cart_snapshot['items'] ?? [];
        $cartItems = CartItem::where('cart_id', $attempt->cart_id)
            ->whereIn('id', array_column($snapshotItems, 'cart_item_id'))->lockForUpdate()->get()->keyBy('id');
        foreach ($snapshotItems as $snapshot) {
            $item = $cartItems->get($snapshot['cart_item_id']);
            if (!$item || (int) $item->quantity !== (int) $snapshot['quantity'] ||
                (int) $item->product_id !== (int) $snapshot['product_id'] ||
                (string) $item->variant_id !== (string) $snapshot['variant_id']) {
                $cart = null;
                break;
            }
        }
        if (!$cart || !$snapshotItems) {
            $attempt->fill(['status' => PaymentAttempt::REFUND_PENDING, 'failure_code' => 'cart_changed', 'paid_at' => $paidTime])->save();
            return;
        }

        try {
            $order = CartCheckout::place($attempt->cart_snapshot, [
                'user_id' => $attempt->user_id,
                'shipping_address' => $attempt->shipping_address,
                'payment_method' => $attempt->provider,
                'payment_status' => 'paid',
            ], true);
        } catch (CouponUnavailableException $exception) {
            $attempt->fill(['status' => PaymentAttempt::REFUND_PENDING, 'failure_code' => 'coupon_unavailable', 'paid_at' => $paidTime])->save();
            return;
        } catch (CheckoutException $exception) {
            $attempt->fill(['status' => PaymentAttempt::REFUND_PENDING, 'failure_code' => 'out_of_stock', 'paid_at' => $paidTime])->save();
            return;
        }

        $attempt->fill([
            'status' => PaymentAttempt::PAID,
            'paid_at' => $paidTime,
            'order_id' => $order->id,
            'failure_code' => null,
            'failure_message' => null,
        ])->save();
    }

    private function findByKey(Cart $cart, string $idempotencyKey): ?PaymentAttempt
    {
        return PaymentAttempt::where('cart_id', $cart->id)->where('idempotency_key', $idempotencyKey)->first();
    }

    private function resume(PaymentAttempt $attempt): array
    {
        if (in_array($attempt->status, [PaymentAttempt::PAID, PaymentAttempt::REFUND_PENDING, PaymentAttempt::REFUNDED, PaymentAttempt::FAILED], true)) return $this->publicStatus($attempt);
        abort_if($attempt->expires_at && $attempt->expires_at->isPast(), 410, 'This checkout has expired. Please start again.');
        $description = config('app.name') . ' order';

        if ($attempt->provider === PaymentAttempt::PAYPAL) {
            if (!$attempt->provider_payment_id) {
                $order = $this->paypal->createOrder([
                    'attempt_id' => $attempt->id,
                    'amount_minor' => $attempt->amount_minor,
                    'currency' => $attempt->currency,
                    'description' => $description,
                ]);
                $attempt->forceFill(['provider_payment_id' => $order['id']])->save();
            }
            return $this->publicStatus($attempt) + ['paypalOrderId' => $attempt->provider_payment_id];
        }

        // Retrying with the same Stripe idempotency key reconciles an intent created before a crash.
        $intent = $attempt->provider_payment_id
            ? $this->stripe->retrieveIntent($attempt->provider_payment_id)
            : $this->stripe->createIntent([
                'attempt_id' => $attempt->id,
                'cart_id' => $attempt->cart_id,
                'amount_minor' => $attempt->amount_minor,
                'currency' => $attempt->currency,
                'description' => $description,
            ]);
        if (!$attempt->provider_payment_id) $attempt->forceFill(['provider_payment_id' => $intent['id']])->save();

        return $this->publicStatus($attempt) + ['clientSecret' => $intent['client_secret']];
    }

    private function isUniqueConflict(QueryException $e): bool
    {
        return in_array($e->errorInfo[0] ?? null, ['23000', '23505'], true);
    }
}
