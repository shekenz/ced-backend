@extends('layouts/index', [
    'title' => 'index',
])

@section('content')
		<div class="grid grid-cols-9 mx-20">
			<div class="cart-list col-span-5 mr-6 grid grid-cols-2 gap-6">
			<?php $randMax = rand(3,7) ?>
			@for ($i = 0; $i < $randMax; $i++)
				<div>
					<img class="mb-6" src="img/testimage_thumb_{{ rand(1,2) }}.jpg" alt="test thumbnail">
					<p class="mb-6">
						{{ $title }}<br>
						{{ $artist }}
					</p>
					<p class="mb-6">
						Quantity : {{ $quantity }}
					</p>
					<p class="mb-6">
						<a href="#" class="hover:bg-black hover:text-white underline">remove</a>
					</p>
				</div>
			@endfor
			</div>
			<div>
				<a href="#" class="hover:bg-black hover:text-white underline">update cart</a>
			</div>
			<div id="info" class=" col-start-8 col-span-2">
				<p class="mb-6 mr-6">
					subtotal : {{ $subTotal }}
				</p>
				<p class="mb-6 mr-6">
					<a href="#" class="hover:bg-black hover:text-white underline">check out</a>
			</div>
		</div>
	</div>
@stop