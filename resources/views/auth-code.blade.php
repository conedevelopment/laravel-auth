@extends('auth::layout')

{{-- Title --}}
@section('title', __('Verify Auth Code'))

{{-- Content --}}
@section('content')
    <form class="site-auth__panel" method="POST" action="{{ URL::route('auth-code.verify') }}">
        @csrf
        <div class="form-group-stack">
            <div class="form-group">
                <label class="form-label" for="email">{{ __('Code') }}</label>
                <input
                    @class(['form-control', 'form-control--lg', 'form-control--invalid' => $errors->has('code')])
                    id="code"
                    type="number"
                    name="code"
                    required
                    value="{{ Request::old('code', $code) }}"
                >
                @error('code')
                    <span class="field-feedback field-feedback--invalid">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-check form-check--lg" for="trust">
                    <input class="form-check__control" id="trust" type="checkbox" name="trust" value="1">
                    <span class="form-label form-check__label">{{ __('Trust in this browser') }}</span>
                </label>
            </div>
            <div class="form-group">
                <button class="btn btn--primary btn--block btn--primary-shadow">
                    {{ __('Verify') }}
                </button>
            </div>
        </div>
    </form>
@endsection

{{-- Footer --}}
@section('footer')
    <form method="POST" action="{{ URL::route('logout') }}">
        @csrf
        <div class="form-group">
            <button type="submit" class="btn btn--light btn--sm">
                {{ __('Logout') }}
            </button>
        </div>
    </form>

    <form method="POST" action="{{ URL::route('auth-code.resend') }}">
        @csrf
        <div class="form-group">
            <button type="submit" class="btn btn--light btn--sm">
                {{ __('Resend Auth Code') }}
            </button>
        </div>
    </form>
@endsection
