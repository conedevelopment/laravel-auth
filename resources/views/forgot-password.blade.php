@extends('laravel-auth::layout')

{{-- Title --}}
@section('title', __('Forgot password'))

{{-- Footer --}}
@section('footer')
    <a href="{{ URL::route('register') }}">{{ __('Register') }}</a>
    <a href="{{ URL::route('login') }}">{{ __('Login') }}</a>
@endsection

{{-- Content --}}
@section('content')
    <form class="site-auth__panel" method="POST" action="{{ URL::route('password.email') }}">
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
                <button class="btn btn--primary btn--primary-shadow btn--block" type="submit">
                    {{ __('Reset password') }}
                </button>
            </div>
        </div>
    </form>
@endsection
