<?php

namespace Cone\Laravel\Auth\Http\Middleware;

use Closure;
use Cone\Laravel\Auth\Interfaces\Responses\AuthCodeVerifyResponse;
use Cone\Laravel\Auth\Interfaces\VerifiesAuthCodes as Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class VerifiesAuthCodes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() instanceof Contract || ! $request->user()->verifiesAuthCodes()) {
            return App::make(AuthCodeVerifyResponse::class)->toResponse($request);
        }

        return $next($request);
    }
}
