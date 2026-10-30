<?php

namespace App\Support\Payments;

use App\Models\Cart;
use App\Models\PaymentAttempt;
use App\Support\Shop\CartCheckout;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

    public function __construct(StripeGateway $stripe, PayPalGateway $paypal)
    {
        $this->stripe = $stripe;
        $this->paypal = $paypal;
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

    public function startAttempt(Cart $cart, string $provider, string $idempotencyKey, string $shippingAddress, ?string $couponCode): array
    {
        if ($provider === PaymentAttempt::STRIPE && !self::stripeEnabled()) abort(503, 'Card payment is temporarily unavailable.');
        if ($provider === PaymentAttempt::PAYPAL && !self::paypalEnabled()) abort(503, 'PayPal is temporarily unavailable.');
        abort_unless(preg_match('/^[a-zA-Z0-9_-]{8,80}$/', $idempotencyKey), 400, 'Valid idempotency key required.');

        $existing = $this->findByKey($cart, $idempotencyKey);
        if ($existing) return $this->resume($existing);

        // The server always prices the cart; client totals are display-only.
        $priced = CartCheckout::price($cart, $couponCode);
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
            ]);
        } catch (QueryException $e) {
            if (!$this->isUniqueConflict($e)) throw $e;
            $attempt = $this->findByKey($cart, $idempotencyKey);
            if (!$attempt) throw $e;
        }

        return $this->resume($attempt);
    }

    public function capturePayPal(PaymentAttempt $attempt, string $paypalOrderId): array
    {
        abort_if($attempt->provider !== PaymentAttempt::PAYPAL || $attempt->provider_payment_id !== $paypalOrderId, 404, 'PayPal payment not found.');
        if ($attempt->status === PaymentAttempt::PAID) return $this->publicStatus($attempt);

        $capture = $this->paypal->captureOrder($paypalOrderId);
        if (
            $capture['id'] !== $paypalOrderId ||
            $capture['status'] !== 'COMPLETED' ||
            $capture['amount_minor'] !== $attempt->amount_minor ||
            strtoupper($capture['currency']) !== $attempt->currency
        ) {
            Log::warning('PayPal capture does not match the payment attempt', ['attempt' => $attempt->id, 'capture' => $capture]);
            abort(400, 'PayPal payment does not match this order.');
        }

        DB::transaction(fn () => $this->fulfillPaidAttempt($attempt->id));

        return $this->publicStatus($attempt->fresh());
    }

    public function handleStripeWebhook(string $rawBody, string $signature): void
    {
        $event = $this->stripe->parseWebhook($rawBody, $signature);

        try {
            DB::transaction(function () use ($event) {
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
                    $intent['amount_minor'] !== $attempt->amount_minor ||
                    strtoupper($intent['currency']) !== $attempt->currency ||
                    ($intent['metadata']['cartId'] ?? null) !== (string) $attempt->cart_id ||
                    ($attempt->provider_payment_id && $attempt->provider_payment_id !== $intent['id'])
                ) {
                    abort(400, 'Stripe payment details do not match the attempt');
                }
                if (!$attempt->provider_payment_id) $attempt->provider_payment_id = $intent['id'];

                if ($event['type'] === 'payment_intent.processing') {
                    if ($attempt->status !== PaymentAttempt::PAID) $attempt->status = PaymentAttempt::PROCESSING;
                    $attempt->save();
                } elseif ($event['type'] === 'payment_intent.succeeded') {
                    $attempt->save();
                    $this->fulfillPaidAttempt($attempt->id);
                } elseif ($attempt->status !== PaymentAttempt::PAID) {
                    $attempt->fill([
                        'status' => PaymentAttempt::FAILED,
                        'failure_code' => $intent['failure_code'] ? mb_substr($intent['failure_code'], 0, 80) : null,
                        'failure_message' => $intent['failure_message'] ? mb_substr($intent['failure_message'], 0, 500) : null,
                    ])->save();
                }

                $markProcessed();
            });
        } catch (QueryException $e) {
            // A concurrent delivery of the same event already recorded it.
            if (!$this->isUniqueConflict($e)) throw $e;
        }
    }

    public function publicStatus(PaymentAttempt $attempt): array
    {
        return [
            'paymentAttemptId' => $attempt->id,
            'provider' => $attempt->provider,
            'status' => $attempt->status,
            'currency' => $attempt->currency,
            'total' => (float) $attempt->total_amount,
            'orderId' => $attempt->order_id,
            'failureMessage' => $attempt->status === PaymentAttempt::FAILED ? $attempt->failure_message : null,
        ];
    }

    /** Must run inside a transaction. Creates the order exactly once from the paid snapshot. */
    private function fulfillPaidAttempt(string $attemptId): void
    {
        $attempt = PaymentAttempt::whereKey($attemptId)->lockForUpdate()->firstOrFail();
        if ($attempt->order_id) return;

        $order = CartCheckout::place($attempt->cart_snapshot, [
            'user_id' => $attempt->user_id,
            'shipping_address' => $attempt->shipping_address,
            'payment_method' => $attempt->provider,
            'payment_status' => 'paid',
        ], true);

        $attempt->fill([
            'status' => PaymentAttempt::PAID,
            'paid_at' => now(),
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
