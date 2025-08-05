@extends('auth::layout')

{{-- Title --}}
@section('title', __('Register'))

{{-- Footer --}}
@section('footer')
    <a href="{{ URL::route('password.request') }}">{{ __('Reset password') }}</a>
    <a href="{{ URL::route('login') }}">{{ __('Login') }}</a>
@endsection

{{-- Content --}}
@section('content')
    <form class="site-auth__panel" method="POST" action="{{ URL::route('register') }}">
        @csrf
        <div class="form-group-stack">
            <div class="form-group">
                <label class="form-label" for="email">{{ __('Name') }}</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    autofocus
                    value="{{ Request::old('name') }}"
                    @class(['form-control', 'form-control--invalid' => $errors->has('name')])
                >
                @error('name')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">{{ __('E-mail') }}</label>
                <input
                    type="email"
                    id="email"
                    name="email"
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
                <label class="form-check form-check--lg" for="consent">
                    <input class="form-check__control" type="checkbox" name="consent" id="consent" value="1">
                    <span class="form-label form-check__label">{{ __('I accept the term and conditions.') }}</span>
                </label>
                @error('consent')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <button class="btn btn--primary btn--primary-shadow btn--block" type="submit">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </form>
@endsection
