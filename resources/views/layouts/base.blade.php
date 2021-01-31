<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name') }}@if(View::hasSection('title')) | @yield('title') @endif</title>
        <meta charset=UTF-8>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body></body>
        <div>
            <div class="flex bg-green-300 text-green-900 p-3">
                <h1 class="flex-none text-2xl"><a href="{{ route('home')}}">{{ config('app.name') }} Index</a></h1>
                <span class="flex-grow"></span>
            @if (Route::has('login'))
                <a class="flex-none underline" href="{{ url('/dashboard') }}">Dashboard</a>
            @endif
            </div>
            @yield('content')
        </div>
    </body>
</html>