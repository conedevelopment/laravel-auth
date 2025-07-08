<?php

namespace Cone\Laravel\Auth\Http\Responses;

use Closure;
use Cone\Laravel\Auth\Interfaces\Responses\LoginResponse as Contract;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class LoginResponse implements Contract, Responsable
{
    /**
     * The response resolver.
     */
    protected static ?Closure $responseResolver;

    /**
     * Create a new method.
     */
    public static function resolveUsing(Closure $callback): void
    {
        static::$responseResolver = $callback;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $callback = static::$responseResolver ?? function (): RedirectResponse {
            return Redirect::intended('/');
        };

        return call_user_func_array($callback, [$request]);
    }
}
