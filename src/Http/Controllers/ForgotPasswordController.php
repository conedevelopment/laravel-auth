<?php

namespace Cone\Laravel\Auth\Http\Controllers;

use Cone\Laravel\Auth\Interfaces\Requests\ForgotPasswordRequest;
use Cone\Laravel\Auth\Interfaces\Responses\ForgotPasswordResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response as ResponseFactory;

class ForgotPasswordController extends Controller
{
    /**
     * Get the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('throttle:6,1', only: ['send']),
        ];
    }

    /**
     * Display the form to request a password reset link.
     */
    public function show(): Response
    {
        return ResponseFactory::view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function send(ForgotPasswordRequest $request): ForgotPasswordResponse
    {
        $data = $request->validated();

        Password::broker()->sendResetLink(['email' => $data['email']]);

        return App::make(ForgotPasswordResponse::class);
    }
}
