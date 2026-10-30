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

class CheckoutController extends Controller
{
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
            'coupon_code' => 'nullable|string|max:50'
        ]);

        $cart = CartCheckout::findCart($request);

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty. Please add items before checking out.'], 400);
        }

        try {
            $order = DB::transaction(function () use ($request, $cart) {
                $priced = CartCheckout::price($cart, $request->coupon_code ?? session('applied_coupon.code'), true);

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

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
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
        ]);

        $cart = CartCheckout::findCart($request);
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty. Please add items before checking out.'], 400);
        }

        try {
            return response()->json($payments->startAttempt(
                $cart, $provider, (string) $request->header('Idempotency-Key'), $data['shipping_address'], $data['coupon_code'] ?? null
            ), 201);
        } catch (CheckoutException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
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
