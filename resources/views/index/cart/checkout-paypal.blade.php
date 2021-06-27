<x-index-layout>
	<x-slot name="title">
		{{ __('Checkout') }}
	</x-slot>

	@if(setting('app.paypal.client-id') && setting('app.paypal.secret'))
	<x-slot name="scripts">
		<script src="https://www.paypal.com/sdk/js?client-id={{ setting('app.paypal.client-id') }}&currency=EUR&disable-funding=credit,card,bancontact,blik,eps,giropay,ideal,mercadopago,mybank,p24,sepa,sofort,venmo"></script>
		<script src="{{ asset('js/paypal-checkout.js') }}" defer></script>
	</x-slot>
	@endif

	<table class="w-full mt-6">
	<thead class="border-b border-gray-800 font-bold">
		<td></td>
		<td>{{ __('Title') }}</td>
		<td>{{ __('Author') }}</td>
		<td class="text-right">{{ __('Quantity') }}</td>
		<td class="text-right">{{ __('Unit price') }}</td>
		<td class="text-right">{{ __('Subtotal') }}</td>
	</thead>
	@php
		$total = 0;
		$totalQuantity = 0;
		$shippingPrice = 7.5;
	@endphp
	@foreach ($books as $book)
		<tr class="border-b border-gray-800">
			<td class="w-14"><img class="w-12 h-12" src="{{ asset('storage/'.$book->media->get(0)->preset('thumb')) }}"></td>	
			<td>{{ $book->title }}</td>
			<td>{{ $book->author }}</td>
			<td class="text-right">{{ $book->cartQuantity }}</td>
			<td class="text-right">{{ $book->price }}</td>
			<td class="text-right">{{ $book->cartQuantity * $book->price }}</td>
			@php
				$total += $book->cartQuantity * $book->price;
				$totalQuantity += $book->cartQuantity;
			@endphp
		</tr>
	@endforeach
	<tr>
		<td class="text-center"><x-tabler-truck class="inline-block w-8 h-8" /></td>
		<td>{{ __('Shipping method') }}</td>
		<td class="py-2">
			<form id="shipping-form">
				@for ($i = 1; $i <= 3; $i++)
					<input type="radio" id="shipping-method-{{ $i }}" name="shipping-method" class="shipping-method" value="{{ 7.5 * $i }}" {{ ($i == 1) ? 'checked' : ''}}>
					<label for="shipping-method-{{ $i }}">{{ __('Shipping method').' '.$i }}</label><br>
				@endfor
			</form>
			<td colspan="3" class="text-right" id="shipping-price">7.5</td>
			<td></td>
			<td></td>
		</td>
	</tr>
	<tfoot>
		<tr class="font-bold border-t border-gray-800">
			<td></td>
			<td>{{ __('Total') }}</td>
			<td colspan="2" class="text-right">{{ $totalQuantity }}</td>
			<td></td>
			<td colspan="2" class="text-right" id="total" data-total-no-shipping="{{ $total }}">{{ $total + $shippingPrice}}</td>
			<td></td>
		</tr>
	</tfoot>
	</table>
	<div class="flex justify-end mt-6">
		@if(setting('app.paypal.client-id') && setting('app.paypal.secret'))
		<div class="w-48" id="paypal-checkout-button"></div>
		@else
		<div class="italic border border-black p-4">{{ __('Ordering is temporarily unavailable. Sorry for the inconveniance')}}.</div>
		@endif
	</div>

</x-index-layout>	