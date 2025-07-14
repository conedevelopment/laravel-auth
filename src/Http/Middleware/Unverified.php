<?php

namespace Cone\Laravel\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class Unverified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((bool) $request->user()?->hasVerifiedEmail()) {
            return Redirect::route('login')
                ->with('status', __('Your email has been verified!'));
        }

        return $next($request);
    }
}
