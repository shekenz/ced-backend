{{ __('mails.general.salutationto', ['name' => $order->given_name]) }} !
<br><br><br>
{{ __('mails.orders.confirmation.intro', ['order_id' => $order->order_id]) }}.<br><br>
{{ __('mails.orders.confirmation.summary') }} :
<br>----------------------------------------------------<br>

@php $total = 0 @endphp
@foreach ($order->books as $book)
	@php $total += $book->pivot->quantity * $book->price; @endphp
	{{ $book->title }} X {{ $book->pivot->quantity }} : {{ round($book->pivot->quantity * $book->price, 2) }} €
@endforeach
{{-- //TODO Coupons reduction, don't forget !!!! --}}
<br>----------------------------------------------------<br>
{{ __('mails.orders.confirmation.method', [
	'method' => $order->shipping_method,
	'shipping_price' => $order->shipping_price
]) }} €
<br>----------------------------------------------------<br>
Total : {{ round($total + $order->shipping_price, 2) }} €
<br>----------------------------------------------------<br><br>

{{ __('mails.orders.confirmation.shipping') }}.<br><br><br>

{{ __('mails.orders.confirmation.thanks') }}
<br><br>
<a href="https://www.epg.works">https://www.epg.works</a>
<br><br><br>