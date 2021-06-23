<div id="menu-wrapper-under" class="menu-wrapper">
	<div class="menu">
		<h1><a href="{{ route('about') }}" class="{{ (request()->routeIs('about')) ? 'active' : '' }} base-menu-animated">e.p.g.</a></h1>
		<div><a href="{{ route('index') }}" class="{{ (request()->routeIs('index')) ? 'active' : '' }} base-menu-animated">{{ (config('app.env') == 'local') ? 'shop' : 'books'}}</a></div>
		<div><a href="{{ route('messages') }}" class="{{ (request()->routeIs('messages')) ? 'active' : '' }} base-menu-animated">contact</a></div>
		@if(request()->user() || config('app.env') == 'local')
			<div class="md:col-start-4"><a id="cart-menu-item-under" href="{{ route('cart') }}" class="{{ (request()->routeIs('cart')) ? 'active ' : '' }}base-menu-animated">cart{{ (CartHelper::isEmpty()) ? '' : ' ('.CartHelper::count().')' }}</a></div>
			<div class="md:col-start-9 justify-self-end "><a href="#" class="base-menu-link">fr</a> / <a href="#" class="base-menu-link">en</a></div>
		@endif
	</div>
</div>