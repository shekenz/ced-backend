<div id="menu" class="
	grid
	grid-cols-5
	m-4
	md:grid-cols-9
	md:my-8
	md:mx-12
	xl:my-12
	xl:mx-20
	z-0
">
	<h1><a href="{{ route('about') }}" class="{{ (request()->routeIs('about')) ? 'base-menu-link-active' : '' }} base-menu-link base-menu-animated">e.p.g.</a></h1>
	<div><a href="{{ route('index') }}" class="{{ (request()->routeIs('index')) ? 'base-menu-link-active' : '' }} base-menu-link base-menu-animated">{{ (config('app.env') == 'local') ? 'shop' : 'books'}}</a></div>
	<div><a href="{{ route('messages') }}" class="base-menu-link {{ (request()->routeIs('messages')) ? 'base-menu-link-active' : '' }} base-menu-animated">contact</a></div>
	@if(request()->user() || config('app.env') == 'local')
		<div class="md:col-start-8 "><a id="cart-menu-item" href="{{ route('cart') }}" class="{{ (request()->routeIs('cart')) ? 'base-menu-link-active ' : '' }}base-menu-link base-menu-animated">cart{{ (CartHelper::isEmpty()) ? '' : ' ('.CartHelper::count().')' }}</a></div>
		<div class="justify-self-end "><a href="#" class="base-menu-link">fr</a> / <a href="#" class="base-menu-link">en</a></div>
	@endif
</div>