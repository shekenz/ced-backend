<div id="menu" class="grid grid-cols-9 my-12 mx-20">
	<h1><a href="{{ route('about') }}" class="{{ (request()->routeIs('about')) ? 'bg-black text-white ' : '' }}hover:bg-black hover:text-white">e.p.g.</a></h1>
	<div><a href="{{ route('index') }}" class="{{ (request()->routeIs('index')) ? 'bg-black text-white ' : '' }}hover:bg-black hover:text-white">shop</a></div>
	<div><a href="#" class="hover:bg-black hover:text-white">contact</a></div>
	<div class="col-start-8 "><a href="{{ route('cart') }}" class="{{ (request()->routeIs('cart')) ? 'bg-black text-white ' : '' }}hover:bg-black hover:text-white">cart</a></div>
	<div class="justify-self-end "><a href="#" class="hover:bg-black hover:text-white">fr</a> / <a href="#" class="hover:bg-black hover:text-white">en</a></div>
</div>