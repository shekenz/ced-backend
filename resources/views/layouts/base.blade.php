<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>@if(View::hasSection('title')) CE.D | @yield('title') @else CE.D @endif</title>
        <meta charset=UTF-8>
    </head>
    <body></body>
        <div>
            <h1>CE.D Index</h1>
            @if (Route::has('login'))
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @endif
            @yield('content')
        </div>
    </body>
</html>