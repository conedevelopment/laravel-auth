<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>@yield('title') - {{ Config::get('app.name') }}</title>
    {{-- Styles --}}
    @stack('auth::styles')
</head>
<body>
    <main class="site-auth">
        <div class="site-auth__inner">
            <div class="site-auth__header">
                <h2 class="site-auth__title">@yield('title')</h2>
            </div>
            @if($errors->isNotEmpty())
                <p class="alert alert--danger">{{ __('Invalid form data has been submitted!') }}</p>
            @endif
            @if(Session::has('status'))
                <p class="alert alert--info">{{ Session::get('status') }}</p>
            @endif
            @yield('content')
            @hasSection('footer')
                <div class="site-auth__footer">
                    @yield('footer')
                </div>
            @endif
        </div>
    </main>

    {{-- Scripts --}}
    @stack('auth::scripts')
</body>
</html>
