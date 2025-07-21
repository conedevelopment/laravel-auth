<?php

namespace Cone\Laravel\Auth\Http\Middleware;

use Closure;
use Cone\Laravel\Auth\Interfaces\MultiFactorAuthenticatable as Contract;
use Cone\Laravel\Auth\Interfaces\Responses\AuthCodeVerifyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class MultiFactorAuthenticatable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() instanceof Contract) {
            return App::make(AuthCodeVerifyResponse::class)->toResponse($request);
        }

        return $next($request);
    }
}
