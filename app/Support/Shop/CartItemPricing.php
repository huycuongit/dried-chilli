<?php

namespace App\Support\Shop;

use App\Models\CartItem;
use App\Models\Product;
use Carbon\Carbon;

class CartItemPricing
{
    public static function nextPriceChange(CartItem $item): ?string
    {
        $product = $item->product;
        if (!$product) return null;
        $dates = [];
        if ($product->sale_type === 'limited_big' && $item->limited_sale_price !== null && $item->limited_sale_expires_at) {
            $dates[] = Carbon::parse($item->limited_sale_expires_at);
        }
        if ($product->sale_type === 'daily_flash' && $product->sale_price !== null) {
            if ($product->sale_start_date) $dates[] = Carbon::parse($product->sale_start_date);
            if ($product->sale_end_date) $dates[] = Carbon::parse($product->sale_end_date);
        }
        $future = array_filter($dates, fn ($date) => $date->gt(now()));
        if (!$future) return null;
        usort($future, fn ($a, $b) => $a->getTimestamp() <=> $b->getTimestamp());
        return $future[0]->toIso8601String();
    }

    public static function limitedSaleIsActive(Product $product): bool
    {
        return $product->sale_type === 'limited_big' && $product->sale_price !== null &&
            (!$product->sale_start_date || Carbon::parse($product->sale_start_date)->lte(now())) &&
            (!$product->sale_end_date || Carbon::parse($product->sale_end_date)->gt(now()));
    }

    public static function price(CartItem $item): float
    {
        $product = $item->product;
        if (!$product) return (float) $item->price;
        $base = (float) $product->price;
        if ($product->sale_type === 'limited_big') {
            if ($item->limited_sale_price !== null && $item->limited_sale_expires_at && Carbon::parse($item->limited_sale_expires_at)->gt(now())) {
                $base = (float) $item->limited_sale_price;
            }
        } elseif ($product->sale_type === 'daily_flash') {
            if ($product->sale_price !== null && $product->sale_start_date && $product->sale_end_date &&
                Carbon::parse($product->sale_start_date)->lte(now()) && Carbon::parse($product->sale_end_date)->gt(now())) {
                $base = (float) $product->sale_price;
            }
        } elseif ($product->sale_price !== null) {
            $base = (float) $product->sale_price;
        }
        return round($base + (float) ($item->variant->additional_price ?? 0), 2);
    }
}
