<x-index-layout lang="FR_fr">

	<?php $randMax = rand(3,7) ?>

	<x-slot name="title">Cart ({{ $randMax }})</x-slot>

	<div class="grid grid-cols-9 mx-20">
		<div class="cart-list col-span-5 mr-6 grid grid-cols-2 gap-6">
		
		@for ($i = 0; $i < $randMax; $i++)
			@include('index.cart-article')
		@endfor
		</div>
		<div>
			<a href="#" class="base-link">update cart</a>
		</div>
		<div id="info" class=" col-start-8 col-span-2">
			<p class="mb-6 mr-6">
				subtotal : {{ $subTotal }}
			</p>
			<p class="mb-6 mr-6">
				<a href="#" class="base-link">check out</a>
			</p>
		</div>
	</div>
</x-index-layout>