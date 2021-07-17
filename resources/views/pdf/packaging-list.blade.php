<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PDF</title>

	<style>
		td {
			padding: 10px 15px;
			border:3px solid black;
		}

		h2 {
			font-size: 1.1em;
			margin-bottom: 30px;
			margin-top: 100px;
		}
		thead tr, tfoot tr {
			font-weight: bold;
		}
	</style>

{{-- </head> --}}
<body style="font-family:sans-serif">
	@foreach($orders as $order)
	<h1 style="border-bottom:3px solid black;padding-bottom:20px;">e.p.g.</h1>
	<div class="">
		1 Adresse e.p.g.<br>
		75000 Paris<br>
		FRANCE<br>
		Tel : 0123456789
	</div>
	<div style="float:right;width:25%;border:3px solid black;padding:30px 50px;">
		<span style="display:block;font-weight:bold;">{{ $order->full_name }}</span>
		{{ $order->address_line_1 }}<br>
		@isset($order->address_line_2)
		{{ $order->address_line_2 }}<br>
		@endif
		{{ $order->postal_code }} {{ $order->admin_area_2 }}<br>@isset($order->admin_area_1) {{ $order->admin_area_1 }}@endif<br>
		{{ strtoupper(config('countries.'.$order->country_code))}}
	</div>
	<div style="clear:both;">
		<h2>{{ __('Packaging list') }}</h2>
	</div>
	<table style="border-collapse: collapse;border:3px solid black;;width:100%;">
		@php $couponPrice = 0; @endphp
		<thead style="background-color:#ddd">
			<tr>
				<td>{{ __('Articles') }}</td>
				<td>{{ __('Quantity') }}</td>
				<td>{{ __('Unit price') }}</td>
				<td>{{ __('Subtotal') }}</td>
			</tr>
		</thead>
		<tbody>
			@php $total = 0; @endphp
			@foreach($order->books as $book)
			@php 
				$subTotal = round($book->pivot->quantity * $book->price, 2);
				$total += $subTotal;
			@endphp
			<tr>
				<td>{{ $book->title }}</td>
				<td style="text-align:right;">{{ $book->pivot->quantity }}</td>
				<td style="text-align:right;">{{ $book->price }} €</td>
				<td style="text-align:right;">{{ $subTotal }} €</td>
			</tr>
			@endforeach
			@isset($order->coupons)
			<tr>
				@php $couponPrice = 
					boolval($order->coupons->type) ? 
					-1*$order->coupons->value : 
					round($order->coupons->value / -100 * $total, 2);
				@endphp
				<td>{{ __('Coupon').' : '.$order->coupons->label.' (-'.$order->coupons->value.(boolval($order->coupons->type) ? '€': '%').')' }}</td>
				<td colspan="3" style="text-align:right;">{{ $couponPrice.' €' }}</td>
			</tr>
			@endif
			<tr>
				<td>{{ __('Shipping').' : '.$order->shipping_method }}</td>
				<td colspan="3" style="text-align:right;">{{ $order->shipping_price }} €</td>
			</tr>
		</tbody>
		<tfoot style="background-color:#ddd">
			<tr>
				<td>{{ __('Total') }}</td>
				<td colspan="3" style="text-align:right;">{{ round($total + $couponPrice + $order->shipping_price, 2) }} €</td>
			</tr>
		</tfoot>
	</table>
	<div style="position:fixed;bottom:-200px;height:300px;text-align: center;margin-top:150px;border-top:3px solid black;padding-top:30px;">{{ __('Thank you for your purchase :)') }}</div>
	@if(!$loop->last)<div style="page-break-after: always;"></div>@endif
	@endforeach
</body>
</html>