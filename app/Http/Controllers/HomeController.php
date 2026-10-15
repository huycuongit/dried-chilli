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
        $bundles = \App\Models\Bundle::where('is_active', true)->orderByDesc('id')->limit(3)->get();

        return view('frontend.home', compact('projects', 'services', 'news', 'banners', 'saleProducts', 'latestProducts', 'bundles'));
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
