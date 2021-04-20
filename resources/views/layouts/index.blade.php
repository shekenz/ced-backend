<!doctype html>
<html {{ $attributes }}>
    <head>
		<script type="text/javascript">
			// On page load or when changing themes, best to add inline in `head` to avoid FOUC
			// If theme = dark in storage OR (if no theme in storage AND os is in darkmode)
			if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
				document.documentElement.classList.add('dark')
			} else {
				document.documentElement.classList.remove('dark')
			}
		</script>
        <title>
            {{ config('app.name') }}
            @if(config('app.env') == 'local') (Dev) @endif
            @if(isset($title)) | {{ $title }} @endif
        </title>
        <meta charset=UTF-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

        @if(config('app.env') == 'local')
            <link rel="stylesheet" href="{{ asset('css/index.css') }}">
			<script src="{{ asset('js/index.js') }}" defer></script>
        @else {{-- Cache bustin in production --}}
            <link rel="stylesheet" href="{{ asset(mix('css/index.css'), true) }}">
			<script src="{{ asset(mix('js/index.js'), true) }}" defer></script>
        @endif
		@auth
			<script src="{{ asset('js/front.js') }}" defer></script>
		@endauth
		@if(isset($scripts))
			{{ $scripts }}
		@endif
    </head>
    <body class="text-custom-md lg:text-custom text-gray-800 dark:bg-black dark:text-dark-200">
		<div id="menu-wrapper" class="fixed w-full top-0">
			@auth
			<div id="user-menu" class="fixed w-full base-connected">
				<a id="hide-button" class="base-con-link hideable" title="Hide this menu" href="#"><x-tabler-eye-off class="pb-1 inline w-5 h-5" /></a>
				<a id="unhide-button" class="base-con-link hideable hidden" title="Un-hide this menu" href="#"><x-tabler-eye class="pb-1 inline w-5 h-5" /></a>
				<a class="flex-none base-con-link hideable" href="{{ route('users.display', Auth::user()->id)}}"><x-tabler-user class="pb-1 ml-2 mr-1 inline w-5 h-5" />{{ Auth::user()->username }}</a>
				<a class="base-con-link hideable" href="{{ url('/dashboard') }}"><x-tabler-gauge class="pb-1 ml-2 mr-1 inline w-5 h-5" />{{ __('Dashboard') }}</a>
				<a class="base-con-link hideable" href="{{ url('/dashboard') }}"><x-tabler-mail class="pb-1 ml-2 mr-1 inline w-5 h-5" />{{ __('Messages') }}</a>
				<a class="base-con-link hideable" href="{{ url('/dashboard') }}"><x-tabler-receipt class="pb-1 ml-2 mr-1 inline w-5 h-5" />{{ __('Orders') }}</a>
				<a class="base-con-link hideable" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><x-tabler-logout class="pb-1 ml-2 mr-1 inline w-5 h-5" />{{ __('Logout') }}</a><form id="logout-form" class="hidden" action="{{ url('/logout') }}" method="POST">{{ csrf_field() }} </form>
			</div>
			@endauth
			@include('index.menu')
		</div>
		<div id="content" class="mx-4 pb-16 mt-16 md:pb-12 md:mt-24 xl:mt-40 md:mx-12 xl:mx-20">
			{{ $slot }}
		</div>
		<div id="footer" class="fixed bottom-4 right-4  md:bottom-8 md:right-12 xl:bottom-12 xl:right-20">
			<a id="fun" href="{{ route('about') }}"><img  class="block dark:hidden w-10 md:w-14 xl:w-auto" srcset="{{ asset('img/logo.png') }} 1x, {{ asset('img/logo@2x.png') }} 2x" src="{{ asset('img/logo.png') }}" alt="epg logo"><img  class="hidden dark:block w-10 md:w-14 xl:w-auto" srcset="{{ asset('img/logo-dark.png') }} 1x, {{ asset('img/logo-dark@2x.png') }} 2x" src="{{ asset('img/logo-dark.png') }}" alt="epg logo"></a>
		</div>
    </body>
</html>