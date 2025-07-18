<?php

namespace Cone\Laravel\Auth\Http\Responses;

use Cone\Laravel\Auth\Interfaces\Responses\ForgotPasswordResponse as Contract;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;

class ForgotPasswordResponse implements Contract, Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return Redirect::route('password.request')
            ->with('status', __(Password::RESET_LINK_SENT));
    }
}
