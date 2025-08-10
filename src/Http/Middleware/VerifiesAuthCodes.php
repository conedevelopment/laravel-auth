<?php

namespace Cone\Laravel\Auth\Http\Middleware;

use Closure;
use Cone\Laravel\Auth\Interfaces\VerifiesAuthCodes as Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        if (! $request->user() instanceof Contract
            || ! $request->user()->verifiesAuthCodes()
            || $request->cookie('device_token') === sha1(sprintf('%s:%s', $request->user()->getKey(), $request->user()->email))
            || $request->session()->has('auth.code-verified')
        ) {
            return $next($request);
        }

        return Redirect::route('auth-code.show');
    }
}
