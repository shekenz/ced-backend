<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name') }}@if(View::hasSection('title')) | @yield('title') @endif</title>
        <meta charset=UTF-8>
    </head>
    <body></body>
        <div>
            <h1><a href="{{ route('home')}}">{{ config('app.name') }} Index</a></h1>
            @if (Route::has('login'))
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @endif
            @yield('content')
        </div>
    </body>
</html>