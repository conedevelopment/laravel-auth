<?php

namespace Cone\Laravel\Auth;

use Cone\Laravel\Auth\Http\Requests\ConfirmRequest;
use Cone\Laravel\Auth\Http\Requests\ForgotPasswordRequest;
use Cone\Laravel\Auth\Http\Requests\LoginRequest;
use Cone\Laravel\Auth\Http\Requests\RegisterRequest;
use Cone\Laravel\Auth\Http\Requests\ResendRequest;
use Cone\Laravel\Auth\Http\Responses\ConfirmResponse;
use Cone\Laravel\Auth\Http\Responses\ForgotPasswordResponse;
use Cone\Laravel\Auth\Http\Responses\LoginResponse;
use Cone\Laravel\Auth\Http\Responses\LogoutResponse;
use Cone\Laravel\Auth\Http\Responses\RegisterResponse;
use Cone\Laravel\Auth\Http\Responses\ResendResponse;
use Cone\Laravel\Auth\Http\Responses\VerifyResponse;
use Cone\Laravel\Auth\Interfaces\Requests\ConfirmRequest as ConfirmRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\ForgotPasswordRequest as ForgotPasswordRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\LoginRequest as LoginRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\RegisterRequest as RegisterRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\ResendRequest as ResendRequestContract;
use Cone\Laravel\Auth\Interfaces\Responses\ConfirmResponse as ConfirmResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\ForgotPasswordResponse as ForgotPasswordResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\LoginResponse as LoginResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\LogoutResponse as LogoutResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\RegisterResponse as RegisterResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\ResendResponse as ResendResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\VerifyResponse as VerifyResponseContract;
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
        $this->app->bind(VerifyResponseContract::class, VerifyResponse::class);
        $this->app->bind(ResendResponseContract::class, ResendResponse::class);
        $this->app->bind(ResendRequestContract::class, ResendRequest::class);
        $this->app->bind(ConfirmRequestContract::class, ConfirmRequest::class);
        $this->app->bind(ConfirmResponseContract::class, ConfirmResponse::class);
        $this->app->bind(ForgotPasswordResponseContract::class, ForgotPasswordResponse::class);
        $this->app->bind(ForgotPasswordRequestContract::class, ForgotPasswordRequest::class);
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
