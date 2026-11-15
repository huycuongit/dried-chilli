<?php

putenv('APP_ENV=testing');
putenv('CACHE_DRIVER=array');
$tempDir = sys_get_temp_dir() . '/jojo-home-test-' . bin2hex(random_bytes(6));
mkdir($tempDir, 0700, true);
file_put_contents($tempDir . '/packages.php', '<?php return [];');
putenv('APP_PACKAGES_CACHE=' . $tempDir . '/packages.php');
putenv('APP_SERVICES_CACHE=' . $tempDir . '/services.php');
putenv('VIEW_COMPILED_PATH=' . $tempDir);
register_shutdown_function(function () use ($tempDir) { foreach (glob($tempDir . '/*') as $file) @unlink($file); @rmdir($tempDir); });
require __DIR__ . '/../../vendor/autoload.php';
$providers = (require __DIR__ . '/../../config/app.php')['providers'];
file_put_contents($tempDir . '/services.php', '<?php return ' . var_export(['providers' => $providers, 'eager' => $providers, 'deferred' => [], 'when' => []], true) . ';');
$app = require __DIR__ . '/../../bootstrap/app.php';
if (DIRECTORY_SEPARATOR === '\\') $app->addAbsoluteCachePathPrefix(substr($tempDir, 0, 3));
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'session.driver' => 'array']);
Illuminate\Support\Facades\DB::purge();
$schema = Illuminate\Support\Facades\Schema::getFacadeRoot();
$schema->create('systems', function ($t) { $t->id(); $t->string('key')->unique(); $t->longText('content')->nullable(); $t->timestamps(); });
$schema->create('products', function ($t) { $t->id(); $t->string('name'); $t->string('slug'); $t->text('description')->nullable(); $t->decimal('price'); $t->decimal('sale_price')->nullable(); $t->string('sale_type')->nullable(); $t->dateTime('sale_start_date')->nullable(); $t->dateTime('sale_end_date')->nullable(); $t->string('image')->nullable(); $t->boolean('is_active'); $t->boolean('is_trending'); $t->timestamps(); });
$check = static function ($ok, $message) { if (!$ok) throw new RuntimeException($message); };
view()->share('errors', new Illuminate\Support\ViewErrorBag());
$request = Illuminate\Http\Request::create('/', 'GET');
$route = app('router')->getRoutes()->match($request);
$request->setRouteResolver(static fn () => $route);
$app->instance('request', $request);
$controller = new App\Http\Controllers\HomeController();
$render = static fn () => $controller->index()->render();
$html = $render();
$check(!str_contains($html, 'jojo-product-card') && !str_contains($html, 'jojo-review-card'), 'empty catalog or reviews rendered fake cards');
$check(str_contains($html, 'id="recipes"') && str_contains($html, '#recipes"'), 'recipes anchor missing');
$check(str_contains($html, 'og:site_name" content="Jojo Little Kitchen"') && str_contains($html, 'og:image" content="' . asset('images/jojo-shrimp-hero-clean.webp') . '"'), 'home Open Graph identity');
$check(str_contains($html, 'Jojo Little Kitchen, shrimp chilli, chilli oil'), 'home meta keywords');
$check(str_contains($html, '"name": "Jojo Little Kitchen"') && str_contains($html, asset('images/jojo-logo-pdf.svg')), 'home schema identity');
$homeEditorFields = App\Support\PageContentGroups::all()['Home']['Home - Hero banner'];
$check(isset($homeEditorFields['page_layout_home_slide_1_02'], $homeEditorFields['page_layout_home_image_slide_1']), 'current hero editor fields hidden');
$check(!isset($homeEditorFields['page_layout_home_slide_2_01'], $homeEditorFields['page_layout_home_slide_1_06'], $homeEditorFields['page_layout_home_image_slide_4']), 'retired hero editor fields visible');
class JojoHomeTestAdmin extends App\Models\Admin {
    public function hasPermission($permission) { return true; }
    public function hasAnyPermission($permission) { return true; }
    public function getAllCheckPermissions() { return collect(); }
}
$admin = new JojoHomeTestAdmin();
$admin->setRawAttributes(['id' => 1, 'name' => 'Test', 'user_name' => 'Admin']);
$admin->setRelation('roles', collect());
auth()->guard('admin')->setUser($admin);
$editor = view('admin.homepage', ['sections' => App\Support\PageContentGroups::sections(), 'values' => [], 'faqs' => collect()])->render();
$check(str_contains($editor, 'page_layout_home_slide_1_02') && str_contains($editor, 'page_layout_home_story_title'), 'current hero/story editor fields missing');
$check(!str_contains($editor, 'page_layout_home_slide_2_01') && !str_contains($editor, 'page_layout_home_slide_1_06'), 'retired hero fields rendered in editor');

