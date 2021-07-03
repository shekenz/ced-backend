<x-index-layout>

	<x-slot name="title">
		{{ __('Order Status') }}
	</x-slot>

	<div class="">
	{{ $order-> status }}
	
</x-index-layout>