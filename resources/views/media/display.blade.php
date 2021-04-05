<x-app-layout>
    <x-slot name="title">
        {{ $medium->name }}
    </x-slot>

	<x-slot name="controls">
		<form method="POST" action="{{ route('media.delete', $medium->id) }}" class="inline">
			@csrf
			<input type="submit" class="button-shared button-warning cursor-pointer" value="Delete" onclick="return confirm('{{ __('Are you sure you want to permanently delete '.$medium->name.' ? This action is not reversible.')}}');">
		</form>
	</x-slot>

    <img class="m-auto" src="{{ asset('storage/uploads/'.$medium->filename) }}">

	<div>
		<h4>File info</h4>
		ID : {{ $medium->id}}<br>
		Hash : {{ $medium->filehash}}<br>
		@if(Storage::disk('public')->exists('uploads/'.$medium->thumb))
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 inline" viewBox="0 0 20 20" fill="currentColor">
			<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
		</svg>
		@else
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 inline" viewBox="0 0 20 20" fill="currentColor">
			<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
		</svg>
		@endif
		Thumbnail<br>
		@if(Storage::disk('public')->exists('uploads/'.$medium->thumb2x))
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 inline" viewBox="0 0 20 20" fill="currentColor">
			<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
		</svg>
		@else
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 inline" viewBox="0 0 20 20" fill="currentColor">
			<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
		</svg>
		@endif
		Thumbnail &commat;2x<br>

	<div>
		@if( $medium->books->isEmpty() )
		<h4>{{ __('No linked books') }}.</h4>
		@else
			<h4>{{ __('Linked to') }} :</h4>
		@endif
		<table class="w-full app-table app-table-small">
		@foreach ($medium->books as $book)
			<tr>
				<td><a class="default" href="{{ route('books.display', $book->id) }}">{{ $book->title }}</a></td>
				<td>By {{ $book->author }}</td>
				@if( !empty($book->edition ))
					<td>{{ $book->edition }}</td>
				@else
					<td>({{ __('No edition') }})</td>
				@endif
				<td>Published by <a class="default" href="{{ route('users.display', $book->user->id) }}">{{ $book->user->username }}</a></td>
				<td class="text-right w-8"><a class="icon warning" title="Break link" href="{{ route('media.break', [$medium, $book]) }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
					<path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
				  </svg></a></td>
			</tr>
		@endforeach
		</table>
	</div>
</x-app-layout>