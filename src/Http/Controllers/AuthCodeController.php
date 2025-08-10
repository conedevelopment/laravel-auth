<?php

namespace Cone\Laravel\Auth\Http\Controllers;

use Closure;
use Cone\Laravel\Auth\Interfaces\Requests\AuthCodeVerifyRequest;
use Cone\Laravel\Auth\Interfaces\Responses\AuthCodeResendResponse;
use Cone\Laravel\Auth\Interfaces\Responses\AuthCodeVerifyResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class AuthCodeController extends Controller
{
    /**
     * Get the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('throttle:6,1', only: ['resend']),
            new Middleware(static function (Request $request, Closure $next): BaseResponse {
                if (! $request->user()->verifiesAuthCodes()) {
                    return App::make(AuthCodeVerifyResponse::class);
                }

                return $next($request);
            }),
        ];
    }

    /**
     * Show the verification resend form.
     */
    public function show(Request $request): Response
    {
        return ResponseFactory::view('auth::auth-code', [
            'code' => $request->input('code'),
        ]);
    }

    /**
     * Verify the link.
     */
    public function verify(AuthCodeVerifyRequest $request): AuthCodeVerifyResponse
    {
        $request->session()->put('auth.auth-code', true);

        $request->user()->authCodes()->delete();

        if ($request->boolean('trust')) {
            Cookie::queue(
                'device_token',
                sha1(sprintf('%s:%s', $request->user()->getKey(), $request->user()->email)),
                Date::now()->addMonth()->diffInMinutes(absolute: true),
            );
        }

        return App::make(AuthCodeVerifyResponse::class);
    }

    /**
     * Resend the verification link.
     */
    public function resend(Request $request): AuthCodeResendResponse
    {
        $code = $request->user()->generateAuthCode();

        $request->user()->sendAuthCodeNotification($code);

        return App::make(AuthCodeResendResponse::class);
    }
}
