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
    <body class="text-custom text-gray-800">
		<div id="menu-wrapper" class="fixed w-full top-0">
			@auth
			<div class="fixed right-0 bg-green-300 text-green-900 px-1 shadow border border-green-500 text-sm">
				Connecté (<a class="flex-none flash" href="{{ route('users.display', Auth::user()->id)}}">{{ Auth::user()->username }}</a>)
				&middot;
				<a class="flash" href="{{ url('/dashboard') }}">Dashboard</a>
					&middot;
					<a class="flash" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a><form id="logout-form" class="hidden" action="{{ url('/logout') }}" method="POST">{{ csrf_field() }} </form>
			</div>
			@endauth
			<div id="menu" class="grid grid-cols-9 my-12 mx-20">
				<h1><a href="{{ route('about') }}" class="{{ (request()->routeIs('about')) ? 'bg-black text-white ' : '' }}hover:bg-black hover:text-white">e.p.g.</a></h1>
				<div><a href="{{ route('index') }}" class="{{ (request()->routeIs('index')) ? 'bg-black text-white ' : '' }}hover:bg-black hover:text-white">shop</a></div>
				<div><a href="#" class="hover:bg-black hover:text-white">contact</a></div>
				<div class="col-start-8 "><a href="{{ route('cart') }}" class="{{ (request()->routeIs('cart')) ? 'bg-black text-white ' : '' }}hover:bg-black hover:text-white">cart</a></div>
				<div class="justify-self-end "><a href="#" class="hover:bg-black hover:text-white">fr</a> / <a href="#" class="hover:bg-black hover:text-white">en</a></div>
			</div>
		</div>
		<div id="content" class="mt-40">
			@yield('content')
		</div>
    </body>
</html>