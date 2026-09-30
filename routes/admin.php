<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
// Admin Routers new
use App\Http\Controllers\Admin\System\SystemController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ServiceContractController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Artisan
Route::get('reset-systems-cache-admin', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "<h1>All Config Cache Clear Successfully.</h1>";
});

// Routers for Auth Admin
$finalString = 'nafu';
Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::get($finalString . 'login' . $finalString, [LoginController::class, 'login'])->name('admin.login');
Route::post($finalString . 'login' . $finalString, [LoginController::class, 'postlogin'])->name('admin.save.login');

// Routers for authadmin
Route::group(['middleware' => 'authadmin'], function () {

    $project = 'nafu-project';

    Route::post($project . '/editor/images', [\App\Http\Controllers\Admin\EditorImageController::class, 'store'])
        ->middleware('throttle:30,1')->name('admin.editor.images');

    Route::middleware(['check.permissions'])->group(function () use ($project) {

        Route::get($project, [DashboardController::class, 'index'])->name('admin.dashboard.index');

        Route::prefix("{$project}/")->group(function () {



            Route::get('users/all', [UserController::class, 'getAll'])->name('admin.users.all');
            Route::get('users/datatables', [UserController::class, 'datatables'])->name('admin.users.datatables');
            Route::resource('users', UserController::class)
                ->names('admin.users')
                ->parameters([
                    'users' => 'id',
                ]);

            Route::get('roles/all', [RoleController::class, 'getAll'])->name('admin.roles.all');
            Route::get('roles/permissions', [RoleController::class, 'permissions'])->name('admin.roles.permissions');
            Route::get('roles/datatables', [RoleController::class, 'datatables'])->name('admin.roles.datatables');
            Route::resource('roles', RoleController::class)
                ->names('admin.roles')
                ->parameters([
                    'roles' => 'id',
                ]);

            Route::get('news/datatables', [NewsController::class, 'datatables'])->name('admin.news.datatables');
            Route::resource('news', NewsController::class)
                ->names('admin.news')
                ->parameters([
                    'news' => 'id',
                ]);

            Route::get('projects/datatables', [ProjectController::class, 'datatables'])->name('admin.projects.datatables');
            Route::resource('projects', ProjectController::class)->names('admin.projects')->parameters(['projects' => 'id']);

            Route::get('services/datatables', [ServiceController::class, 'datatables'])->name('admin.services.datatables');
            Route::resource('services', ServiceController::class)->names('admin.services')->parameters(['services' => 'id']);

            Route::get('contacts/datatables', [ContactController::class, 'datatables'])->name('admin.contacts.datatables');
            Route::get('contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
            Route::patch('contacts/{id}', [ContactController::class, 'update'])->name('admin.contacts.update');

            Route::post('contracts/{id}/send', [ServiceContractController::class, 'send'])->name('admin.contracts.send');
            Route::resource('contracts', ServiceContractController::class)
                ->except(['show'])
                ->names('admin.contracts')
                ->parameters(['contracts' => 'id']);

            Route::controller(SystemController::class)->prefix('/systems')->as('admin.systems.')->group(function () {
                Route::get('/generals', 'general')->name('generals');
                Route::redirect('/homepage', '/admin/nafu-project/systems/pages');
                Route::get('/pages', [\App\Http\Controllers\Admin\HomepageController::class, 'index'])->name('pages');
                Route::put('/pages', [\App\Http\Controllers\Admin\HomepageController::class, 'update'])->name('pages.save');
                Route::get('/apis', 'apis')->name('apis');
                Route::get('/socials', 'socials')->name('socials');
                Route::get('/config-shareholders', 'configshareholders')->name('config-shareholders');
                Route::get('/otps', 'otps')->name('otps');
                Route::get('/notifications', 'notifications')->name('notifications');

                Route::post('/consoles', 'runConsoles')->name('run');
                Route::put('/update', 'update')->name('update');
            });

            // Ecommerce CMS Routes
            Route::get('ecom-products/datatables', [\App\Http\Controllers\Admin\EcomProductController::class, 'datatables'])->name('admin.ecom_products.datatables');
            Route::resource('ecom-products', \App\Http\Controllers\Admin\EcomProductController::class)->names('admin.ecom_products');
            Route::get('ecom-orders/datatables', [\App\Http\Controllers\Admin\EcomOrderController::class, 'datatables'])->name('admin.ecom_orders.datatables');
            Route::resource('ecom-orders', \App\Http\Controllers\Admin\EcomOrderController::class)->names('admin.ecom_orders');
            Route::resource('ecom-inventory', \App\Http\Controllers\Admin\EcomInventoryController::class)->names('admin.ecom_inventory');
            Route::resource('ecom-legal', \App\Http\Controllers\Admin\EcomLegalController::class)->names('admin.ecom_legal');

        });
    });
});
