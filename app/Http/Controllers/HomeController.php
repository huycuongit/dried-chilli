<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredSlugs = config('jojo-home.featured_product_slugs', []);
        $featuredProducts = \App\Models\Product::where('is_active', true)
            ->whereIn('slug', $featuredSlugs)->get()->keyBy('slug');
        $latestProducts = collect($featuredSlugs)
            ->map(fn (string $slug) => $featuredProducts->get($slug))->filter()->values();
        $hasFeaturedProducts = $latestProducts->isNotEmpty();
        if (!$hasFeaturedProducts) {
            $latestProducts = \App\Models\Product::where('is_active', true)
                ->orderByDesc('is_trending')->orderByDesc('id')->limit(3)->get();
        }
        $settings = app(\App\Support\SystemSettings::class)->all();
        $homeReviews = collect(\App\Support\AboutReviewers::read($settings[\App\Support\AboutReviewers::STORAGE_KEY] ?? null))
            ->filter(fn (array $row) => !empty($row['published'])
                && \App\Support\AboutReviewers::isSafeImage($row['image'] ?? null))
            ->take(3)->values();

        return view('frontend.home', compact('latestProducts', 'homeReviews', 'hasFeaturedProducts'));
    }

    public function shop(\Illuminate\Http\Request $request): View
    {
        $query = \App\Models\Product::where('is_active', true);
        
        if ($request->has('search') && !empty($request->get('search'))) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('min_price') && is_numeric($request->get('min_price'))) {
            $query->whereRaw('COALESCE(sale_price, price) >= ?', [$request->get('min_price')]);
        }
        
        if ($request->has('max_price') && is_numeric($request->get('max_price'))) {
            $query->whereRaw('COALESCE(sale_price, price) <= ?', [$request->get('max_price')]);
        }
        
        if ($request->has('in_stock')) {
            $query->whereHas('inventory', function ($q) {
                $q->where('quantity', '>', 0);
            });
        }
        
        if ($request->has('best_seller')) {
            $query->where('is_best_seller', true);
        }
        
        if ($request->has('on_sale')) {
            $query->whereNotNull('sale_price');
        }
        
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'featured':
            default:
                $query->orderByDesc('is_best_seller')->orderByDesc('id');
                break;
        }

        $products = $query->paginate(9)->withQueryString();
        $categories = \App\Models\Category::all();
        
        return view('frontend.shop', compact('products', 'categories', 'sort'));
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



    public function about(): View
    {
        return view('frontend.about');
    }

    public function legacy(): View
    {
        return view('frontend.legacy');
    }
}
