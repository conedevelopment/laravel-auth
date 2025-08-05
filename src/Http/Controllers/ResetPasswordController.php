<?php

namespace Cone\Laravel\Auth\Http\Controllers;

use Cone\Laravel\Auth\Interfaces\Requests\ResetPasswordRequest;
use Cone\Laravel\Auth\Interfaces\Responses\ResetPasswordResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view for the given token.
     */
    public function show(Request $request): Response
    {
        return ResponseFactory::view('auth::reset-password', [
            'email' => $request->route()->parameter('email'),
            'token' => $request->route()->parameter('token'),
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(ResetPasswordRequest $request): RedirectResponse|ResetPasswordResponse
    {
        $response = Password::broker()->reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function (Authenticatable $user, #[\SensitiveParameter] string $password): void {
                $this->resetPassword($user, $password);

                if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }
            }
        );

        return $response == Password::PASSWORD_RESET
            ? App::make(ResetPasswordResponse::class)
            : Redirect::back()->withInput($request->only(['email']))->withErrors(['email' => __($response)]);
    }

    /**
     * Reset the given user's password.
     */
    protected function resetPassword(Authenticatable $user, #[\SensitiveParameter] string $password): void
    {
        $user->setAttribute('password', Hash::make($password));

        $user->setRememberToken(Str::random(60));

        $user->save();

        Event::dispatch(new PasswordReset($user));

        Auth::guard()->login($user);
    }
}
