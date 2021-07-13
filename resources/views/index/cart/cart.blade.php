<x-index-layout lang="FR_fr">

	<x-slot name="scripts">
		<script src="https://www.paypal.com/sdk/js?client-id={{ setting('app.paypal.client-id') }}&currency=EUR&disable-funding=credit,card,bancontact,blik,eps,giropay,ideal,mercadopago,mybank,p24,sepa,sofort,venmo"></script>
		<script src="{{ asset('js/cart.js') }}" defer></script>
	</x-slot>

	<x-slot name="title">Cart ({{ CartHelper::count() }})</x-slot>
	
		@if($books->isNotEmpty())
		<div id="cart-wrapper" class="md:grid md:grid-cols-9 md:items-start">
			<div id="cart" class="cart-list md:col-span-5 md:mr-6 md:grid md:grid-cols-2 md:gap-6">
			@php
				$total = 0;
			@endphp
			@foreach($books as $article)
				@php
					$total += $article['price'] * $article['cartQuantity'];
				@endphp
				@include('index.cart.article')
			@endforeach
			</div>
			<div id="info" class="grid grid-cols-2 mt-6 md:col-start-6 md:col-span-4 md:mt-0">
				<p class="row-start-1 col-start-1">
					<a href="{{ route('cart.clear') }}" class="base-link">{{ __('Empty cart') }}</a> /
					<a href="#" id="checkCartButton" class="base-link">Check cart</a>
				</p>
				<form class="mb-6 row-start-1 col-start-2" id="shipping-form">
				{{ __('Shipping method') }} :<br>
				@foreach($shippingMethods as $shippingMethod)
					<div class="my-2">
						<input id="shipping-method-{{ $shippingMethod->id }}" type="radio" data-price="{{ $shippingMethod->price }}" value="{{ $shippingMethod->id }}" name="shipping-method" @if($loop->first) {{ 'checked' }} @endif>
						<label for="shipping-method-{{ $shippingMethod->id }}">{{ $shippingMethod->label }} : {{ $shippingMethod->price }}€</label>
					</div>
				@endforeach
				</form>
				<form class="mb-6 row-start-2 col-start-2" id="coupon-form">
					<div>
						<div class="flex items-center">
							<input type="text" id="coupon-input" placeholder="COUPON" autocomplete="off">
							<img src="{{ asset('img/loader2.gif') }}" class="hidden ml-2 w-6 h-6" id="loader" />
						</div>
						<span id='coupon-alert' class="text-red-500 text-sm italic hidden">{{ __('This coupon is not valid')}}</span>
					</div>
				</form>
				<div id="coupon-info" class="mb-6 row-start-3 col-start-2 hidden">
				</div>
				<p class="mb-6 row-start-4 col-start-2">
					{{ __('Total') }} : <span id="cart-total">{{ $total }}</span>€
				</p>
				@if(setting('app.paypal.client-id') && setting('app.paypal.secret'))
					<div class="w-48 row-start-5 col-start-2" id="paypal-checkout-button"></div>
				@endif
			</div>
		</div>
		
		<div id="empty-cart-info" class="hidden place-items-center justify-center h-96">
		@else
		<div id="empty-cart-info" class="flex place-items-center justify-center h-96">
		@endif
			<h3 class="text-3xl text-center text-gray-300">
			{{ __('Your cart is empty') }}.
			</h3>
		</div>
</x-index-layout>