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
							<input type="submit" class="button-shared button-warning cursor-pointer" value="Delete" onclick="return confirm('{{ __('Are you sure you want to permanently delete '.$book->title.' ? This action is not reversible.')}}');">
							<a href="#" title="{{ __('Delete') }}" class="icon warning">
								<x-tabler-trash />
							</a>
						</form>
						<a class="icon" title="{{ __('Restore') }}" href="{{ route('books.restore', $book->id) }}"><x-tabler-arrow-up-circle /></a>
					</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</x-app-layout>