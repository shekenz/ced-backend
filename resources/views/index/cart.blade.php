<x-index-layout lang="FR_fr">

	<?php $randMax = rand(3,7) ?>

	<x-slot name="title">Cart ({{ $randMax }})</x-slot>

	<div class="md:grid md:grid-cols-9 md:items-start">
		<div class="cart-list md:col-span-5 md:mr-6 md:grid md:grid-cols-2 md:gap-6">
		
		@for ($i = 0; $i < $randMax; $i++)
			@include('index.cart-article')
		@endfor
		</div>
		<div id="info" class="grid grid-cols-2 mb-16 mt-6 md:col-start-6 md:col-span-4 md:mb-0 md:mt-0">
			<p class="row-start-2 md:row-start-1 md:col-start-1">
				<a href="#" class="base-link">Update cart</a>
			</p>
			<p class="col-start-2 text-right mb-6 md:row-start-1 md:col-start-2 md:text-left md:mr-6">
				Subtotal : {{ $subTotal }}€
			</p>
			<p class="row-start-2 col-start-2 text-right md:text-left mb-6 md:mr-6">
				<a href="#" class="base-link">Check out</a>
			</p>
		</div>
	</div>
</x-index-layout>