<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(): View
    {
        $activeVal = strtolower(trim(\App\Models\System::content('nafu_home_sale_page_active_big_sale', '0')));
        $bigSaleActive = in_array($activeVal, ['1', 'yes', 'true', 'on', 'có']);
        $bigSaleBanner = \App\Models\System::content('nafu_home_sale_image_banner');
        $bigSaleTitle = \App\Models\System::content('nafu_home_sale_page_title', 'SUPER HOT DEALS');
        
        $bigSaleProducts = collect();
        if ($bigSaleActive) {
            $bigSaleProducts = \App\Models\Product::where('is_active', true)
                ->where('sale_type', 'limited_big')
                ->whereNotNull('sale_price')
                ->where(function ($q) {
                    $q->whereNull('sale_end_date')
                      ->orWhere('sale_end_date', '>=', now());
                })
                ->orderByDesc('id')
                ->get();
        }

        $flashSaleProducts = \App\Models\Product::where('is_active', true)
            ->where('sale_type', 'daily_flash')
            ->whereNotNull('sale_price')
            ->whereNotNull('sale_end_date')
            ->where('sale_start_date', '<=', now())
            ->where('sale_end_date', '>=', now())
            ->orderBy('sale_end_date', 'asc')
            ->get();

        return view('frontend.sale', compact('bigSaleActive', 'bigSaleBanner', 'bigSaleTitle', 'bigSaleProducts', 'flashSaleProducts'));
    }
}
