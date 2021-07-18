<!DOCTYPE html>
<html lang="en" style="margin:0mm">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Labels</title>
	<style type="text/css">
		tr {
		}
		td {
			height: 49mm;
			width: 84mm;
			padding-left: 20mm;
		}

		.inner-wrapper {
			border:1px solid red;
			margin: auto;
		}
	</style>
</head>
<body style="font-family: sans-serif;">
	@php $orders = array_merge(array_fill(0, $extra, false), $orders->toArray()); @endphp
	<table style='border-collapse:collapse;width:100%'>
		<tbody>
			@for($i = 0; $i < count($orders); $i += 2)
			<tr>
				<td>
					@if($orders[$i])
					<span style="font-weight:bold">{{ $orders[$i]['full_name'] }}</span><br>
					{{ $orders[$i]['address_line_1'] }}<br>
					@isset($orders[$i]['address_line_2'])
					{{ $orders[$i]['address_line_2'] }}<br>
					@endif
					{{ $orders[$i]['postal_code'].', '.$orders[$i]['admin_area_2'] }}<br>
					@isset($orders[$i]['admin_area_1'])
					{{ $orders[$i]['admin_area_1'] }}<br>
					@endif
					{{ strtoupper(config('countries.'.$orders[$i]['country_code'])) }}<br>
					@endif
				</td>
				@if(isset($orders[$i+1]))
				<td>
					@if($orders[$i+1])
					<span style="font-weight:bold;">{{ $orders[$i+1]['full_name'] }}</span><br>
					{{ $orders[$i+1]['address_line_1'] }}<br>
					@isset($orders[$i+1]['address_line_2'])
					{{ $orders[$i+1]['address_line_2'] }}<br>
					@endif
					{{ $orders[$i+1]['postal_code'].', '.$orders[$i+1]['admin_area_2'] }}<br>
					@isset($orders[$i+1]['admin_area_1'])
					{{ $orders[$i+1]['admin_area_1'] }}<br>
					@endif
					{{ strtoupper(config('countries.'.$orders[$i+1]['country_code'])) }}<br>
					@endif
				</td>
				@endif
			</tr>
			@endfor
		</tbody>
	</table>
	
</body>
</html>