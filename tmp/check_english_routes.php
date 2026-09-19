<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$app->instance(App\Support\SystemSettings::class, new class extends App\Support\SystemSettings {
    public function all(): array { return []; }
});
if (config('app.locale') !== 'en' || config('app.fallback_locale') !== 'en') throw new RuntimeException('English defaults missing');
$routes = app('router')->getRoutes();
foreach (['/' => 'home', '/news' => 'news.index', '/news/example' => 'news.show', '/services' => 'services.index', '/services/example' => 'services.show', '/projects' => 'projects.index'] as $path => $name) {
    $request = Illuminate\Http\Request::create('http://localhost' . $path);
    $route = $routes->match($request);
    $request->setRouteResolver(fn () => $route);
    if ($route->getName() !== $name || $route->hasParameter('locale')) throw new RuntimeException('Route mismatch: ' . $path);
    $parameters = $route->parameters();
    if (page_route($name, $parameters + ['locale' => 'vi'], false) !== $path) throw new RuntimeException('Language leaked into URL');
    $app->setLocale('vi');
    $response = (new App\Http\Middleware\SetLocale)->handle($request, fn () => response('English'));
    if ($response->getStatusCode() !== 200 || app()->getLocale() !== 'en') throw new RuntimeException('English route redirected or wrong language');
    $method = str_ends_with($name, '.show') ? 'show' : 'index';
    foreach ((new ReflectionMethod(explode('@', $route->getActionName())[0], $method))->getParameters() as $parameter) {
        if ($parameter->getName() === 'locale') throw new RuntimeException('Controller still requires URL language');
    }
}
foreach (['/en', '/vi', '/en/news', '/vi/services/example'] as $path) {
    $request = Illuminate\Http\Request::create('http://localhost' . $path);
    $app->instance('request', $request);
    $response = $routes->match($request)->run();
    $expected = preg_replace('#^/(en|vi)#', '', $path) ?: '/';
    if ($response->getStatusCode() !== 301 || (parse_url($response->getTargetUrl(), PHP_URL_PATH) ?: '/') !== $expected) throw new RuntimeException('Legacy redirect failed: ' . $path . ' -> ' . $response->getTargetUrl());
}
$html = file_get_contents(__DIR__ . '/../public/nafu-banner-preview.html');
if (str_contains($html, 'hreflang="vi"') || preg_match('#href="[^"]*/(?:en|vi)(?:/|["?])#', $html)) throw new RuntimeException('Language URL found in rendered homepage');
echo "English-only routes, URL generation, controller arguments, legacy redirects and rendered links passed. No database changes.\n";
