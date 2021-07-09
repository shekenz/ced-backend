<div id="menu-wrapper-under" class="menu-wrapper">
	<div id="menu-under" class="menu">
		<h1><a href="{{ route('about') }}" class="{{ (request()->routeIs('about')) ? 'active' : '' }} menu-item-under">e.p.g.</a></h1>
		<div><a href="{{ route('index') }}" class="{{ (request()->routeIs('index')) ? 'active' : '' }} menu-item-under">{{ (config('app.env') == 'local') ? 'shop' : 'books'}}</a></div>
		<div><a href="{{ route('messages') }}" class="{{ (request()->routeIs('messages')) ? 'active' : '' }} menu-item-under">contact</a></div>
		@if(request()->user() || config('app.env') == 'local')
			@if(setting('app.shop.enabled'))
			<div class="md:col-start-4"><a id="cart-menu-item-under" href="{{ route('cart') }}" class="{{ (request()->routeIs('cart')) ? 'active ' : '' }} menu-item-under">cart{{ (CartHelper::isEmpty()) ? '' : ' ('.CartHelper::count().')' }}</a></div>
			@endif
			<div class="md:col-start-9 justify-self-end "><a href="#">fr</a> / <a href="#">en</a></div>
		@endif
	</div>
</div>