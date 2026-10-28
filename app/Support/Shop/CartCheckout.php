<?php

namespace App\Support\Shop;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Prices a cart and turns a priced snapshot into an order.
 * Shared by COD/bank-transfer checkout and paid online checkout so both apply the same rules.
 */
class CartCheckout
{
    public static function userId(): ?int
    {
        // Only the session "web" guard exists (config/auth.php); there is no "api" guard.
        return Auth::guard('web')->id();
    }

    public static function findCart(Request $request): ?Cart
    {
        $userId = self::userId();
        $sessionId = $request->header('Session-Id') ?? session()->getId();

        return Cart::with(['items.product', 'items.bundle'])->where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->first();
    }

    /**
     * Server-side price of the cart. With $lock the inventory and coupon rows are locked
     * (call inside a transaction). Throws CheckoutException with a customer-facing message.
     */
    public static function price(Cart $cart, ?string $couponCode, bool $lock = false): array
    {
        if ($cart->items->isEmpty()) {
            throw new CheckoutException('Cart is empty. Please add items before checking out.');
        }

        $subtotal = 0;
        $items = [];
        foreach ($cart->items as $item) {
            $subtotal += $item->price * $item->quantity;

            if ($item->product_id) {
                $inventory = Inventory::where('product_id', $item->product_id)->where('variant_id', $item->variant_id);
                $inventory = ($lock ? $inventory->lockForUpdate() : $inventory)->first();
                if (!$inventory || $inventory->quantity < $item->quantity) {
                    $productName = $item->product ? $item->product->name : "Product #{$item->product_id}";
                    throw new CheckoutException("{$productName} is out of stock or exceeds available quantity.");
                }
            }

            $items[] = [
                'cart_item_id' => $item->id,
                'product_id' => $item->product_id,
                'bundle_id' => $item->bundle_id,
                'variant_id' => $item->variant_id,
                'quantity' => (int) $item->quantity,
                'price' => (float) $item->price,
            ];
        }

        $discountAmount = 0;
        $appliedCouponCode = null;
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                });
            $coupon = ($lock ? $coupon->lockForUpdate() : $coupon)->first();

            if ($coupon && $subtotal >= $coupon->min_order_amount) {
                if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                    throw new CheckoutException('Coupon usage limit has been reached.');
                }
                if ($coupon->type === 'fixed') {
                    $discountAmount = min($coupon->value, $subtotal);
                } else {
                    $discountAmount = ($subtotal * $coupon->value) / 100;
                    if ($coupon->max_discount && $discountAmount > $coupon->max_discount) {
                        $discountAmount = $coupon->max_discount;
                    }
                }
                $appliedCouponCode = $coupon->code;
            }
        }

        return [
            'cart_id' => $cart->id,
            'items' => $items,
            'subtotal' => round($subtotal, 2),
            'discount_amount' => round($discountAmount, 2),
            'coupon_code' => $appliedCouponCode,
            'total' => max(0, round($subtotal - $discountAmount, 2)),
        ];
    }

    /**
     * Creates the order from a priced snapshot: takes stock, counts the coupon use, copies the
     * items and removes them from the cart. Must run inside a transaction.
     * A paid order is always created, even if stock ran out after payment (logged for staff).
     */
    public static function place(array $priced, array $orderAttributes, bool $paid = false): Order
    {
        foreach ($priced['items'] as $item) {
            if (!$item['product_id']) continue;
            $inventory = Inventory::where('product_id', $item['product_id'])
                ->where('variant_id', $item['variant_id'])->lockForUpdate()->first();
            if (!$inventory || $inventory->quantity < $item['quantity']) {
                if (!$paid) throw new CheckoutException("Product #{$item['product_id']} is out of stock or exceeds available quantity.");
                Log::warning('Paid order oversold product stock', ['product_id' => $item['product_id'], 'variant_id' => $item['variant_id']]);
            }
            if ($inventory) {
                $inventory->quantity = max(0, $inventory->quantity - $item['quantity']);
                $inventory->save();
            }
        }

        if ($priced['coupon_code']) {
            $coupon = Coupon::where('code', $priced['coupon_code'])->lockForUpdate()->first();
            if ($coupon) {
                $coupon->used_count += 1;
                $coupon->save();
            }
        }

        $order = Order::create($orderAttributes + [
            'status' => 'pending',
            'total_amount' => $priced['total'],
            'coupon_code' => $priced['coupon_code'],
            'discount_amount' => $priced['discount_amount'],
        ]);

        foreach ($priced['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'bundle_id' => $item['bundle_id'],
                'variant_id' => $item['variant_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        \App\Models\CartItem::where('cart_id', $priced['cart_id'])
            ->whereIn('id', array_column($priced['items'], 'cart_item_id'))->delete();

        return $order;
    }
}
