<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PaymentAttempt;
use App\Support\Payments\CheckoutPaymentService;
use App\Support\Shop\CartCheckout;
use App\Support\Shop\CheckoutException;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function startSession(Request $request)
    {
        $cart = CartCheckout::findCart($request);
        if (!$cart || $cart->items->isEmpty()) return response()->json(['message' => 'Your cart is empty. Please add items before checking out.'], 422);
        $token = (string) Str::uuid();
        $expires = now()->addMinutes(15);
        $request->session()->put('checkout_session', ['token' => $token, 'cart_id' => $cart->id, 'expires_at' => $expires->toIso8601String()]);
        return response()->json(['checkoutToken' => $token, 'expiresAt' => $expires->toIso8601String()]);
    }

    private function checkoutExpiry(Request $request, Cart $cart): Carbon
    {
        $session = $request->session()->get('checkout_session');
        $token = (string) $request->header('Checkout-Token');
        abort_unless(is_array($session) && isset($session['token'], $session['cart_id'], $session['expires_at']) &&
            $token !== '' && hash_equals($session['token'], $token) && (int) $session['cart_id'] === (int) $cart->id,
            410, 'This checkout is no longer valid. Please return to your cart and start again.');
        $expires = Carbon::parse($session['expires_at']);
        abort_if($expires->lte(now()), 410, 'This checkout has expired. Please return to your cart and start again.');
        return $expires;
    }

    private function assertExpectedTotal(array $priced, $expected): void
    {
        if ((int) round($priced['total'] * 100) !== (int) round((float) $expected * 100)) {
            throw new CheckoutException('Your cart total has changed. Please review the updated total before paying.');
        }
    }
    /**
     * Process an offline-payment (COD / bank transfer) order from the current cart session.
     * Card and PayPal orders go through the payment endpoints below and are created only once paid.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:1000',
            'payment_method' => 'required|string|in:cod,bank_transfer',
            'coupon_code' => 'nullable|string|max:50',
            'expected_total' => 'required|numeric|min:0',
        ]);

        if ($request->payment_method === 'bank_transfer') {
            return response()->json(['message' => 'Bank transfer is temporarily unavailable. Please choose another payment method.'], 503);
        }

        $cart = CartCheckout::findCart($request);

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty. Please add items before checking out.'], 422);
        }
        $this->checkoutExpiry($request, $cart);

        try {
            $order = DB::transaction(function () use ($request, $cart) {
                $lockedCart = Cart::whereKey($cart->id)->lockForUpdate()->firstOrFail();
                $lockedCart->load(['items.product', 'items.variant', 'items.bundle']);
                $priced = CartCheckout::price($lockedCart, $request->coupon_code ?? session('applied_coupon.code'), true);
                $this->assertExpectedTotal($priced, $request->expected_total);

                return CartCheckout::place($priced, [
                    'user_id' => CartCheckout::userId(),
                    'shipping_address' => $request->shipping_address,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'pending',
                ]);
            });

            // Clear the applied coupon session
            session()->forget('applied_coupon');

            return response()->json([
                'message' => 'Order placed successfully',
                'order_id' => $order->id,
                'total' => $order->total_amount
            ], 200);

        } catch (CheckoutException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Start a card payment (Stripe Payment Element). Returns the PaymentIntent client secret.
     */
    public function createStripe(Request $request, CheckoutPaymentService $payments)
    {
        return $this->startPayment($request, $payments, PaymentAttempt::STRIPE);
    }

    /**
     * Start a PayPal payment. Returns the PayPal order id for the PayPal Buttons.
     */
    public function createPayPal(Request $request, CheckoutPaymentService $payments)
    {
        return $this->startPayment($request, $payments, PaymentAttempt::PAYPAL);
    }

    /**
     * Capture an approved PayPal order on the server and create the paid order.
     */
    public function capturePayPal(Request $request, CheckoutPaymentService $payments, string $payment)
    {
        $data = $request->validate(['paypalOrderId' => 'required|string|max:255']);

        return response()->json($payments->capturePayPal($this->ownedAttempt($request, $payment), $data['paypalOrderId']));
    }

    /**
     * Payment status polled by the checkout page after card confirmation or redirect.
     */
    public function paymentStatus(Request $request, CheckoutPaymentService $payments, string $payment)
    {
        return response()->json($payments->publicStatus($this->ownedAttempt($request, $payment)))
            ->header('Cache-Control', 'private, no-store, max-age=0');
    }

    /**
     * Stripe webhook: the only place a card payment becomes a paid order.
     */
    public function stripeWebhook(Request $request, CheckoutPaymentService $payments)
    {
        $signature = (string) $request->header('Stripe-Signature');
        abort_if($signature === '' || $request->getContent() === '', 400, 'Stripe signature and raw body are required');

        try {
            $payments->handleStripeWebhook($request->getContent(), $signature);
        } catch (UnexpectedValueException $e) {
            abort(400, $e->getMessage());
        }

        return response()->json(['received' => true]);
    }

    private function startPayment(Request $request, CheckoutPaymentService $payments, string $provider)
    {
        $data = $request->validate([
            'shipping_address' => 'required|string|max:1000',
            'coupon_code' => 'nullable|string|max:50',
            'expected_total' => 'required|numeric|min:0',
        ]);

        $cart = CartCheckout::findCart($request);
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty. Please add items before checking out.'], 422);
        }
        $expires = $this->checkoutExpiry($request, $cart);

        try {
            return response()->json($payments->startAttempt(
                $cart, $provider, (string) $request->header('Idempotency-Key'), $data['shipping_address'], $data['coupon_code'] ?? null, $expires, (float) $data['expected_total']
            ), 201);
        } catch (CheckoutException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /** A payment attempt is only visible to the cart (session or signed-in user) that started it. */
    private function ownedAttempt(Request $request, string $payment): PaymentAttempt
    {
        $cart = CartCheckout::findCart($request);
        abort_unless($cart, 404, 'Payment not found.');

        return PaymentAttempt::where('cart_id', $cart->id)->findOrFail($payment);
    }
}
