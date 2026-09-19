<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$app->setLocale('en');
$app->instance(App\Support\SystemSettings::class, new class extends App\Support\SystemSettings {
    public function all(): array { return []; }
});
$request = Illuminate\Http\Request::create('http://127.0.0.1:8018/');
$route = new Illuminate\Routing\Route('GET', '/', fn () => null);
$route->name('home')->bind($request);
$request->setRouteResolver(fn () => $route);
$app->instance('request', $request);
Illuminate\Support\Facades\URL::setRequest($request);
Illuminate\Support\Facades\URL::forceRootUrl('http://127.0.0.1:8018');
Illuminate\Support\Facades\URL::forceScheme('http');

$html = view('home')->render();
if (substr_count($html, 'data-service-slug=') !== 5) throw new RuntimeException('Expected five Nafu services');
foreach (config('nafu-services') as $slug => $service) {
    if (!str_contains($html, 'value="' . $slug . '"')) throw new RuntimeException('Missing enquiry option');
}
file_put_contents(__DIR__ . '/../public/nafu-banner-preview.html', $html);
echo "Homepage rendered with five Nafu services and matching enquiry options.\n";
