<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Compatibility provider for servers that still have the former provider
 * name stored in bootstrap/cache. Global view data now comes from the
 * application's view composer, so this provider intentionally does nothing.
 */
class GlobalVariablesServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Kept temporarily so an old production cache can boot and be cleared.
    }

    public function boot()
    {
        // Global variables are registered by the current view composer.
    }
}
