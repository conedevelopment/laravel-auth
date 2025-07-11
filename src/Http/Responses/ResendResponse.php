<?php

namespace Cone\Laravel\Auth\Http\Responses;

use Cone\Laravel\Auth\Interfaces\Responses\VerifyResponse as Contract;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Redirect;

class ResendResponse implements Contract, Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return Redirect::route('verification.show')
            ->with('status', __('The verification link has been emailed to you.'));
    }
}
