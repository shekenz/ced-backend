<x-app-layout>
	<x-slot name="title">
		{{ __('Orders') }}
	</x-slot>

	<table class="app-table">
		<thead>
			<td>id</td>
			<td>{{ __('Order') }}</td>
			<td>{{ __('Client') }}</td>
			<td>{{ __('Client email') }}</td>
			<td>{{ __('Articles') }}</td>
			<td>{{ __('Status') }}</td>
			<td>{{ __('Created at') }}</td>
			<td>{{ __('Last updated') }}</td>
			<td>{{ __('Tools') }}</td>
		</thead>
	@foreach ($orders as $order)
		<tr>
			<td>{{ $order->id }}</td>
			<td><a class="default" href="{{ route('orders.display', $order->id)}}">@isset($order->order_id)
				{{ $order->order_id }}
			@else
				{{ '[ '.__('Order ID missing').' ]'}}
			@endisset</a></td>
			<td>{{ $order->full_name }}</td>
			<td>{{ $order->email_address }}</td>
			<td class="text-right">{{ $order->books->reduce(function($total, $book) {
				return $total + $book->pivot->quantity;
			}) }}</td>
			<td><span class="font-bold text-center inline-block w-full text-white px-2 py-1 rounded @switch($order->status)
				@case('FAILED') {{ 'bg-red-500' }} @break
				@case('CREATED') {{ 'bg-yellow-500' }} @break
				@case('COMPLETED') {{ 'bg-blue-500' }} @break
				@case('SHIPPED') {{ 'bg-green-500' }} @break
			@endswitch">{{ mb_strtoupper(__('paypal.status.'.$order->status)) }}</span></td>
			<td>{{ $order->created_at }}</td>
			<td>{{ $order->updated_at }}</td>
			<td class="text-right">@if($order->status == 'CREATED' && isset($order->order_id))<a class="icon" href="{{ route('orders.recycle', $order->order_id) }}"><x-tabler-recycle></x-tabler-recycle></a>@endif</td>
		</tr>
	@endforeach
	</table>

</x-app-layout>