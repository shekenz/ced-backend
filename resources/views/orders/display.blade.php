<x-app-layout>

	<x-slot name="title">
		{{ __('Order') }}
	</x-slot>

	@php
		switch ($order->status) {
			case 'FAILED':
				$statusClass = 'bg-red-500';
				break;
			case 'CREATED':
				$statusClass = 'bg-yellow-500';
				break;
			case 'COMPLETED':
				$statusClass = 'bg-blue-500';
				break;
			case 'SHIPPED':
				$statusClass = 'bg-green-500';
				break;
			default:
				$statusClass = 'bg-black';
				break;
		}
	@endphp

	<div>
		<div class="flex mt-8 justify-between">
			<div class="">
				<span class="text-white text-xl py-4 px-6 {{ $statusClass }}">{{ __($order->status) }}</span>
			</div>
			<div class="font-bold">
				<span class="mr-2">{{ __('Transaction ID') }} : </span><a href="@if(setting('app.paypal.sandbox')) {{ 'https://www.sandbox.paypal.com/activity/payment/'.$order->transaction_id  }}
				@else {{ 'https://www.paypal.com/activity/payment/'.$order->transaction_id  }}
				@endif" class="border border-black box-border text-xl py-4 px-6">{{ $order->transaction_id }}</a>
			</div>
		</div>

		<div class="flex gap-x-8 mt-10">
			<div class="flex-grow">
				<h2 class="text-lg border-b border-black font-bold">{{ __('Client info') }} : </h2>
				<div class="p-4">
					<p class="my-2"><span class="font-bold">{{ __('Ordered at') }} : </span>{{ $order->created_at }}</p>
					<p class="my-2"><span class="font-bold">{{ __('Order ID') }} : </span>{{ $order->order_id }}</p>
					<p class="my-2"><span class="font-bold">{{ __('Client ID') }} : </span>{{ $order->payer_id }}</p>
					<p class="my-2"><span class="font-bold">{{ __('Client') }} : </span>{{ $order->given_name }} {{ $order->surname }}</p>
					<p class="my-2"><span class="font-bold">{{ __('Client email') }} : </span>{{ $order->email_address }}</p>
				</div>
			</div>
			<div class="flex-grow">
				<h2 class="text-lg border-b border-black font-bold">{{ __('Shipping address') }} : </h2>
				<div class="text-2xl font-bold border-4 border-black py-4 px-8 block w-96 mx-auto my-8">
					<p>{{ $order->full_name }}</p>
					<p>{{ $order->address_line_1 }}</p>
					<p>{{ $order->address_line_2 }}</p>
					<p>{{ $order->postal_code }} {{ $order->admin_area_2 }}, {{ $order->admin_area_1 }}</p>
					<p>@isset($order->country_code)
						{{ strtoupper(config('countries')[$order->country_code]) }}
					@endisset</p>
				</div>
			</div>
		</div>

		<div class="mt-6">
			<h2 class="text-lg border-b border-black font-bold">{{ __('Articles') }}</h2>
			<table class="w-full">
				<thead class="border-b-2 border-black">
					<td>{{ __('Title') }}</td>
					<td>{{ __('Author') }}</td>
					<td>{{ __('Quantity') }}</td>
					<td>{{ __('Subtotal') }}</td>
				</thead>
			@foreach ($order->books as $book)
				<tr>
					<td>{{ $book->title }}</td>
					<td>{{ $book->author }}</td>
					<td>{{ $book->pivot->quantity }}</td>
					<td>{{ $book->pivot->quantity * $book->price }}</td>
				</tr>
			@endforeach
				<tr class="border-b-2 border-t-2 border-black">
					<td>{{ __('Shipping method') }}</td>
					<td>UPS</td>
					<td></td>
					<td>7.5</td>
				</tr>
				<tfoot>
					<td>{{ __('Total') }}</td>
					<td></td>
					<td></td>
					<td></td>
				</tfoot>
			</table>
		</div>
	</div>

</x-app-layout>