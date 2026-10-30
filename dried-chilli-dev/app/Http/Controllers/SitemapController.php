<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Project;
use App\Models\Service;
use App\Models\System;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $publishedNews = News::query()
            ->active()
            ->where(function ($query) {
                $query->whereNull('publish_time')->orWhere('publish_time', '<=', now());
            })
            ->orderByDesc('publish_time')
            ->get(['id', 'slug', 'slug_vi', 'updated_at']);

        $activeServices = Service::query()->active()->orderBy('position')->get(['id', 'slug', 'slug_vi', 'updated_at']);
        $projectsLastModified = Project::query()->active()->max('updated_at');
        $lastModified = collect([
            $projectsLastModified,
            $activeServices->max('updated_at'),
            $publishedNews->max('updated_at'),
            System::query()->where('key', 'like', 'home\_%')->max('updated_at'),
        ])->filter()->max();

        $sitemap = Sitemap::create();

        foreach (['en'] as $locale) {
            $home = Url::create(page_route('home', ['locale' => $locale]))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0);
            if ($lastModified) {
                $home->setLastModificationDate(Carbon::parse($lastModified));
            }
            $sitemap->add($home);

            $projects = Url::create(page_route('projects.index', ['locale' => $locale]))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8);
            if ($projectsLastModified) {
                $projects->setLastModificationDate(Carbon::parse($projectsLastModified));
            }
            $sitemap->add($projects);

            $services = Url::create(page_route('services.index', ['locale' => $locale]))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8);
            if ($activeServices->max('updated_at')) {
                $services->setLastModificationDate(Carbon::parse($activeServices->max('updated_at')));
            }
            $sitemap->add($services);

            $news = Url::create(page_route('news.index', ['locale' => $locale]))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8);
            if ($publishedNews->max('updated_at')) {
                $news->setLastModificationDate(Carbon::parse($publishedNews->max('updated_at')));
            }
            $sitemap->add($news);

            $activeServices->each(function (Service $service) use ($sitemap, $locale) {
                $sitemap->add(
                    Url::create(page_route('services.show', ['locale' => $locale, 'slug' => $service->localizedSlug($locale)]))
                        ->setLastModificationDate(Carbon::parse($service->updated_at))
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.7)
                );
            });

            $publishedNews->each(function (News $article) use ($sitemap, $locale) {
                $sitemap->add(
                    Url::create(page_route('news.show', ['locale' => $locale, 'slug' => $article->localizedSlug($locale)]))
                        ->setLastModificationDate(Carbon::parse($article->updated_at))
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.7)
                );
            });
        }

        return response($sitemap->render())
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'no-cache, max-age=0, must-revalidate');
    }
}