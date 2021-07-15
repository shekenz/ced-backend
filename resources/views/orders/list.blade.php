<x-app-layout>
	<x-slot name="title">
		{{ __('Orders') }}
	</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/order-list.js') }}" type="text/javascript" defer></script>
	</x-slot>

	<form method="POST" action="{{ route('orders.csv') }}">
		@csrf

		<div class="mb-3"><input class="button-shared cursor-pointer" type="submit" value="{{ __('CSV Export') }}"></div>
		
		<table class="app-table">
			<thead>
				<td><input type="checkbox" id="checkall" title="{{ __('Select/Deselect all') }}"></td>
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
			<tr class="@if(!$order->read){{ 'unread' }}@endif">
				<td><input class="checkbox" type="checkbox" value="{{$order->id }}" name="ids[]"</td>
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
				@endswitch">@if($order->pre_order && $order->status === 'COMPLETED')
					{{ mb_strtoupper(__('paypal.status.preorder')) }}
				@else
					{{ mb_strtoupper(__('paypal.status.'.$order->status)) }}
				@endif</span></td>
				<td>{{ $order->created_at }}</td>
				<td>{{ $order->updated_at }}</td>
				<td class="text-right">
					@if($order->status == 'CREATED' && isset($order->order_id))
						<a class="icon" href="{{ route('orders.recycle', $order->order_id) }}"><x-tabler-recycle /></a>
					@elseif($order->status == 'FAILED' && empty($order->order_id))
						<a class="icon" href="{{ route('orders.cancel', $order->id) }}"><x-tabler-trash /></a>
					@endif

				</td>
			</tr>
		@endforeach
		</table>
	</form>

</x-app-layout>