<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $articles = $this->publishedQuery()
            ->orderByDesc('publish_time')
            ->orderByDesc('id')
            ->paginate(6);

        return view('news.index', compact('articles'));
    }

    public function show(string $slug)
    {
        $locale = 'en';
        $article = $this->publishedQuery()
            ->with('meta')
            ->forLocalizedSlug($slug, $locale)
            ->first();

        abort_unless($article, 404);

        if ($slug !== $article->localizedSlug($locale)) {
            return redirect(page_route('news.show', ['locale' => $locale, 'slug' => $article->localizedSlug($locale)]), 301);
        }

        $article->increment('views');

        $related = $this->publishedQuery()
            ->whereKeyNot($article->getKey())
            ->orderByDesc('publish_time')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $localizedRecord = $article;

        return view('news.show', compact('localizedRecord', 'article', 'related'));
    }

    private function publishedQuery()
    {
        return News::query()
            ->active()
            ->where(function ($query) {
                $query->whereNull('publish_time')
                    ->orWhere('publish_time', '<=', now());
            });
    }
}
