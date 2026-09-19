<?php
require __DIR__ . '/preview_nafu_home.php';
$request = Illuminate\Http\Request::create('http://127.0.0.1:8018/services');
$route = new Illuminate\Routing\Route('GET', 'services', fn () => null);
$route->name('services.index')->bind($request);
$request->setRouteResolver(fn () => $route);
$app->instance('request', $request);
Illuminate\Support\Facades\URL::setRequest($request);
$html = app(App\Http\Controllers\ServiceController::class)->index()->render();
if (substr_count($html, 'data-service=') !== 5 || !str_contains($html, 'nafu-services-page') || str_contains($html, 'FEB Services')) throw new RuntimeException('Service list did not render correctly');
file_put_contents(__DIR__ . '/../public/nafu-services-preview.html', $html);
echo "Services rendered with five Nafu services, alternating layouts and the Nafu footer.\n";
