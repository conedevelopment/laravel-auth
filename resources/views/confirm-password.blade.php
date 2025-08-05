@extends('auth::layout')

{{-- Title --}}
@section('title', __('Confirm'))

{{-- Content --}}
@section('content')
    <form class="site-auth__panel" method="POST" action="{{ URL::route('password.confirm') }}">
        @csrf
        <div class="form-group-stack">
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
                <button class="btn btn--primary btn--primary-shadow btn--block" type="submit">
                    {{ __('Confirm password') }}
                </button>
            </div>
        </div>
    </form>
@endsection
