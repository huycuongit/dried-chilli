<?php

namespace App\Services;

use App\Models\Coupon;
use Carbon\Carbon;
use Exception;

class CouponService
{
    /**
     * Validate the coupon and calculate the discount.
     *
     * @param string $code
     * @param float $subtotal
     * @param int|null $userId
     * @return array
     * @throws Exception
     */
    public function applyCoupon(string $code, float $subtotal, ?int $userId = null): array
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            throw new Exception("Coupon code does not exist.");
        }

        if (!$coupon->is_active) {
            throw new Exception("This coupon is no longer active.");
        }

        if ($coupon->expires_at && Carbon::now()->gt($coupon->expires_at)) {
            throw new Exception("This coupon has expired.");
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            throw new Exception("This coupon has reached its usage limit.");
        }

        if ($subtotal < $coupon->min_order_amount) {
            throw new Exception("The minimum order amount for this coupon is $" . number_format($coupon->min_order_amount, 2));
        }

        $discountAmount = $this->calculateDiscount($coupon, $subtotal);

        return [
            'coupon_id' => $coupon->id,
            'code' => $coupon->code,
            'discount_amount' => round($discountAmount, 2),
            'new_total' => max(0, round($subtotal - $discountAmount, 2)),
            'type' => $coupon->type,
            'value' => $coupon->value
        ];
    }

    /**
     * Calculate the discount amount based on the coupon type.
     *
     * @param Coupon $coupon
     * @param float $subtotal
     * @return float
     */
    private function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->type === 'fixed') {
            return min($coupon->value, $subtotal);
        }

        if ($coupon->type === 'percent') {
            $discount = ($subtotal * $coupon->value) / 100;
            if ($coupon->max_discount !== null && $discount > $coupon->max_discount) {
                return $coupon->max_discount;
            }
            return $discount;
        }

        return 0;
    }
}
