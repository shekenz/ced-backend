<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>{{ env('APP_NAME') }}@if(View::hasSection('title')) | @yield('title') @endif</title>
        <meta charset=UTF-8>
    </head>
    <body></body>
        <div>
            <h1>{{ env('APP_NAME') }} Index</h1>
            @if (Route::has('login'))
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @endif
            @yield('content')
        </div>
    </body>
</html>