<?php

namespace Cone\Laravel\Auth\Http\Controllers;

use Cone\Laravel\Auth\Http\Requests\RegisterRequest;
use Cone\Laravel\Auth\Interfaces\Responses\RegisterResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response as ResponseFactory;

class RegisterController extends Controller
{
    /**
     * Get the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            'guest',
        ];
    }

    /**
     * Show the application registration form.
     */
    public function show(): Response
    {
        return ResponseFactory::view('auth::register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(RegisterRequest $request): RegisterResponse
    {
        $user = $this->createUser($request);

        Event::dispatch(new Registered($user));

        return App::make(RegisterResponse::class);
    }

    /**
     * Create a new user.
     */
    protected function createUser(RegisterRequest $request): mixed
    {
        $model = Config::get('auth.providers.users.model');

        return $model::create(array_merge(
            $request->only(['name', 'email']),
            ['password' => Hash::make($request->input('password'))]
        ));
    }
}
