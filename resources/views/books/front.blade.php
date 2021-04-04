<x-index-layout lang="FR_fr">

	<x-slot name="title">Index</x-slot>

	<? $bookGlideIndex = 0; ?>
	@foreach ($books as $book)
		{{-- If book has no image, dont put it on the main page, it makes Glide.js angry --}}
		@if(!$book->media->isEmpty())
			@include('books.book')
			{{-- Can't use foreach index to set counter-id, otherwise we would have a Glide/counter mismatch when book has no image.
				 Counter-id would increment, but not Glide index. We have to increment an index inside the if block. See main.js --}}
			<? $bookGlideIndex++; ?>
		@endif
	@endforeach
</x-index-layout>