<?php

namespace Cone\Laravel\Auth\Http\Controllers;

use Cone\Laravel\Auth\Interfaces\Requests\ConfirmRequest;
use Cone\Laravel\Auth\Interfaces\Responses\ConfirmResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response as ResponseFactory;

class ConfirmPasswordController extends Controller
{
    /**
     * Get the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    /**
     * Display the password confirmation view.
     */
    public function show(): Response
    {
        return ResponseFactory::view('auth.confirm-password');
    }

    /**
     * Confirm the given user's password.
     */
    public function confirm(ConfirmRequest $request): ConfirmResponse
    {
        $request->session()->put('auth.password_confirmed_at', time());

        return App::make(ConfirmResponse::class);
    }
}
