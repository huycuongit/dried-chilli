<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\System;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // 1. Homepage
        $homeLastModified = collect([
            Product::query()->where('is_active', true)->max('updated_at'),
            System::query()->where('key', 'like', 'home\_%')->max('updated_at'),
            now(),
        ])->filter()->max();

        $home = Url::create(route('home'))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0);
        if ($homeLastModified) {
            $home->setLastModificationDate(Carbon::parse($homeLastModified));
        }
        $sitemap->add($home);

        // 2. Primary Shop & Catalog Pages
        $shopPages = [
            'page.shop' => ['changefreq' => Url::CHANGE_FREQUENCY_DAILY, 'priority' => 0.9],
            'page.sale' => ['changefreq' => Url::CHANGE_FREQUENCY_DAILY, 'priority' => 0.9],
            'page.about' => ['changefreq' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.7],
            'page.legacy' => ['changefreq' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.7],
            'page.faq' => ['changefreq' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.6],
            'contact.page' => ['changefreq' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.6],
            'page.shipping' => ['changefreq' => Url::CHANGE_FREQUENCY_MONTHLY, 'priority' => 0.5],
            'page.privacy' => ['changefreq' => Url::CHANGE_FREQUENCY_YEARLY, 'priority' => 0.3],
            'page.terms' => ['changefreq' => Url::CHANGE_FREQUENCY_YEARLY, 'priority' => 0.3],
        ];

        foreach ($shopPages as $routeName => $meta) {
            if (\Illuminate\Support\Facades\Route::has($routeName)) {
                $sitemap->add(
                    Url::create(route($routeName))
                        ->setChangeFrequency($meta['changefreq'])
                        ->setPriority($meta['priority'])
                );
            }
        }

        // 3. Active Products
        $activeProducts = Product::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->orderByDesc('updated_at')
            ->get(['id', 'slug', 'updated_at']);

        foreach ($activeProducts as $product) {
            $url = Url::create(route('page.product', ['slug' => $product->slug]))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8);
            if ($product->updated_at) {
                $url->setLastModificationDate(Carbon::parse($product->updated_at));
            }
            $sitemap->add($url);
        }

        return response($sitemap->render())
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'no-cache, max-age=0, must-revalidate');
    }
}
