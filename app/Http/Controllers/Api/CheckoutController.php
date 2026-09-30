<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
            'coupon_code' => 'nullable|string'
        ]);

        $userId = Auth::guard('api')->id();
        $sessionId = $request->header('Session-Id') ?? session()->getId();

        $cart = Cart::with('items')->where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $totalAmount += $item->price * $item->quantity;

                // Lock inventory for update to prevent race conditions
                $inventory = Inventory::where('product_id', $item->product_id)
                                      ->where('variant_id', $item->variant_id)
                                      ->lockForUpdate()
                                      ->first();

                if (!$inventory || $inventory->quantity < $item->quantity) {
                    throw new \Exception("Product ID {$item->product_id} is out of stock.");
                }

                // Decrement inventory
                $inventory->quantity -= $item->quantity;
                $inventory->save();
            }

            $discountAmount = 0;
            $appliedCouponCode = null;

            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)
                                ->where('is_active', true)
                                ->where(function($q) {
                                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                                })
                                ->lockForUpdate()
                                ->first();

                if ($coupon && $totalAmount >= $coupon->min_order_amount) {
                    if (!$coupon->usage_limit || $coupon->used_count < $coupon->usage_limit) {
                        if ($coupon->type === 'fixed') {
                            $discountAmount = $coupon->value;
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
                        throw new \Exception("Coupon usage limit reached.");
                    }
                } else {
                    throw new \Exception("Invalid or inapplicable coupon code.");
                }
            }

            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'total_amount' => max(0, $totalAmount - $discountAmount),
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'coupon_code' => $appliedCouponCode,
                'discount_amount' => $discountAmount,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            // Clear the cart
            $cart->items()->delete();

            DB::commit();

            return response()->json([
                'message' => 'Checkout successful',
                'order_id' => $order->id
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
