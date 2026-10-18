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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Process order checkout from current cart session.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:1000',
            'payment_method' => 'required|string|in:cod,paypal,bank_transfer',
            'coupon_code' => 'nullable|string|max:50'
        ]);

        $userId = Auth::guard('web')->id() ?? Auth::guard('api')->id();
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
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $totalAmount += $item->price * $item->quantity;

                // Handle regular product stock check & lock
                if ($item->product_id) {
                    $inventory = Inventory::where('product_id', $item->product_id)
                                          ->where('variant_id', $item->variant_id)
                                          ->lockForUpdate()
                                          ->first();

                    if (!$inventory || $inventory->quantity < $item->quantity) {
                        $productName = $item->product ? $item->product->name : "Product #{$item->product_id}";
                        throw new \Exception("{$productName} is out of stock or exceeds available quantity.");
                    }

                    // Decrement stock
                    $inventory->quantity -= $item->quantity;
                    $inventory->save();
                }
            }

            // Coupon validation & application
            $discountAmount = 0;
            $appliedCouponCode = null;
            $couponCode = $request->coupon_code ?? session('applied_coupon.code');

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)
                                ->where('is_active', true)
                                ->where(function($q) {
                                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                                })
                                ->lockForUpdate()
                                ->first();

                if ($coupon && $totalAmount >= $coupon->min_order_amount) {
                    if (!$coupon->usage_limit || $coupon->used_count < $coupon->usage_limit) {
                        if ($coupon->type === 'fixed') {
                            $discountAmount = min($coupon->value, $totalAmount);
                        } else {
                            $discountAmount = ($totalAmount * $coupon->value) / 100;
                            if ($coupon->max_discount && $discountAmount > $coupon->max_discount) {
                                $discountAmount = $coupon->max_discount;
                            }
                        }
                        
                        $coupon->used_count += 1;
                        $coupon->save();
                        $appliedCouponCode = $coupon->code;
                    } else {
                        throw new \Exception("Coupon usage limit has been reached.");
                    }
                }
            }

            $finalTotal = max(0, round($totalAmount - $discountAmount, 2));

            // Create Order
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'total_amount' => $finalTotal,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'pending',
                'coupon_code' => $appliedCouponCode,
                'discount_amount' => $discountAmount,
            ]);

            // Create Order Items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'bundle_id' => $item->bundle_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            // Clear the cart & applied coupon session
            $cart->items()->delete();
            session()->forget('applied_coupon');

            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully',
                'order_id' => $order->id,
                'total' => $finalTotal
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * PayPal payment success callback handler.
     */
    public function paypalSuccess(Request $request)
    {
        return redirect()->route('page.cart')->with('success', 'PayPal payment completed successfully!');
    }

    /**
     * PayPal payment cancel callback handler.
     */
    public function paypalCancel(Request $request)
    {
        return redirect()->route('page.cart')->with('error', 'PayPal payment was cancelled.');
    }
}
