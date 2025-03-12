<?php

namespace Eren\Lms\Providers;

use Illuminate\Support\ServiceProvider;

class LmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'lms');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Publish configuration file (if needed)
        $this->publishes([
            __DIR__.'/../../config/lms.php' => config_path('lms.php'),
        ], 'config');
    }

    public function register()
    {
        // Register bindings or services
    }
}