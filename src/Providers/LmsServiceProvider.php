<?php

namespace Eren\Lms\Providers;

use Eren\Lms\Middleware\Admin;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Routing\Router;

class LmsServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        // Register a middleware group for your package
        $router->middlewareGroup('lms-web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        Fortify::loginView(function () {
            return view('auth.login');
        });
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'lms');

        // load middlewares
        $this->app['router']->aliasMiddleware(
            'admin',
            Admin::class,
        );

        $this->app['router']->aliasMiddleware(
            'ineria',
            \Inertia\Middleware::class,
        );

        $this->app['router']->aliasMiddleware(
            'NoCaptcha',
            \Anhskohbo\NoCaptcha\Facades\NoCaptcha::class,
        );

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'lms');

        // Load migrations
        // $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Publish configuration file (if needed)
        $this->publishes([
            __DIR__ . '/../../config/lms.php' => config_path('lms.php'),
            __DIR__ . '/../../config/setting.php' => config_path('setting.php'),
        ], 'lms_config');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/lms'),
        ], 'lms_views');

        // Publish assets so they can be used in an external Laravel app
        $this->publishes([
            __DIR__ . '/../../resources/css' => resource_path('vendor/lms/css'),
            __DIR__ . '/../../resources/js' => resource_path('vendor/lms/js'),
            __DIR__ . '/../../public/css' => public_path('vendor/lms/css'),
            __DIR__ . '/../../public/js' => public_path('vendor/lms/js'),
        ], 'lms_assets');

        $this->publishes([
            __DIR__ . '/../../lang' => resource_path('lang/vendor/lms'),
        ], 'lms_lang');

        $this->publishes([
            __DIR__ . '/../Middleware/Admin.php' => app_path('Http/Middleware'),
        ], 'lms_admin');

        // Publish Request classes
        $this->publishes([
            __DIR__ . '/../src/Http/Requests' => app_path('Http/Requests/lms'),
        ], 'lms_requests');

        $this->publishes([
            __DIR__ . '/../src/Rules' => app_path('Rules/lms'),
        ], 'lms_rules');

        //  import only header footer and sidebars
        $this->publishes([
            __DIR__ . '/../../resources/views\admin\header.blade.php' => resource_path('views/vendor/lms/admin/header.blade.php'),
            __DIR__ . '/../../resources/views\admin\footer.blade.php' => resource_path('views/vendor/lms/admin/footer.blade.php'),
            __DIR__ . '/../../resources/views\layouts\guest.blade.php' => resource_path('views/vendor/lms/layouts/guest.blade.php'),
            __DIR__ . '/../../resources/views\layouts\guest_user.blade.php' => resource_path('views/vendor/lms/layouts/guest_user.blade.php'),
            __DIR__ . '/../../resources/views\layouts\dashboard_header.blade.php' => resource_path('views/vendor/lms/layouts/dashboard_header.blade.php'),
            __DIR__ . '/../../resources/views\courses\dashboard_header.blade.php' => resource_path('views/vendor/lms/courses/dashboard_header.blade.php'),
            __DIR__ . '/../../resources/views\courses\dashboard_footer.blade.php' => resource_path('views/vendor/lms/courses/dashboard_footer.blade.php'),
        ], 'lms_only_header_footer_sidebar');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'lms_migrations');

        $this->publishes([
            __DIR__ . '/../../src/Console/Commands' => app_path('Console/Commands'),
        ], 'lms_commands');

        $this->publishes([
            __DIR__ . '/../View/Components' => app_path('View/Components'),
            __DIR__ . '/../../resources/css' => resource_path('vendor/lms/css'),
            __DIR__ . '/../../resources/js' => resource_path('vendor/lms/js'),
            __DIR__ . '/../../public/css' => public_path('vendor/lms/css'),
            __DIR__ . '/../../public/js' => public_path('vendor/lms/js'),
            __DIR__ . '/../../config/lms.php' => config_path('lms.php'),
            __DIR__ . '/../../config/setting.php' => config_path('setting.php'),
        ], 'lms_auth_views');
    }
    public function register()
    {
        // Register bindings or services
    }
}
