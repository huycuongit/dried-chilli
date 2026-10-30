<?php

namespace App\Http\Controllers;

use App\Support\PagePaths;
use Illuminate\Http\Request;

class LocalizedPageController extends Controller
{
    public function show(Request $request, string $pagePath, ?string $slug = null)
    {
        $locale = 'en';
        $page = PagePaths::map()->resolve($pagePath, $locale);
        abort_unless($page !== null, 404);
        abort_if($slug !== null && !in_array($page, ['services', 'news'], true), 404);
        $name = $page === 'home' ? 'home' : $page . ($slug === null ? '.index' : '.show');
        $parameters = [];
        if ($slug !== null) { $parameters['slug'] = $slug; }
        if ($pagePath !== PagePaths::map()->current($page, $locale)) {
            return redirect(PagePaths::url($name, array_merge($request->query(), $parameters)), 301);
        }

        // Retain the semantic page name for active menus and language switching.
        $route = $request->route();
        $action = $route->getAction();
        $action['as'] = $name;
        $route->setAction($action);
        $route->forgetParameter('pagePath');
        if ($slug === null) { $route->forgetParameter('slug'); }
        $controllers = ['home' => HomeController::class, 'services' => ServiceController::class,
            'news' => NewsController::class, 'projects' => ProjectController::class];
        return app()->call([app($controllers[$page]), $slug === null ? 'index' : 'show'], $parameters);
    }
}
