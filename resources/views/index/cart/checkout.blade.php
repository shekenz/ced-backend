<x-index-layout>
	<x-slot name="title">
		{{ __('Checkout') }}
	</x-slot>

	<div class="flex justify-evenly w-full gap-x-4">
		<div class="contact-info border w-1/3">
			<h2 class="font-bold">{{ __('Your contact informations')}}</h2>
			{{ $data['firstname'] }}<br>
			{{ $data['lastname'] }}<br>
			@isset($data['company'])
				{{ $data['company'] }}<br>
			@endisset
			{{ $data['phone'] }}<br>
			{{ $data['email'] }}<br>
		</div>
		<div class="shipping-address border w-1/3">
			<h2 class="font-bold">{{ __('Your shipping address')}}</h2>
			{{ $data['shipping-address-1'] }}<br>
			@isset($data['shipping-address-2'])
			{{ $data['shipping-address-2'] }}<br>
			@endisset
			{{ $data['shipping-postcode'] }}<br>
			{{ $data['shipping-city'] }}<br>
			{{ config('countries.'.$data['shipping-country']) }}<br>
		</div>
		<div class="invoice-address border w-1/3">
			<h2 class="font-bold">{{ __('Your invoice address')}}</h2>
			{{ $data['invoice-address-1'] }}<br>
			@isset($data['invoice-address-2'])
			{{ $data['invoice-address-2'] }}<br>
			@endisset
			{{ $data['invoice-postcode'] }}<br>
			{{ $data['invoice-city'] }}<br>
			{{ config('countries.'.$data['invoice-country']) }}<br>
		</div>
	</div>

	<table class="w-full mt-6">
	<thead class="border-b border-gray-800 font-bold">
		<td></td>
		<td>{{ __('Title') }}</td>
		<td>{{ __('Author') }}</td>
		<td class="text-right">{{ __('Quantity') }}</td>
		<td class="text-right">{{ __('Unit price') }}</td>
		<td class="text-right">{{ __('Subtotal') }}</td>
	</thead>
	@php $total = 0; $totalQuantity = 0; $shippingPrice = 10;@endphp
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
		<td></td>
		<td>{{ __('Shipping method') }}</td>
		<td>
			<form>
				@for ($i = 1; $i <= 3; $i++)
					<input type="radio" id="shipping-method-{{ $i }}" name="shipping-method" {{ ($i == 1) ? 'checked' : '' }} value="{{ 7.5 * $i }}">
					<label for="shipping-method-{{ $i }}">{{ __('Shipping method').' '.$i }}</label><br>
				@endfor
			</form>
			<td colspan="3" class="text-right">{{ $shippingPrice }}</td>
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
			<td colspan="2" class="text-right">{{ $total + $shippingPrice }}</td>
			<td></td>
		</tr>
	</tfoot>
	</table>
	<div class="flex justify-end mt-6">
		<a href="{{ route('cart.confirmed') }}" class="base-button block">{{ __('Proceed to payment') }}</a>
	</div>

</x-index-layout>	