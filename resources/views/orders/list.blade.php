<x-app-layout>
	<x-slot name="title">
		{{ __('Orders') }}
	</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/order-list.js') }}" type="text/javascript" defer></script>
	</x-slot>

		<div class="flex justify-between mb-3">
			<div>
				@php $maxDate = \Carbon\Carbon::now()->toDateString(); @endphp
				<label for="filter">{{ __('Filter') }}</label>
				<select class="input-inline" id="filter" placeholder="Filter">
					<option selected value="all"></option>
					<option value="book">{{ __('Book') }}</option>
					<option value="order">{{ __('Order ID') }}</option>
					<option value="name">{{ __('Name') }}</option>
					<option value="email">{{ __('Email') }}</option>
					<option value="status">{{ __('Status') }}</option>
					<option value="coupon">{{ __('Coupon') }}</option>
					<option value="shipping">{{ __('Shipping method') }}</option>
				</select>
				<label for="filter-data">{{ __('with') }}</label>
				<input class="input-inline" id="filter-data-text" type="text" disabled="true">
				<select class="input-inline hidden" id="filter-data-status">
					<option value="FAILED">{{ __('FAILED') }}</option>
					<option value="CREATED">{{ __('CREATED') }}</option>
					<option value="COMPLETED" selected="selected">{{ __('COMPLETED') }}</option>
					<option value="SHIPPED">{{ __('SHIPPED') }}</option>
				</select>
				<select class="input-inline hidden" id="filter-data-coupons">
					@foreach ($coupons as $coupon)
						<option value="{{ $coupon->id }}">{{ $coupon->label }}</option>
					@endforeach
				</select>
				<select class="input-inline hidden" id="filter-data-shipping">
					@foreach ($shippingMethods as $shippingMethod)
						<option value="{{ $shippingMethod->label }}">{{ $shippingMethod->label }}</option>
					@endforeach
				</select>
				<label for="start-date">{{ __('from') }}</label>
				<input class="input-inline" id="start-date" type="date" value="{{ \Carbon\Carbon::now()->subYear(1)->toDateString()}}" max="{{ $maxDate }}">
				<label for="end-date">{{ __('to') }}</label>
				<input class="input-inline" id="end-date" type="date" value="{{ $maxDate }}" max="{{ $maxDate }}">
				<input class="ml-2" id="visibility" type="checkbox"><label for="visibility" class="label-shared"> {{ __('Hidden') }}</label>
				<input class="ml-2" id="preorder" type="checkbox"><label for="preorder" class="label-shared"> {{ __('Pre-orders only') }}</label>
				<img id="loader" class="hidden ml-2 w-6 h-6 inline-block" src="{{ asset('img/loader2.gif')}}">
				</select>
			</div>
		</div>
		<div class="flex items-end border-t pt-1">
			<x-tabler-corner-left-down class="ml-2 inline-block" />
			<div class="mb-2">
				<input class="button-small cursor-pointer action" type="button" data-action="{{ route('orders.csv') }}" value="{{ __('CSV Export') }}">
				<input id="hide" class="button-small cursor-pointer action" type="button" data-action="{{ route('orders.hide') }}" value="{{ __('Hide') }}">
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

	<div id="no-result" class="hidden text-center text-xl text-gray-400 my-8">
		{{ __('No result found') }}
	</div>

	<x-tabler-recycle class="hidden" id="recycle-blueprint"/>
	<x-tabler-trash class="hidden" id="trash-blueprint"/>

</x-app-layout>