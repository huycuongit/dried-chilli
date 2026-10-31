<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Services\CouponException;
use Illuminate\Validation\Rule;
use App\Support\Shop\CartItemPricing;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private function getCart(Request $request)
    {
        $userId = Auth::guard('web')->id();
        $sessionId = $request->header('Session-Id') ?? session()->getId();

        if ($request->header('Session-Id')) return Cart::firstOrCreate(['session_id' => $sessionId]);
        return $userId ? Cart::firstOrCreate(['user_id' => $userId]) : Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function index(Request $request)
    {
        $cart = $this->getCart($request)->load(['items.product.variants', 'items.variant', 'items.bundle']);
        
        $subtotal = 0;
        foreach ($cart->items as $item) {
            if ($item->product_id) {
                $item->price = CartItemPricing::price($item);
                $item->setAttribute('price_refresh_at', CartItemPricing::nextPriceChange($item));
            }
            $subtotal += $item->price * $item->quantity;
        }

        $appliedCoupon = session('applied_coupon');
        $discountAmount = 0;
        $total = $subtotal;

        if ($appliedCoupon) {
            // Re-validate coupon just in case cart changed
            try {
                $couponService = app(\App\Services\CouponService::class);
                $result = $couponService->applyCoupon($appliedCoupon['code'], $subtotal, Auth::guard('web')->id());
                $discountAmount = $result['discount_amount'];
                $total = $result['new_total'];
                session()->put('applied_coupon', $result);
            } catch (CouponException $e) {
                session()->forget('applied_coupon');
                $appliedCoupon = null;
            }
        }

        return response()->json([
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total' => $total,
            'applied_coupon' => $appliedCoupon
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')->where('is_active', true)],
            'quantity' => 'required|integer|min:1',
            'variant_id' => ['nullable', 'integer', Rule::exists('product_variants', 'id')->where('product_id', $request->input('product_id'))],
        ], [
            'product_id.exists' => 'This product is no longer available.',
            'variant_id.exists' => 'The selected product option is unavailable.',
            'quantity.min' => 'Please select at least one item.',
        ]);

        $cart = $this->getCart($request);
        return DB::transaction(function () use ($request, $cart) {
            $cart = Cart::whereKey($cart->id)->lockForUpdate()->firstOrFail();
            $product = Product::findOrFail($request->product_id);
        
            // --- Stock Validation ---
            $inventoryQuery = \App\Models\Inventory::where('product_id', $product->id);
            if ($request->variant_id) {
                $inventoryQuery->where('variant_id', $request->variant_id);
            } else {
                $inventoryQuery->whereNull('variant_id');
            }
            $inventory = $inventoryQuery->first();

            if (!$inventory || $inventory->quantity < $request->quantity) {
                return response()->json(['message' => 'Product is out of stock or requested quantity exceeds available stock.', 'available' => $inventory->quantity ?? 0], 422);
            }
        
            $cartItem = $cart->items()->where('product_id', $product->id)
                             ->where('variant_id', $request->variant_id)
                             ->first();

            // Check combined quantity if item already exists in cart
            if ($cartItem && ($cartItem->quantity + $request->quantity) > $inventory->quantity) {
                return response()->json(['message' => 'Cannot add more. You have reached the maximum available stock.', 'available' => $inventory->quantity], 422);
            }

            $itemPrice = $product->sale_price ?? $product->price;
            if ($request->variant_id) {
                $variant = \App\Models\ProductVariant::find($request->variant_id);
                if ($variant) $itemPrice += $variant->additional_price;
            }

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                $values = [
                    'product_id' => $product->id,
                    'variant_id' => $request->variant_id,
                    'quantity' => $request->quantity,
                    'price' => $itemPrice
                ];
                if (CartItemPricing::limitedSaleIsActive($product)) {
                    $values['limited_sale_price'] = $product->sale_price;
                    $values['limited_sale_expires_at'] = now()->addMinutes(10);
                }
                $cart->items()->create($values);
            }

            return response()->json(['message' => 'Added to cart successfully', 'cart' => $cart->load('items')]);
        });
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart($request);
        return DB::transaction(function () use ($request, $cart) {
            $cart = Cart::whereKey($cart->id)->lockForUpdate()->firstOrFail();
            $cartItem = $cart->items()->find($request->cart_item_id);
            if (!$cartItem) return response()->json(['message' => 'This item is no longer in your cart.'], 404);
        
            // --- Stock Validation ---
            $inventoryQuery = \App\Models\Inventory::where('product_id', $cartItem->product_id);
            if ($cartItem->variant_id) {
                $inventoryQuery->where('variant_id', $cartItem->variant_id);
            } else {
                $inventoryQuery->whereNull('variant_id');
            }
            $inventory = $inventoryQuery->first();

            if (!$inventory || $inventory->quantity < $request->quantity) {
                 return response()->json(['message' => 'Requested quantity exceeds available stock.', 'available' => $inventory->quantity ?? 0], 422);
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json(['message' => 'Cart updated', 'cart' => $cart->load('items')]);
        });
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id'
        ]);

        $cart = $this->getCart($request);
        return DB::transaction(function () use ($request, $cart) {
            $cart = Cart::whereKey($cart->id)->lockForUpdate()->firstOrFail();
            $cartItem = $cart->items()->find($request->cart_item_id);
            if (!$cartItem) return response()->json(['message' => 'This item is no longer in your cart.'], 404);
            $cartItem->delete();

            return response()->json(['message' => 'Item removed from cart', 'cart' => $cart->load('items')]);
        });
    }
}
