<?php

namespace OmarChouman\LaravelPermissionEditor;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use OmarChouman\LaravelPermissionEditor\Http\Middleware\SpatiePermissionMiddleware;

class PermissionEditorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        Route::prefix('permission-editor')
            ->as('permission-editor.')
            ->middleware(config('permission-editor.middleware', ['web', 'spatie-permission']))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'permission-editor');

        if ($this->app->runningInConsole()) {
            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/permission-editor'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('permission-editor'),
            ], 'assets');

            // Publishing the config files.
            $this->publishes([
                __DIR__.'/../config/permission-editor.php' => config_path('permission-editor.php'),
            ], 'permission-editor-config');
        }

        // Register middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('spatie-permission', SpatiePermissionMiddleware::class);
    }
}
