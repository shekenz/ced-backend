<x-index-layout lang="FR_fr">

	<x-slot name="title">Index</x-slot>

	@foreach ($books as $book)
		@include('books.book')
	@endforeach
</x-index-layout>