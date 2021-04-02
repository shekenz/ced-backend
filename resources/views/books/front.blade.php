<x-index-layout lang="FR_fr">

	<x-slot name="title">Index</x-slot>

	@foreach ($books as $book)
		@include('index.article')
	@endforeach
</x-index-layout>