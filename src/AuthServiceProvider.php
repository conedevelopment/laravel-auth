<?php

namespace Cone\Laravel\Auth;

use Cone\Laravel\Auth\Console\Commands\ClearExpiredAuthCodes;
use Cone\Laravel\Auth\Http\Requests\AuthCodeVerifyRequest;
use Cone\Laravel\Auth\Http\Requests\ConfirmRequest;
use Cone\Laravel\Auth\Http\Requests\ForgotPasswordRequest;
use Cone\Laravel\Auth\Http\Requests\LoginRequest;
use Cone\Laravel\Auth\Http\Requests\RegisterRequest;
use Cone\Laravel\Auth\Http\Requests\ResendRequest;
use Cone\Laravel\Auth\Http\Requests\ResetPasswordRequest;
use Cone\Laravel\Auth\Http\Responses\AuthCodeResendResponse;
use Cone\Laravel\Auth\Http\Responses\AuthCodeVerifyResponse;
use Cone\Laravel\Auth\Http\Responses\ConfirmResponse;
use Cone\Laravel\Auth\Http\Responses\ForgotPasswordResponse;
use Cone\Laravel\Auth\Http\Responses\LoginResponse;
use Cone\Laravel\Auth\Http\Responses\LogoutResponse;
use Cone\Laravel\Auth\Http\Responses\RegisterResponse;
use Cone\Laravel\Auth\Http\Responses\ResendResponse;
use Cone\Laravel\Auth\Http\Responses\ResetPasswordResponse;
use Cone\Laravel\Auth\Http\Responses\VerifyResponse;
use Cone\Laravel\Auth\Interfaces\Models\AuthCode as AuthCodeContract;
use Cone\Laravel\Auth\Interfaces\Requests\AuthCodeVerifyRequest as AuthCodeVerifyRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\ConfirmRequest as ConfirmRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\ForgotPasswordRequest as ForgotPasswordRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\LoginRequest as LoginRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\RegisterRequest as RegisterRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\ResendRequest as ResendRequestContract;
use Cone\Laravel\Auth\Interfaces\Requests\ResetPasswordRequest as ResetPasswordRequestContract;
use Cone\Laravel\Auth\Interfaces\Responses\AuthCodeResendResponse as AuthCodeResendResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\AuthCodeVerifyResponse as AuthCodeVerifyResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\ConfirmResponse as ConfirmResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\ForgotPasswordResponse as ForgotPasswordResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\LoginResponse as LoginResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\LogoutResponse as LogoutResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\RegisterResponse as RegisterResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\ResendResponse as ResendResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\ResetPasswordResponse as ResetPasswordResponseContract;
use Cone\Laravel\Auth\Interfaces\Responses\VerifyResponse as VerifyResponseContract;
use Cone\Laravel\Auth\Models\AuthCode;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthCodeContract::class, AuthCode::class);
        $this->app->bind(AuthCodeResendResponseContract::class, AuthCodeResendResponse::class);
        $this->app->bind(AuthCodeVerifyRequestContract::class, AuthCodeVerifyRequest::class);
        $this->app->bind(AuthCodeVerifyResponseContract::class, AuthCodeVerifyResponse::class);
        $this->app->bind(ConfirmRequestContract::class, ConfirmRequest::class);
        $this->app->bind(ConfirmResponseContract::class, ConfirmResponse::class);
        $this->app->bind(ForgotPasswordRequestContract::class, ForgotPasswordRequest::class);
        $this->app->bind(ForgotPasswordResponseContract::class, ForgotPasswordResponse::class);
        $this->app->bind(LoginRequestContract::class, LoginRequest::class);
        $this->app->bind(LoginResponseContract::class, LoginResponse::class);
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
        $this->app->bind(RegisterRequestContract::class, RegisterRequest::class);
        $this->app->bind(RegisterResponseContract::class, RegisterResponse::class);
        $this->app->bind(ResendRequestContract::class, ResendRequest::class);
        $this->app->bind(ResendResponseContract::class, ResendResponse::class);
        $this->app->bind(ResetPasswordRequestContract::class, ResetPasswordRequest::class);
        $this->app->bind(ResetPasswordResponseContract::class, ResetPasswordResponse::class);
        $this->app->bind(VerifyResponseContract::class, VerifyResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            $this->commands([
                ClearExpiredAuthCodes::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/laravel-auth.php' => $this->app->configPath('laravel-auth.php'),
            ], 'laravel-auth-config');

            $this->publishes([
                __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/laravel-auth'),
            ], 'laravel-auth-views');
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-auth');

        Route::prefix('auth')->middleware('web')->group(function (): void {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
}
