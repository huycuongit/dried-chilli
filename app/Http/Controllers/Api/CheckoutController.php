<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\Bundle;
use App\Models\Coupon;
use App\Services\PayPalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $userId = Auth::id();
        $sessionId = $request->header('Session-Id') ?? session()->getId();

        $cart = Cart::with(['items.product', 'items.bundle'])->where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->first();

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

            $redirectUrl = null;

            if ($request->payment_method === 'paypal') {
                $paypalService = app(PayPalService::class);
                $returnUrl = route('api.checkout.paypal.success', ['order_id' => $order->id]);
                $cancelUrl = route('api.checkout.paypal.cancel', ['order_id' => $order->id]);
                $paypalOrder = $paypalService->createOrder($finalTotal, $order->id, $returnUrl, $cancelUrl);

                $order->transaction_id = $paypalOrder['paypal_order_id'];
                $order->save();

                $redirectUrl = $paypalOrder['approve_url'];
            } else {
                // Clear the cart & applied coupon session for COD and non-PayPal methods
                $cart->items()->delete();
                session()->forget('applied_coupon');
                session(['last_order_id' => $order->id]);
            }

            DB::commit();

            $token = hash('sha256', $order->id . $order->created_at . config('app.key'));
            $successUrl = route('checkout.success', ['id' => $order->id, 'token' => $token]);

            $responseData = [
                'message' => $redirectUrl ? 'Order placed. Redirecting to PayPal...' : 'Order placed successfully',
                'order_id' => $order->id,
                'total' => $finalTotal,
                'success_url' => $successUrl,
            ];

            if ($redirectUrl) {
                $responseData['redirect_url'] = $redirectUrl;
            }

            return response()->json($responseData, 200);

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
        $token = $request->query('token');
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect()->route('page.cart')->with('error', 'Order ID is missing.');
        }

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('page.cart')->with('error', 'Order not found.');
        }

        try {
            $paypalService = app(PayPalService::class);
            $result = $paypalService->capturePayment($token);

            if (($result['status'] ?? '') === 'COMPLETED') {
                $order->payment_status = 'paid';
                $order->status = 'processing';
                if (!empty($result['transaction_id'])) {
                    $order->transaction_id = $result['transaction_id'];
                }
                $order->save();

                // Clear the customer's cart session
                $userId = Auth::id();
                $sessionId = $request->header('Session-Id') ?? session()->getId();

                $cart = Cart::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })->first();

                if ($cart) {
                    $cart->items()->delete();
                }
                session()->forget('applied_coupon');
                session(['last_order_id' => $order->id]);

                $token = hash('sha256', $order->id . $order->created_at . config('app.key'));

                return redirect()->route('checkout.success', ['id' => $order->id, 'token' => $token])
                    ->with('success', 'PayPal payment completed successfully!');
            }

            $order->payment_status = 'failed';
            $order->save();

            return redirect()->route('page.cart')->with('error', 'PayPal payment capture was not completed.');

        } catch (\Exception $e) {
            Log::error('PayPal capture error: ' . $e->getMessage());
            $order->payment_status = 'failed';
            $order->save();

            return redirect()->route('page.cart')->with('error', 'Payment failed: ' . $e->getMessage());
        }
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
        $orderId = $request->query('order_id');

        if ($orderId) {
            $order = Order::with('items')->find($orderId);
            if ($order && $order->payment_status !== 'cancelled') {
                DB::beginTransaction();
                try {
                    $order->payment_status = 'cancelled';
                    $order->status = 'cancelled';
                    $order->save();

                    // Restore reserved inventory quantity
                    foreach ($order->items as $item) {
                        if ($item->product_id) {
                            $inventory = Inventory::where('product_id', $item->product_id)
                                                  ->where('variant_id', $item->variant_id)
                                                  ->lockForUpdate()
                                                  ->first();

                            if ($inventory) {
                                $inventory->quantity += $item->quantity;
                                $inventory->save();
                            }
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('PayPal cancel inventory rollback error: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('page.cart')->with('error', 'PayPal payment was cancelled. Your items are still in your cart.');
    }
}
