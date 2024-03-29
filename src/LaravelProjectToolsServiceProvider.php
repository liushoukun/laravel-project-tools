<?php

namespace Liushoukun\LaravelProjectTools;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Liushoukun\LaravelProjectTools\Http\Middleware\RequestIDMiddleware;
use Liushoukun\LaravelProjectTools\Http\Requests\RequestIDService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class LaravelProjectToolsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function boot() : void
    {
        if (app('config')->get('app.debug')) {
            DB::listen(static function ($query) {
                try {
                    $sql = str_replace("?", "'%s'", $query->sql);
                    $log = vsprintf($sql, $query->bindings ?? []);
                } catch (Throwable $e) {
                    $log = $query->sql;
                }
                Log::debug('sql:' . $log . ' time:' . $query->time);
            });
        }


        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'liushoukun');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'liushoukun');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadMiddlewares();
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        RequestIDService::providerBoot();
    }


    public function loadMiddlewares() : LaravelProjectToolsServiceProvider
    {
        $this->requestIDMiddlewarePriority();
        $this->aliasMiddleware();
        return $this;
    }

    public array $middlewares = [
        'request-id' => RequestIDMiddleware::class
    ];

    public function requestIDMiddlewarePriority() : void
    {
        try {
            $kernel = $this->app->make(Kernel::class);
            $kernel->prependToMiddlewarePriority(RequestIDMiddleware::class);

        } catch (BindingResolutionException $e) {
        }
    }

    public function aliasMiddleware() : void
    {
        try {
            $router = $this->app->make(Router::class);
            foreach ($this->middlewares as $alise => $middleware) {
                $router->aliasMiddleware($alise, $middleware);
            }
        } catch (BindingResolutionException $e) {
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
