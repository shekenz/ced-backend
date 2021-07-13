{{ __('mails.general.salutationto', ['name' => $order->given_name]) }} !
<br><br><br>
{{ __('mails.orders.confirmation.intro', ['order_id' => $order->order_id]) }}.<br><br>
{{ __('mails.orders.confirmation.summary') }} :
<br>----------------------------------------------------<br>

@php 
$total = 0;
$couponPrice = 0; 
@endphp
@foreach ($order->books as $book)
	@php $total += $book->pivot->quantity * $book->price; @endphp
	{{ $book->title }} X {{ $book->pivot->quantity }} : {{ round($book->pivot->quantity * $book->price, 2) }} €
@endforeach
@isset($order->coupons)
<br>----------------------------------------------------<br>
@php
	if(boolval($order->type)) {
		$couponPrice =  $order->coupons->value * -1;
		$couponType = ' €'; 
	}else{
		$couponPrice = round($order->coupons->value / -100 * $total, 2);
		$couponType = '%'; 
	}
@endphp
{{ __('mails.orders.confirmation.coupon', [
	'coupon_value' => '-'.$order->coupons->value.$couponType,
	'coupon_price' => $couponPrice.' €'
]) }}
@endif
<br>----------------------------------------------------<br>
{{ __('mails.orders.confirmation.method', [
	'method' => $order->shipping_method,
	'shipping_price' => $order->shipping_price
]) }} €
<br>----------------------------------------------------<br>
Total : {{ round($total + $order->shipping_price + $couponPrice, 2) }} €
<br>----------------------------------------------------<br><br>

{{ __('mails.orders.confirmation.shipping') }}.<br><br><br>

{{ __('mails.orders.confirmation.thanks') }}
<br><br>
<a href="https://www.epg.works">https://www.epg.works</a>
<br><br><br>