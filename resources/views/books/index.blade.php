<x-index-layout>

	<x-slot name="title">Index</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/glide.js') }}" defer></script>
		<script src="{{ asset('js/add-to-cart.js') }}" defer></script>
	</x-slot>
	
	@foreach ($books as $glideIndex => $book)
		@include('books.book')
	@endforeach

	<div id="added-flash" class="fixed z-[900] top-0 left-0 border-b shadow-md border-black bg-white w-full flex justify-center items-center transition-all overflow-y-hidden h-0 hidden">
		<span>{{ __('Article added to cart') }}. <a href="{{ route('cart') }}">{{ __('Checkout cart') }}</a>.</span>
	</div>

</x-index-layout>