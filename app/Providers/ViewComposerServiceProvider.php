<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

use App\Support\SystemSettings;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if ($view->getName() === 'errors.upload-too-large') return;
            $systemSettings = app(SystemSettings::class)->all();

            // User permistion
            $userPermissions = [];
            if (Auth::check()) {
                $userPermissions =
                    Auth::user()->getAllCheckPermissions()->toArray();
            }
            $composerSystem = [
                'systemSettings' => $systemSettings,
                'companySetting' => fn (string $key, $default = '') => app(SystemSettings::class)->get('company_' . $key, $default),
                'homeContent' => fn (string $key) => $systemSettings['nafu_home_' . $key] ?? '',
                // Backward-compatible alias for remaining legacy templates.
                'arrSetups' => $systemSettings,
                'userPermissions' => $userPermissions,
                'auth' => Auth::user()
            ];

            $view->with($composerSystem);
        });
    }
}
