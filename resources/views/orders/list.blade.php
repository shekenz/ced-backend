<x-app-layout>
	<x-slot name="title">
		{{ __('Orders') }}
	</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/order-list.js') }}" type="text/javascript" defer></script>
	</x-slot>

		<div class="flex justify-between mb-3">
			<div>
				<input class="button-shared cursor-pointer action" type="button" data-action="{{ route('orders.csv') }}" value="{{ __('CSV Export') }}">
				@if(request()->routeIs('orders'))
				<input class="button-shared cursor-pointer action" type="button" data-action="{{ route('orders.hide') }}" value="{{ __('Hide selected') }}">
				<input id="filter" type="text" placeholder="Filter"><img id="loader" class="hidden ml-2 w-6 h-6 inline-block" src="{{ asset('img/loader2.gif')}}">
				@else
				<input class="button-shared cursor-pointer action" type="button" data-action="{{ route('orders.unhide') }}" value="{{ __('Unhide selected') }}">
				@endif
			</div>
			<div>
				@if(request()->routeIs('orders'))
				<a href="{{ route('orders.hidden') }}" class="button-shared cursor-pointer">{{ __('Hidden orders') }}</a>
				@endif
			</div>
		</div>
		
		<form id="orders-selection" method="POST">
			@csrf
		<table id="orders-table" class="app-table">
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
			<tbody id="order-rows">
			@foreach ($orders as $order)
				<tr class="order-row @if(!$order->read){{ 'unread' }}@endif">
					<td><input class="checkbox" type="checkbox" value="{{$order->id }}" name="ids[]"</td>
					<td><a class="default" href="{{ route('orders.display', $order->id)}}">@if(isset($order->order_id))
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
						@if($order->status == 'CREATED' && isset($order->order_id) && !$order->created_at->isCurrentHour())
							<a class="icon" href="{{ route('orders.recycle', $order->order_id) }}"><x-tabler-recycle /></a>
						@elseif($order->status == 'FAILED')
							<a class="icon" href="{{ route('orders.cancel', $order->id) }}"><x-tabler-trash /></a>
						@endif

					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</form>

	<x-tabler-recycle class="hidden" id="recycle-blueprint"/>
	<x-tabler-trash class="hidden" id="trash-blueprint"/>

</x-app-layout>