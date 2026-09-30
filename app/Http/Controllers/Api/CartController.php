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
        $cart = $this->getCart($request);
        return response()->json($cart->load('items.product'));
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
        
        $cartItem = $cart->items()->where('product_id', $product->id)
                         ->where('variant_id', $request->variant_id)
                         ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'price' => $product->price // Simplified, should ideally fetch variant price
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
