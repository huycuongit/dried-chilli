<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = 'en';

        App::setLocale($locale);
        View::share('currentLocale', $locale);

        $name = $request->route()->getName();
        if (in_array($name, ['home', 'services.index', 'services.show', 'news.index', 'news.show', 'projects.index', 'projects.show'], true)) {
            $target = \App\Support\PagePaths::url($name, $request->route()->parameters(), false);
            if ($request->getPathInfo() !== $target) {
                return redirect(\App\Support\PagePaths::url($name, array_merge($request->query(), $request->route()->parameters())), 301);
            }
        }

        return $next($request);
    }
}
