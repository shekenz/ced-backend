<x-app-layout>
    <x-slot name="title">
        {{ __('Books') }}
    </x-slot>

    <x-slot name="controls">
        <a href="{{ route('books.create') }}" class="button-shared">{{ __('New') }}</a>
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
                    <td class="text-right"><a class="button-shared" href="{{ route('books.edit', $book->id)}}">{{ __('Edit') }}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</x-app-layout>