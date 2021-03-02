<!doctype html>
<html {{ $attributes }}>
    <head>
        <title>
            {{ config('app.name') }}
            @if(config('app.env') == 'local') (Dev) @endif
            @if(isset($title)) | {{ $title }} @endif
        </title>
        <meta charset=UTF-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="icon" type="image/png" href="{{ asset('img/favicon32.png') }}">

        @if(config('app.env') == 'local')
            <link rel="stylesheet" href="{{ asset('css/index.css') }}">
			<script src="{{ asset('js/index.js') }}" defer></script>
        @else {{-- Cache bustin in production --}}
            <link rel="stylesheet" href="{{ asset(mix('css/index.css'), true) }}">
			<script src="{{ asset(mix('js/index.js'), true) }}" defer></script>
        @endif
        
    </head>
    <body class="text-custom text-gray-800">
		<div id="menu-wrapper" class="fixed w-full top-0">
			@auth
			<div class="fixed right-0 bg-green-300 text-green-900 px-1 shadow border border-green-500 text-sm">
				Connecté (<a class="flex-none base-con-link" href="{{ route('users.display', Auth::user()->id)}}">{{ Auth::user()->username }}</a>)
				&middot;
				<a class="base-con-link" href="{{ url('/dashboard') }}">Dashboard</a>
					&middot;
					<a class="base-con-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a><form id="logout-form" class="hidden" action="{{ url('/logout') }}" method="POST">{{ csrf_field() }} </form>
			</div>
			@endauth
			@include('index.menu')
		</div>
		<div id="content" class="mt-40">
			{{ $slot }}
		</div>
    </body>
</html>