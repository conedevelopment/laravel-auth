<?php

namespace Cone\Package;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            $this->commands([
                //
            ]);

            $this->publishes([
                __DIR__.'/../config/laravel-auth.php' => $this->app->configPath('laravel-auth.php'),
            ], 'laravel-auth-config');

            $this->publishes([
                __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/laravel-auth'),
            ], 'laravel-auth-views');
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-auth');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
