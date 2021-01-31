<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name') }}@if(View::hasSection('title')) | @yield('title') @endif</title>
        <meta charset=UTF-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body></body>
        <div class="sm:h-4">
            <div class="flex bg-green-300 text-green-900 p-3 shadow border-b border-green-500">
                <h1 class="flex-none text-2xl sm:text-lg"><a href="{{ route('home')}}">{{ config('app.name') }} Index</a></h1>
                <span class="flex-grow"></span>
            @if (Route::has('login'))
                <div class="flex-none">
                    <a class="underline" href="{{ url('/dashboard') }}">Dashboard</a>
                    @auth
                    &middot;
                    <a class="underline" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a><form id="logout-form" class="hidden" action="{{ url('/logout') }}" method="POST">{{ csrf_field() }} </form>
                    @endauth
                </div>
            @endif
            </div>
            @yield('content')
        </div>
    </body>
</html>