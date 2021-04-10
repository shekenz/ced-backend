<x-index-layout lang="FR_fr">

	<x-slot name="title">Index</x-slot>

	@auth
		<x-slot name="scripts">
			<script src="{{ asset('js/front.js') }}" defer></script>
		</x-slot>
	@endauth

	@foreach ($books as $glideIndex => $book)
		@include('books.book')
	@endforeach

</x-index-layout>