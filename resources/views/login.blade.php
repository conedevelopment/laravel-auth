@extends('laravel-auth::layout')

{{-- Title --}}
@section('title', __('Login'))

{{-- Footer --}}
@section('footer')
    <a href="{{ URL::route('password.request') }}">{{ __('Reset password') }}</a>
    <a href="{{ URL::route('register') }}">{{ __('Register') }}</a>
@endsection

{{-- Content --}}
@section('content')
    <form class="site-auth__panel" method="POST" action="{{ URL::route('login') }}">
        @csrf
        <div class="form-group-stack">
            <div class="form-group">
                <label class="form-label" for="email">{{ __('E-mail') }}</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    autofocus
                    value="{{ Request::old('email') }}"
                    @class(['form-control', 'form-control--invalid' => $errors->has('email')])
                >
                @error('email')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    @class(['form-control', 'form-control--invalid' => $errors->has('password')])
                >
                @error('password')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-check form-check--lg" for="remember">
                    <input class="form-check__control" type="checkbox" name="remember" id="remember">
                    <span class="form-label form-check__label">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="form-group">
                <button class="btn btn--primary btn--primary-shadow btn--block" type="submit">
                    {{ __('Login') }}
                </button>
            </div>
        </div>
    </form>
@endsection
