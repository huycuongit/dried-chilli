<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCouponRequest;
use App\Services\CouponService;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Exception;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    private function getCart(Request $request)
    {
        $userId = Auth::id();
        $sessionId = $request->header('Session-Id') ?? session()->getId();

        if ($userId) {
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
        } else {
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart;
    }

    private function getCartSubtotal(Cart $cart): float
    {
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }
        return (float) $subtotal;
    }

    public function apply(ApplyCouponRequest $request)
    {
        try {
            $cart = $this->getCart($request);
            $subtotal = $this->getCartSubtotal($cart);

            $result = $this->couponService->applyCoupon(
                $request->code,
                $subtotal,
                Auth::id()
            );

            // Store the coupon in session for checkout (since carts table doesn't have coupon_id)
            // Or we could add coupon_id to carts table later, but session is good for now.
            session()->put('applied_coupon', $result);

            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'data' => $result
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function remove(Request $request)
    {
        session()->forget('applied_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully.'
        ]);
    }
}