App\Models\Product::create(['name' => 'Real jar', 'slug' => 'real-jar', 'description' => 'A genuine product', 'price' => 18, 'sale_price' => null, 'image' => 'images/product_hero.webp', 'is_active' => 1, 'is_trending' => 0]);
App\Models\Product::create(['name' => 'Hidden jar', 'slug' => 'hidden-jar', 'price' => 1, 'is_active' => 0, 'is_trending' => 1]);
$html = $render();
$check(str_contains($html, 'Real jar') && !str_contains($html, 'Hidden jar'), 'active fallback product selection');
$check(str_contains($html, 'class="quick-add jojo-add" data-product-id="1"'), 'real cart product id');
$check(str_contains($html, '$18.00') && !str_contains($html, '$1.00'), 'catalog prices');
App\Models\Product::create(['name' => 'Sale jar', 'slug' => 'sale-jar', 'price' => 24, 'sale_price' => 20, 'image' => 'images/product_hero.webp', 'is_active' => 1, 'is_trending' => 1]);
$html = $render();
$check(str_contains($html, 'Real jar') && str_contains($html, 'Sale jar') && substr_count($html, 'class="jojo-product-card"') === 2, 'two real catalog cards');
$check(str_contains($html, '$20.00') && str_contains($html, '<s>$24.00</s>'), 'real catalog sale price');
$expired = App\Models\Product::create(['name' => 'Expired flash', 'slug' => 'expired-flash', 'price' => 30, 'sale_price' => 12, 'sale_type' => 'daily_flash', 'sale_start_date' => now()->subDays(2), 'sale_end_date' => now()->subDay(), 'is_active' => 1, 'is_trending' => 1]);
$html = $render();
$check(str_contains($html, 'Expired flash') && str_contains($html, '$30.00') && !str_contains($html, '$12.00'), 'expired flash price displayed');
$expired->update(['sale_type' => 'limited_big']);
$html = $render();
$check(str_contains($html, 'Expired flash') && !str_contains($html, '$12.00'), 'expired limited sale price displayed');
$expired->update(['is_active' => 0]);

