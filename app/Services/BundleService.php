<?php

namespace App\Services;

use App\Models\Bundle;
use App\Models\Cart;

class BundleService
{
    /**
     * Calculate bundle discounts based on cart items
     * @param Cart $cart
     * @return array
     */
    public function calculateBundleDiscounts(Cart $cart)
    {
        $activeBundles = Bundle::with('items')->where('is_active', true)->get();
        $cartItems = $cart->items;
        
        $totalBundleDiscount = 0;
        $appliedBundles = [];

        // Build a lookup array of product quantities in the cart
        // Using product_id as key. (If bundles depend on specific variants, logic would need to include variant_id)
        $cartQuantities = [];
        foreach ($cartItems as $item) {
            if (!isset($cartQuantities[$item->product_id])) {
                $cartQuantities[$item->product_id] = 0;
            }
            $cartQuantities[$item->product_id] += $item->quantity;
        }

        foreach ($activeBundles as $bundle) {
            $bundleItems = $bundle->items;
            if ($bundleItems->isEmpty()) continue;

            $canApplyTimes = PHP_INT_MAX;

            // Check if cart has all required products in the bundle
            foreach ($bundleItems as $bItem) {
                if (!isset($cartQuantities[$bItem->product_id])) {
                    $canApplyTimes = 0;
                    break;
                }

                $possibleTimes = floor($cartQuantities[$bItem->product_id] / $bItem->required_quantity);
                if ($possibleTimes < $canApplyTimes) {
                    $canApplyTimes = $possibleTimes;
                }
            }

            if ($canApplyTimes > 0) {
                // Apply the bundle discount
                $discountForThisBundle = $canApplyTimes * $bundle->discount_amount;
                $totalBundleDiscount += $discountForThisBundle;

                $appliedBundles[] = [
                    'id' => $bundle->id,
                    'name' => $bundle->name,
                    'discount_per_bundle' => $bundle->discount_amount,
                    'times_applied' => $canApplyTimes,
                    'total_discount' => $discountForThisBundle
                ];

                // Deduct the quantities used by this bundle from the cart quantities pool
                // so they can't be used for another bundle.
                foreach ($bundleItems as $bItem) {
                    $cartQuantities[$bItem->product_id] -= ($bItem->required_quantity * $canApplyTimes);
                }
            }
        }

        return [
            'total_bundle_discount' => $totalBundleDiscount,
            'applied_bundles' => $appliedBundles
        ];
    }
}
