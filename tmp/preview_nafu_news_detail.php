<?php
require __DIR__ . '/preview_nafu_home.php';
foreach (App\Support\NafuArticles::samples() as $article) {
    $request = Illuminate\Http\Request::create('http://127.0.0.1:8018/news/' . $article->slug);
    $route = new Illuminate\Routing\Route('GET', 'news/{slug}', fn () => null);
    $route->name('news.show')->bind($request);
    $request->setRouteResolver(fn () => $route);
    $app->instance('request', $request);
    Illuminate\Support\Facades\URL::setRequest($request);
    $html = view('news.show', ['article' => $article, 'related' => collect()])->render();
    if (!str_contains($html, $article->name) || !str_contains($html, 'blog-single-grid') || str_contains($html, 'FEB Digi') || !str_contains($html, 'nafu-footer')) throw new RuntimeException('News detail render failed');
    file_put_contents(__DIR__ . '/../public/nafu-news-' . $article->slug . '-preview.html', $html);
}
$article->setRawAttributes(['id' => 99, 'name' => 'Article without an image', 'slug' => 'empty-article', 'created_at' => '2026-09-18']);
$article->setRelation('meta', null);
$html = view('news.show', ['article' => $article, 'related' => collect()])->render();
if (!str_contains($html, 'We are preparing this article')) throw new RuntimeException('Empty content fallback failed');
$home = file_get_contents(__DIR__ . '/../public/nafu-banner-preview.html');
foreach (App\Support\NafuArticles::samples() as $item) {
    if (!str_contains($home, '/news/' . $item->slug)) throw new RuntimeException('Missing homepage article link');
}
echo "Three news details, homepage links and missing-image/content fallbacks passed. No database changes.\n";
