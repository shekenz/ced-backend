<x-app-layout>
    <x-slot name="title">
        {{ __('Archived books') }}
    </x-slot>

    <x-slot name="controls">
		<form method="POST" action="{{ route('books.deleteAll') }}" class="inline">
			@csrf
			<input type="submit" class="button-shared button-warning cursor-pointer" value="Delete all" onclick="return confirm('{{ __('Are you sure you want to permanently delete '.$archived.' books ? This action is not reversible.')}}');">
		</form>
		<a href="{{ route('books') }}" class="button-shared">{{ __('Return to books') }}</a>
    </x-slot>

    <div class="m-4">
        <table class="border-collapse table-auto box-border w-full">
            {{-- <thead>
            </thead> --}}
            <tbody>
				<thead class="font-bold">
					<td>{{ __('Title') }}</td>
					<td>{{ __('Author') }}</td>
					<td>{{ __('Edition') }}</td>
					<td>{{ __('Price') }}</td>
					<td>{{ __('Trashed') }}</td>
					<td>{{ __('Published by') }}</td>
					<td>{{ __('Action') }}</td>
				</thead>
				@foreach($books as $book)
                <tr>
                    {{-- <td class="hidden md:table-cell">{{ $book->id }}</td> --}}
                    <td>{{ $book->title }}</td>
					<td>{{ $book->author }}</td>
					<td>{{ $book->edition }}</td>
					<td>
					@if( !empty($book->price) )
						{{ $book->price }}€
					@endif
					</td>
                    <td class="hidden md:table-cell">{{ $book->deleted_at->diffForHumans() }}</td>
                    <td class="hidden md:table-cell"><a href="{{ route('users.display', $book->user->id)}}" class="default">{{ $book->user->username }}</a></td>
                    <td class="text-right">
						<form method="POST" action="{{ route('books.delete', $book->id) }}" class="inline">
							@csrf
							<a href="#" title="{{ __('Delete') }}" class="icon warning">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
								</svg>
							</a>
							<input type="submit" class="button-shared button-warning cursor-pointer" value="Delete" onclick="return confirm('{{ __('Are you sure you want to permanently delete '.$book->title.' ? This action is not reversible.')}}');">
						</form>
						<a class="icon" title="{{ __('Restore') }}" href="{{ route('books.restore', $book->id) }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
						  </svg></a>
					</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</x-app-layout>