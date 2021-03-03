<div id="menu" class="
	grid
	grid-cols-5
	m-4
	md:grid-cols-9
	md:my-8
	md:mx-12
	xl:my-12
	xl:mx-20
">
	<h1><a href="{{ route('about') }}" class="{{ (request()->routeIs('about')) ? 'base-menu-link-active ' : '' }}base-menu-link base-menu-animated">e.p.g.</a></h1>
	<div><a href="{{ route('index') }}" class="{{ (request()->routeIs('index')) ? 'base-menu-link-active ' : '' }}base-menu-link base-menu-animated">shop</a></div>
	<div><a href="#" class="base-menu-link base-menu-animated">contact</a></div>
	<div class="md:col-start-8 "><a href="{{ route('cart') }}" class="{{ (request()->routeIs('cart')) ? 'base-menu-link-active ' : '' }}base-menu-link base-menu-animated">cart</a></div>
	<div class="justify-self-end "><a href="#" class="base-menu-link">fr</a> / <a href="#" class="base-menu-link">en</a></div>
</div>