App\Models\System::create(['key' => App\Support\AboutReviewers::STORAGE_KEY, 'content' => json_encode([
    ['published' => false, 'image' => '/images/about_hero.webp', 'name' => 'Private person', 'caption' => 'Unpublished'],
    ['published' => true, 'image' => '/images/about_hero.webp', 'name' => 'Real customer', 'caption' => 'Wonderful with dinner', 'rating' => 5],
    ['published' => true, 'image' => '/images/about_hero.webp', 'alt' => 'Customer holding a jar'],
])]);
app(App\Support\SystemSettings::class)->forget();
$html = $render();
$check(str_contains($html, 'Real customer') && str_contains($html, 'Wonderful with dinner') && !str_contains($html, 'Private person'), 'published review filtering');
$check(str_contains($html, '5 out of 5 stars'), 'review rating');
$check(str_contains($html, 'alt="Customer holding a jar"') && substr_count($html, 'class="jojo-review-card"') === 2, 'published image-only review');
App\Models\System::create(['key' => 'nafu_home_page_layout_home_slide_1_02', 'content' => 'A custom hero']);
App\Models\System::create(['key' => 'nafu_home_page_layout_home_story_title', 'content' => 'A custom story']);
App\Models\System::create(['key' => 'nafu_home_page_layout_home_image_slide_1', 'content' => 'images/old-hero.webp']);
App\Models\System::create(['key' => 'nafu_home_page_layout_home_story_button_link', 'content' => '/old-story']);
app(App\Support\SystemSettings::class)->forget();
$html = $render();
$check(str_contains($html, 'A custom hero') && str_contains($html, 'A custom story') && str_contains($html, 'old-hero.webp') && str_contains($html, '/old-story'), 'CMS hero and story overrides rendered');
$check(str_contains($html, 'jojo-cart-count-mobile cart-count'), 'mobile cart count missing');
App\Models\Product::create(['name' => 'Shrimp jar', 'slug' => 'crispy-shrimp-chili-oil', 'price' => 22, 'image' => 'images/shrimp_chilli.png', 'is_active' => 1, 'is_trending' => 0]);
App\Models\Product::create(['name' => 'Unavailable duo', 'slug' => 'starter-duo-gift-pack', 'price' => 28, 'is_active' => 0, 'is_trending' => 1]);
$html = $render();
$check(str_contains($html, 'Shrimp jar') && !str_contains($html, 'Unavailable duo') && !str_contains($html, 'Sale jar'), 'featured product selection and inactive filter');
$check(str_contains($html, 'Meet Our Shrimp Chilli Range'), 'featured range heading');
$check(str_contains($html, 'images/jojo-home-product-01.jpg') && is_file(public_path('images/jojo-home-product-01.jpg')), 'first supplied product image missing');
App\Models\Product::where('slug', 'crispy-shrimp-chili-oil')->update(['image' => 'storage/products/new-jar.webp']);
$html = $render();
$check(str_contains($html, 'storage/products/new-jar.webp') && !str_contains($html, 'images/jojo-home-product-01.jpg'), 'managed catalog image masked by legacy override');
App\Models\Product::where('slug', 'starter-duo-gift-pack')->update(['image' => 'images/product_hero.png', 'is_active' => 1]);
App\Models\Product::create(['name' => 'Garlic crunch', 'slug' => 'extra-garlic-chili-crunch', 'price' => 24, 'image' => 'images/product_khong_nen.png', 'is_active' => 1, 'is_trending' => 0]);
$html = $render();
$check(str_contains($html, 'images/jojo-home-product-02.jpg') && is_file(public_path('images/jojo-home-product-02.jpg')), 'second supplied product image missing');
$check(str_contains($html, 'images/jojo-home-product-03.jpg') && is_file(public_path('images/jojo-home-product-03.jpg')), 'third supplied product image missing');
$check(strpos($html, 'jojo-home-product-02.jpg') < strpos($html, 'jojo-home-product-03.jpg'), 'supplied product images rendered in the wrong order');
$migration = require __DIR__ . '/../../database/migrations/2026_11_15_000001_apply_jojo_home_redesign_content.php';
$migration->up();
app(App\Support\SystemSettings::class)->forget();
$html = $render();
$check(str_contains($html, 'A LITTLE HEAT, A LOT OF') && str_contains($html, 'The Story Behind Jojo Little Kitchen') && str_contains($html, 'jojo-shrimp-hero-clean.webp') && str_contains($html, '/our-legacy'), 'redesign content migration');
$check(App\Models\System::where('key', 'nafu_home_jojo_redesign_backup_20261115')->exists(), 'CMS backup missing');
$migration->down();
app(App\Support\SystemSettings::class)->forget();
$html = $render();
$check(str_contains($html, 'A custom hero') && str_contains($html, 'A custom story') && str_contains($html, 'old-hero.webp') && str_contains($html, '/old-story'), 'CMS rollback did not restore previous content');
$migration->up();
App\Models\System::where('key', 'nafu_home_page_layout_home_slide_1_02')->update(['content' => 'Edited after redesign']);
$migration->down();
$check(App\Models\System::where('key', 'nafu_home_page_layout_home_slide_1_02')->value('content') === 'Edited after redesign', 'rollback overwrote a newer CMS edit');
$check(App\Models\System::where('key', 'nafu_home_jojo_redesign_backup_20261115')->exists(), 'backup lost after conflicting CMS edit');
$migration->up();
$check(App\Models\System::where('key', 'nafu_home_page_layout_home_slide_1_02')->value('content') === 'Edited after redesign', 'reapply overwrote a newer CMS edit');
echo "PASS: Jojo home empty state, catalog, cart selector, published reviews, CMS overrides, featured products, migration and recipes anchor\n";
