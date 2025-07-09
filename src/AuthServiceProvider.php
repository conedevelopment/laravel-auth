<?php

namespace Cone\Laravel\Auth;

use Cone\Laravel\Auth\Http\Requests\LoginRequest;
use Cone\Laravel\Auth\Http\Requests\RegisterRequest;
use Cone\Laravel\Auth\Http\Responses\LoginResponse;
use Cone\Laravel\Auth\Http\Responses\LogoutResponse;
use Cone\Laravel\Auth\Http\Responses\RegisterResponse;
use Cone\Laravel\Auth\Interfaces\Requests\LoginRequest as LoginRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\RegisterRequest as RegisterRequestContract;
use Cone\Laravel\Auth\Interfaces\Responses\LoginResponse as LoginResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\LogoutResponse as LogoutResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\RegisterResponse as RegisterResponseContract;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginResponseContract::class, LoginResponse::class);
        $this->app->bind(LoginRequestContract::class, LoginRequest::class);
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
        $this->app->bind(RegisterRequestContract::class, RegisterRequest::class);
        $this->app->bind(RegisterResponseContract::class, RegisterResponse::class);
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
