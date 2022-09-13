<?php

namespace Liushoukun\LaravelProjectTools;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Liushoukun\LaravelProjectTools\Http\Middleware\RequestID;

class LaravelProjectToolsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() : void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'liushoukun');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'liushoukun');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public array $middlewares = [
        'request-id' => RequestID::class
    ];

    public function aliasMiddleware()
    {
        $router = $this->app->make(Router::class);
        foreach ($this->middlewares as $alise => $middleware) {
            $router->aliasMiddleware($alise, $middleware);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-project-tools.php', 'laravel-project-tools');

        // Register the service the package provides.
        $this->app->singleton('laravel-project-tools', function ($app) {
            return new LaravelProjectTools;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() : array
    {
        return [ 'laravel-project-tools' ];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole() : void
    {
        // Publishing the configuration file.
        $this->publishes([
                             __DIR__ . '/../config/laravel-project-tools.php' => config_path('laravel-project-tools.php'),
                         ], 'laravel-project-tools.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/liushoukun'),
        ], 'laravel-project-tools.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/liushoukun'),
        ], 'laravel-project-tools.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/liushoukun'),
        ], 'laravel-project-tools.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
