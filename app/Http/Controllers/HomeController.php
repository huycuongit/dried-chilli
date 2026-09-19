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

        return view('home', compact('projects', 'services', 'news'));
    }
}
