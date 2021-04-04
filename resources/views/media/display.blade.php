<x-app-layout>
    <x-slot name="title">
        {{ $medium->name }}
    </x-slot>

    <div class="p-4 md:p-8">
        <img class="m-auto" src="{{ asset('storage/uploads/'.$medium->filename) }}">
    </div>

	<div>
		<p>{{ __('This image is attached to the following books') }} :</p>
		@foreach ($medium->books as $book)
			<a class="default" href="{{ route('books.display', $book->id) }}">{{ $book->title }} by {{ $book->author }}</a><br>
		@endforeach
	</div>
</x-app-layout>