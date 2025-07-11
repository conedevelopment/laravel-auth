<?php

namespace Cone\Laravel\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Cone\Laravel\Auth\Interfaces\Responses\ResendResponse;
use Cone\Laravel\Auth\Interfaces\Responses\VerifyResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response as ResponseFactory;

class VerificationController extends Controller
{
    /**
     * Get the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('signed', only: ['verify']),
            new Middleware('throttle:6,1', only: ['verify', 'resend']),
        ];
    }

    /**
     * Show the email verification notice.
     */
    public function show(Request $request): Response|RedirectResponse
    {
        return (bool) $request->user()?->hasVerifiedEmail()
            ? ResponseFactory::redirectToRoute('login')
            : ResponseFactory::view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(Request $request): VerifyResponse
    {
        $model = Config::get('auth.providers.users.model');

        $user = $model::query()->findOrFail($request->route('id'));

        if (! hash_equals($request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if (! $user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            Event::dispatch(new Verified($user));
        }

        return App::make(VerifyResponse::class);
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request): ResendResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $model = Config::get('auth.providers.users.model');

        $user = $model::query()->where('email', $data['email'])->first();

        if (! (bool) $user?->hasVerifiedEmail()) {
            $user?->sendEmailVerificationNotification();
        }

        return App::make(ResendResponse::class);
    }
}
