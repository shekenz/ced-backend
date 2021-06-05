<x-app-layout>
	<x-slot name="title">
		{{ __('Orders') }}
	</x-slot>

	<table class="app-table">
		<thead>
			<td>id</td>
			<td>{{ __('First name') }}</td>
			<td>{{ __('Last name') }}</td>
			<td>{{ __('Phone') }}</td>
			<td>{{ __('Email') }}</td>
			<td>{{ __('Address') }}</td>
			<td>{{ __('Shipping') }}</td>
			<td>{{ __('Status') }}</td>
			<td>{{ __('Created at') }}</td>
			<td>{{ __('Last updated') }}</td>
			<td>{{ __('Tools') }}</td>
		</thead>
	@foreach ($orders as $order)
		<tr>
			<td>{{ $order->id }}</td>
			<td>{{ $order->firstname }}</td>
			<td>{{ $order->lastname }}</td>
			<td>{{ $order->phone }}</td>
			<td>{{ $order->email }}</td>
			<td><a href="#">{{ __('Address') }}</a></td>
			<td>{{ $order->shippingMethodId }}</td>
			<td>{{ $order->status }}</td>
			<td>{{ $order->created_at }}</td>
			<td>{{ $order->updated_at }}</td>
			<td></td>
		</tr>
	@endforeach
	</table>

</x-app-layout>