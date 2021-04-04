<x-app-layout>
    <x-slot name="title">
        {{ __('Books') }}
    </x-slot>

    <x-slot name="controls">
		@if( !empty($archived) )
		<a href="{{ route('books.archived') }}" class="button-shared">{{ __('Archived') }} ({{ $archived }})</a>
		@endif
        <a href="{{ route('books.create') }}" class="button-shared">{{ __('New') }}</a>
    </x-slot>

	<table class="w-full app-table">
		{{-- <thead>
		</thead> --}}
		<tbody>
			<thead class="font-bold">
				<td class="w-6"></td>
				<td>{{ __('Title') }}</td>
				<td>{{ __('Author') }}</td>
				<td>{{ __('Edition') }}</td>
				<td>{{ __('Price') }}</td>
				<td>{{ __('Created') }}</td>
				<td>{{ __('Published by') }}</td>
				<td>{{ __('Action') }}</td>
			</thead>
			@foreach($books as $book)
			<tr>
				{{-- <td class="hidden md:table-cell">{{ $book->id }}</td> --}}
				<td>
					@if($book->media->isEmpty())
					<a href="{{ route('books.display', $book->id) }}" class="icon warning" title="{{ __('No media linked ! Book will not be displayed on front page.') }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
						<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
					</svg></a>
					@endif
				</td>
				<td><a href="{{ route('books.display', $book->id) }}" class="default">{{ $book->title }}</a></td>
				<td>{{ $book->author }}</td>
				<td>{{ $book->edition }}</td>
				<td>
				@if( !empty($book->price) )
					{{ $book->price }}€
				@endif
				</td>
				<td class="hidden md:table-cell">{{ $book->created_at->diffForHumans() }}</td>
				<td class="hidden md:table-cell"><a href="{{ route('users.display', $book->user->id)}}" class="default">{{ $book->user->username }}</a></td>
				<td class="text-right">
					
					<a class="icon" title="{{ __('Archive') }}" href="{{ route('books.archive', $book->id)}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
						<path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
						<path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
					</svg></a>
					<a class="icon" title="{{ __('Edit') }}" href="{{ route('books.edit', $book->id) }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
						<path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
						<path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
					</svg></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    
</x-app-layout>