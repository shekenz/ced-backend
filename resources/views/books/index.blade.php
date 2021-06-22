<x-index-layout lang="FR_fr">

	<x-slot name="title">Index</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/glide.js') }}" defer></script>
		<script src="{{ asset('js/add-to-cart.js') }}" defer></script>
	</x-slot>
	
	@foreach ($books as $glideIndex => $book)
		@include('books.book')
	@endforeach

</x-index-layout>