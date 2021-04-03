<x-app-layout>
    <x-slot name="title">
        {{ __('Book') }}
    </x-slot>

    <x-slot name="controls">
        <a href="{{ route('books.delete', $book->id ) }}" class="button-shared">{{ __('Delete') }}</a>
    </x-slot>

    <div class="m-4">
		<p class="mb-4">
		{{ __('Title') }} : {{ $book->title }}<br>
		{{ __('Author') }} : {{ $book->author }}<br>
		{{ __('Width') }} :
		@if( !empty($book->width))
			{{ $book->width }} mm
		@else
			{{ __('Empty') }}
		@endif
		<br>
		{{ __('Height') }} :
		@if( !empty($book->height))
			{{ $book->height }} mm
		@else
			{{ __('Empty') }}
		@endif
		<br>
		{{ __('Pages count') }} :
		@if( !empty($book->pages))
			{{ $book->pages }} pages
		@else
			{{ __('Empty') }}
		@endif
		<br>
		{{ __('Cover type') }} :
		@if( !empty($book->cover))
			{{ $book->cover }}
		@else
			{{ __('Empty') }}
		@endif
		<br>
		{{ __('Edition') }} :
		@if( !empty($book->edition))
			{{ $book->edition }}
		@else
			{{ __('Empty') }}
		@endif
		<br>
		{{ __('Price') }} :
		@if( !empty($book->price))
			{{ $book->price }}€
		@else
			{{ __('Empty') }}
		@endif
		</p>
		<p class="mb-4">
			{{ __('Publisher') }} : {{ $book->user->username}}<br>
			{{ __('Created at') }} : {{ $book->created_at }}<br>
			{{ __('Last updated') }} : {{ $book->updated_at }}<br>
		</p>
		<p>{{ $book->description }}</p>
		
    </div>
    
</x-app-layout>