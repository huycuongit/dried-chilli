<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->active()
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $news = News::query()
            ->active()
            ->where(function ($query) {
                $query->whereNull('publish_time')
                    ->orWhere('publish_time', '<=', now());
            })
            ->orderBy('position')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $services = Schema::hasTable('services')
            ? Service::query()->active()->orderBy('position')->orderByDesc('id')->limit(5)->get()
            : null;

        $banners = \App\Models\Banner::where('is_active', true)->orderBy('sort_order')->get();
        $saleProducts = \App\Models\Product::where('is_active', true)->whereNotNull('sale_price')->orderByDesc('id')->limit(8)->get();
        $latestProducts = \App\Models\Product::where('is_active', true)->orderByDesc('id')->limit(8)->get();

        return view('frontend.home', compact('projects', 'services', 'news', 'banners', 'saleProducts', 'latestProducts'));
    }

    public function shop(): View
    {
        $products = \App\Models\Product::where('is_active', true)->orderByDesc('id')->get();
        $categories = \App\Models\Category::all();
        return view('frontend.shop', compact('products', 'categories'));
    }

    public function productDetail($slug): View
    {
        $product = \App\Models\Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        // Fetch related products from the same category
        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();
            
        return view('frontend.product', compact('product', 'relatedProducts'));
    }

    public function sale(): View
    {
        $saleProducts = \App\Models\Product::where('is_active', true)->whereNotNull('sale_price')->orderByDesc('id')->get();
        return view('frontend.sale', compact('saleProducts'));
    }

    public function about(): View
    {
        return view('frontend.about');
    }

    public function legacy(): View
    {
        return view('frontend.legacy');
    }
}
