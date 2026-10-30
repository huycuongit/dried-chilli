<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$app->setLocale('en');
$app->instance(App\Support\SystemSettings::class, new class extends App\Support\SystemSettings {
    public function all(): array { return []; }
});
$request = Illuminate\Http\Request::create('http://127.0.0.1:8018/news');
$route = new Illuminate\Routing\Route('GET', 'news', fn () => null);
$route->name('news.index')->bind($request);
$request->setRouteResolver(fn () => $route);
$app->instance('request', $request);
Illuminate\Support\Facades\URL::setRequest($request);
Illuminate\Support\Facades\URL::forceRootUrl('http://127.0.0.1:8018');
Illuminate\Support\Facades\URL::forceScheme('http');

$samples = [
    ['Landscaping ideas for small yards', 'Landscaping', '682ad431addb8bf5a550e766_blog (2).avif', '2025-02-09'],
    ['Understanding electrical systems', 'Electrical', '682ad47db98cad6ead5f213f_blog (5).avif', '2025-02-02'],
    ['Best types of wood for DIY furniture', 'Carpentry', '682ad4d76cf4954aab35b69e_blog (3).avif', '2025-01-25'],
    ['Plumbing basics for homeowners', 'Plumbing', '682ad5376845b0ff23fb7316_blog (6).avif', '2025-01-22'],
    ['Choosing the right paint color', 'Painting', '682ad57353e470edcc665577_blog (4).avif', '2025-01-20'],
    ['Handyman tips for home repair', 'Home improvement', '682ad5a96cf4954aab367cc6_blog (1).avif', '2025-01-15'],
];
$items = collect($samples)->map(function ($sample, $index) {
    $article = new App\Models\News;
    $article->setRawAttributes(['id' => $index + 1, 'name' => $sample[0], 'name_vi' => $index === 0 ? 'Ý tưởng sân vườn cho không gian nhỏ' : null, 'slug' => Illuminate\Support\Str::slug($sample[0]), 'category_name' => $sample[1], 'avatar' => 'assets/nafu/' . $sample[2], 'publish_time' => $sample[3], 'created_at' => $sample[3]]);
    return $article;
});
$render = fn ($items, $total = 6, $page = 1) => view('news.index', ['articles' => new Illuminate\Pagination\LengthAwarePaginator($items, $total, 6, $page, ['path' => 'http://127.0.0.1:8018/news'])])->render();
$html = $render($items);
if (substr_count($html, 'class="blog-1-item-block"') !== 6 || !str_contains($html, 'nafu-blog-page')) throw new RuntimeException('Blog layout did not render');
file_put_contents(__DIR__ . '/../public/nafu-blog-preview.html', $html);
$empty = $render(collect());
if (!str_contains($empty, 'Fresh ideas are on their way')) throw new RuntimeException('Empty state failed');
$paged = $render($items, 24, 2);
if (!str_contains($paged, 'rel="prev"') || !str_contains($paged, 'rel="next"') || !str_contains($paged, 'aria-current="page"')) throw new RuntimeException('Pagination failed');
echo "Blog rendered: six cards, empty state and pagination passed. English-only preview.\n";
