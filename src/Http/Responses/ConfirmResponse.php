<?php

namespace Cone\Laravel\Auth\Http\Responses;

use Cone\Laravel\Auth\Interfaces\Responses\ConfirmResponse as Contract;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Redirect;

class ConfirmResponse implements Contract, Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return Redirect::intended('/');
    }
}
