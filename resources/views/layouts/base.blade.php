<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>
            {{ config('app.name') }}
            @if(config('app.env') == 'local') (Dev) @endif
            @if(isset($title)) | {{ $title }} @endif
        </title>
        <meta charset=UTF-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @if(config('app.env') == 'local')
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @else {{-- Cache bustin in production --}}
            <link rel="stylesheet" href="{{ asset(mix('css/app.css'), true) }}">
        @endif
    </head>
    <body></body>
        <div class="">
            <div class="flex bg-green-300 text-green-900 py-1 px-3 shadow border-b border-green-500">
                @auth
                    <a class="flex-none flash" href="{{ route('users.display', Auth::user()->id)}}">{{ Auth::user()->username }}</a>, vous êtes connecté !
                @endauth
                <span class="flex-grow"></span>
            @if (Route::has('login'))
                <div class="flex-none">
                    <a class="flash" href="{{ url('/dashboard') }}">Dashboard</a>
                    @auth
                        &middot;
                        <a class="flash" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a><form id="logout-form" class="hidden" action="{{ url('/logout') }}" method="POST">{{ csrf_field() }} </form>
                    @endauth
                </div>
            @endif
            </div>
            @yield('content')
        </div>
    </body>
</html>