<?php
require __DIR__ . '/preview_nafu_services.php';
foreach (config('nafu-services') as $slug => $entry) {
    $request = Illuminate\Http\Request::create('http://127.0.0.1:8018/services/' . $slug);
    $route = new Illuminate\Routing\Route('GET', 'services/{slug}', fn () => null);
    $route->name('services.show')->bind($request);
    $request->setRouteResolver(fn () => $route);
    $app->instance('request', $request);
    Illuminate\Support\Facades\URL::setRequest($request);
    $html = app(App\Http\Controllers\ServiceController::class)->show($slug)->render();
    if (!str_contains($html, 'service-single-grid') || substr_count($html, 'aria-current="page"') !== 1 || str_contains($html, 'FEB Digi')) throw new RuntimeException('Detail render failed: ' . $slug);
    if (!str_contains($html, '/services/' . $slug) || !str_contains($html, 'service=' . $slug . '#contact-modal')) throw new RuntimeException('Detail links failed');
    file_put_contents(__DIR__ . '/../public/nafu-service-' . $slug . '-preview.html', $html);
}
try { app(App\Http\Controllers\ServiceController::class)->show('unknown-service'); throw new RuntimeException('Unknown slug accepted'); }
catch (Symfony\Component\HttpKernel\Exception\HttpException $exception) { if ($exception->getStatusCode() !== 404) throw $exception; }
echo "Five service detail pages rendered; active navigation, quote links and unknown-slug 404 passed. No database changes.\n";
