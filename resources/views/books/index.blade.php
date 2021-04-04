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
					<a class="icon" title="{{ __('Edit') }}" href="{{ route('books.edit', $book->id)}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
						<path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
						<path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
					</svg></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    
</x-app-layout>