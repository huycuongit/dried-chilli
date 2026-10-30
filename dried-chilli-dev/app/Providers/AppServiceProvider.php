<?php

namespace App\Providers;

use App\Support\SystemSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SystemSettings::class, function () {
            return new SystemSettings();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $appUrl = rtrim((string) config('app.url'), '/');
        $scheme = parse_url($appUrl, PHP_URL_SCHEME);

        if ($appUrl !== '' && in_array($scheme, ['http', 'https'], true)) {
            URL::forceRootUrl($appUrl);
            URL::forceScheme($scheme);
        }
    }
}
