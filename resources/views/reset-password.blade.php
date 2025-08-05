@extends('auth::layout')

{{-- Title --}}
@section('title', __('Reset password'))

{{-- Footer --}}
@section('footer')
    <a href="{{ URL::route('register') }}">{{ __('Register') }}</a>
    <a href="{{ URL::route('login') }}">{{ __('Login') }}</a>
@endsection

{{-- Content --}}
@section('content')
    <form class="site-auth__panel" method="POST" action="{{ URL::route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group-stack">
            <div class="form-group">
                <label class="form-label" for="email">{{ __('E-mail') }}</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    readonly
                    value="{{ $email }}"
                    @class(['form-control', 'form-control--invalid' => $errors->has('email')])
                >
                @error('email')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    autofocus
                    @class(['form-control', 'form-control--invalid' => $errors->has('password')])
                >
                @error('password')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">{{ __('Password confirmation') }}</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    @class(['form-control', 'form-control--invalid' => $errors->has('password_confirmation')])
                >
                @error('password_confirmation')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <button class="btn btn--primary btn--primary-shadow btn--block" type="submit">
                    {{ __('Reset password') }}
                </button>
            </div>
        </div>
    </form>
@endsection
