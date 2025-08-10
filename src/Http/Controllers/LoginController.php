<?php

namespace Cone\Laravel\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Cone\Laravel\Auth\Interfaces\Requests\LoginRequest;
use Cone\Laravel\Auth\Interfaces\Responses\LoginResponse;
use Cone\Laravel\Auth\Interfaces\Responses\LogoutResponse;
use Cone\Laravel\Auth\Interfaces\VerifiesAuthCodes;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Get the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['logout']),
        ];
    }

    /**
     * Show the application's login form.
     */
    public function show(): Response
    {
        return ResponseFactory::view('auth::login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(LoginRequest $request): LoginResponse
    {
        if (! Auth::guard()->attempt($request->only(['email', 'password']), $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        if (! Auth::guard()->user()->hasVerifiedEmail()) {
            return $this->logout($request)->withErrors([
                'email' => __('auth.unverified'),
            ]);
        }

        $request->session()->regenerate();

        if ($request->user() instanceof VerifiesAuthCodes && $request->user()->verifiesAuthCodes()) {
            $request->user()->sendAuthCodeNotification($request->user()->generateAuthCode());
        }

        Event::dispatch(
            new Login(Auth::getDefaultDriver(), $request->user(), $request->filled('remember'))
        );

        return App::make(LoginResponse::class);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): LogoutResponse
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return App::make(LogoutResponse::class);
    }
}
