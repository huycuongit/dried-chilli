<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getCart(Request $request)
    {
        $userId = Auth::id();
        $sessionId = $request->header('Session-Id') ?? session()->getId();

        if ($userId) {
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            // Merge guest cart if needed...
        } else {
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart;
    }

    public function index(Request $request)
    {
        $cart = $this->getCart($request)->load(['items.product.variants', 'items.variant', 'items.bundle']);
        
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $appliedCoupon = session('applied_coupon');
        $discountAmount = 0;
        $total = $subtotal;

        if ($appliedCoupon) {
            // Re-validate coupon just in case cart changed
            try {
                $couponService = app(\App\Services\CouponService::class);
                $result = $couponService->applyCoupon($appliedCoupon['code'], $subtotal, Auth::id());
                $discountAmount = $result['discount_amount'];
                $total = $result['new_total'];
                session()->put('applied_coupon', $result);
            } catch (\Exception $e) {
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

    public function addBundle(Request $request)
    {
        $request->validate([
            'bundle_id' => 'required|exists:bundles,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart($request);
        $bundle = \App\Models\Bundle::where('is_active', true)->findOrFail($request->bundle_id);
        
        $cartItem = $cart->items()->where('bundle_id', $bundle->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->price = $bundle->price;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'bundle_id' => $bundle->id,
                'quantity' => $request->quantity,
                'price' => $bundle->price
            ]);
        }

        return response()->json(['message' => 'Bundle added to cart successfully', 'cart' => $cart->load(['items.product', 'items.bundle'])]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id'
        ]);

        $cart = $this->getCart($request);
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
            $cartItem->price = $itemPrice; // Update to latest price
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'price' => $itemPrice
            ]);
        }

        return response()->json(['message' => 'Added to cart successfully', 'cart' => $cart->load('items')]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart($request);
        $cartItem = $cart->items()->findOrFail($request->cart_item_id);
        
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
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id'
        ]);

        $cart = $this->getCart($request);
        $cart->items()->findOrFail($request->cart_item_id)->delete();

        return response()->json(['message' => 'Item removed from cart', 'cart' => $cart->load('items')]);
    }
}
