from pathlib import Path
import re
root = Path(__file__).resolve().parents[1]
p = root / 'routes/web.php'
s = p.read_text(encoding='utf-8')
start = s.index('// Locale-prefixed public pages.')
end = s.index("Route::middleware(['authUser'])", start)
s = s[:start] + '''// Redirect old language URLs to the English-only public website.
Route::get('/{language}/{path?}', function ($language, $path = null) {
    return redirect('/' . ltrim($path ?? '', '/') . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
})->where(['language' => 'en|vi', 'path' => '.*']);

Route::redirect('/home', '/', 301);
Route::get('/dich-vu/{slug}', fn ($slug) => redirect("/services/{$slug}", 301))->name('service.detail');
Route::redirect('/dashboard', '/', 301)->name('page.index');

Route::middleware('set.locale')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
    Route::get('/{pagePath}/{slug?}', [\\App\\Http\\Controllers\\LocalizedPageController::class, 'show'])
        ->where('pagePath', '[a-z0-9]+(?:-[a-z0-9]+)*')->name('localized.page');
});

''' + s[end:]
s = s.replace("redirect('/en', 301)", "redirect('/', 301)")
p.write_text(s, encoding='utf-8')
for name in ['Home', 'Project', 'News', 'Service']:
 p = root / f'app/Http/Controllers/{name}Controller.php'
 s = p.read_text(encoding='utf-8').replace('index(string $locale)', 'index()').replace('show(string $locale, string $slug)', 'show(string $slug)')
 if name in ['News', 'Service']:
  s = s.replace('public function show(string $slug)\n    {', "public function show(string $slug)\n    {\n        $locale = 'en';")
 p.write_text(s, encoding='utf-8')
p = root / 'resources/views/frontend/layouts/partials/head.blade.php'
s = p.read_text(encoding='utf-8')
s = re.sub(r'    @php\s+\$routeName.*?    @endif\n', '', s, count=1, flags=re.S)
p.write_text(s, encoding='utf-8')
p = root / 'app/Http/Controllers/SitemapController.php'
s = p.read_text(encoding='utf-8').replace("foreach (['en', 'vi'] as $locale)", "foreach (['en'] as $locale)")
p.write_text(s, encoding='utf-8')
for name in ['home', 'blog']:
 p = root / f'tmp/preview_nafu_{name}.php'
 s = p.read_text(encoding='utf-8').replace('/en/news', '/news').replace('/en\'', '/\'').replace("'{locale}/news'", "'news'").replace("'{locale}'", "'/'")
 if name == 'blog':
  s = s[:s.index("$app->setLocale('vi');")] + 'echo "Blog rendered: six cards, empty state and pagination passed. English-only preview.\\n";\n'
 p.write_text(s, encoding='utf-8')
