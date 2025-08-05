@extends('auth::layout')

{{-- Title --}}
@section('title', __('Verify email'))

{{-- Footer --}}
@section('footer')
    <a href="{{ URL::route('password.request') }}">{{ __('Reset password') }}</a>
    <a href="{{ URL::route('login') }}">{{ __('Login') }}</a>
@endsection

{{-- Content --}}
@section('content')
    <form class="site-auth__panel" method="POST" action="{{ URL::route('verification.resend') }}">
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
                    {{ __('Resend verification email') }}
                </button>
            </div>
        </div>
    </form>
@endsection
