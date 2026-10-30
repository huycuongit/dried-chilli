<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;

use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ServiceContractController;

// Clear cache artisan
Route::get('reset-systems-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "<h1>All Config Cache Clear Successfully.</h1>";
});

// Model Contacts
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');


Route::post('/submit-login', [AuthController::class, 'submitLogin'])->name('auth.submitLogin');
Route::get('/dang-nhap', [AuthController::class, 'login'])->name('auth.login');
Route::post('/submit-register', [AuthController::class, 'submitRegister'])->name('auth.submitRegister');
Route::get('/dang-ky', [AuthController::class, 'register'])->name('auth.register');

// Careers
// Ckfinder connects  
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

//news
// 404
Route::get('/he-thong-dang-bao-tri', function () {
    abort(404);
})->name('link.404');

//Site map
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Private contract links are token-protected and intentionally excluded from search.
Route::get('/contract/{token}', [ServiceContractController::class, 'show'])
    ->where('token', '[A-Za-z0-9]{64}')
    ->name('contracts.show');
Route::post('/contract/{token}/sign', [ServiceContractController::class, 'sign'])
    ->where('token', '[A-Za-z0-9]{64}')
    ->middleware('throttle:10,1')
    ->name('contracts.sign');

// Redirect old language URLs to the English-only public website.
Route::get('/{language}/{path?}', function ($language, $path = null) {
    return redirect('/' . ltrim($path ?? '', '/') . (request()->getQueryString() ? '?' . request()->getQueryString() : ''), 301);
})->where(['language' => 'en|vi', 'path' => '.*']);

Route::redirect('/home', '/', 301);
Route::redirect('/checkout', '/cart', 301);
Route::redirect('/dich-vu/{slug?}', '/shop', 301)->name('service.detail');
Route::redirect('/dashboard', '/', 301)->name('page.index');

// Redirect legacy routes to relevant Dried Chili store pages
Route::redirect('/services', '/shop', 301)->name('services.index');
Route::get('/services/{slug}', fn () => redirect('/shop', 301))->name('services.show');
Route::redirect('/projects', '/our-legacy', 301)->name('projects.index');
Route::get('/projects/{slug}', fn () => redirect('/our-legacy', 301))->name('projects.show');
Route::redirect('/news', '/shop', 301)->name('news.index');
Route::get('/news/{slug}', fn () => redirect('/shop', 301))->name('news.show');

Route::middleware('set.locale')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/contact', 'contact')->name('contact.page');
    Route::get('/shop', [HomeController::class, 'shop'])->name('page.shop');
    Route::get('/shop/{slug}', [HomeController::class, 'productDetail'])->name('page.product');
    Route::get('/sale', [SaleController::class, 'index'])->name('page.sale');
    Route::view('/cart', 'frontend.cart')->name('page.cart');
    Route::get('/about-us', [HomeController::class, 'about'])->name('page.about');
    Route::get('/our-legacy', [HomeController::class, 'legacy'])->name('page.legacy');
    Route::get('/faq', [\App\Http\Controllers\LegalController::class, 'faq'])->name('page.faq');
    Route::get('/shipping-refunds', [\App\Http\Controllers\LegalController::class, 'shipping'])->name('page.shipping');
    Route::get('/privacy-policy', [\App\Http\Controllers\LegalController::class, 'privacy'])->name('page.privacy');
    Route::get('/terms-of-service', [\App\Http\Controllers\LegalController::class, 'terms'])->name('page.terms');
    Route::middleware('auth:web')->group(function () {
        Route::get('/account/dashboard', [\App\Http\Controllers\AccountController::class, 'dashboard'])->name('account.dashboard');
        Route::get('/account/addresses', [\App\Http\Controllers\AccountController::class, 'addresses'])->name('account.addresses');
        Route::get('/account/orders', [\App\Http\Controllers\AccountController::class, 'orders'])->name('account.orders');
        Route::get('/account/orders/{id}', [\App\Http\Controllers\AccountController::class, 'orderDetail'])->name('account.order_detail');
    });

    Route::get('/{pagePath}/{slug?}', [\App\Http\Controllers\LocalizedPageController::class, 'show'])
        ->where('pagePath', '(?!admin$)[a-z0-9]+(?:-[a-z0-9]+)*')->name('localized.page');
});

Route::middleware(['auth:web'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Routes moved to locale group

use App\Http\Controllers\LegalController;

// Keep this fallback last.
Route::get('/{slug}', fn () => redirect('/', 301))->name('page.slug');
