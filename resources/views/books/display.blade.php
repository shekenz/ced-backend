<x-app-layout>
    <x-slot name="title">
        {{ __('Book') }}
    </x-slot>

    <x-slot name="controls">
        <a href="{{ route('books.archive', $book->id ) }}" class="button-shared">{{ __('Archive') }}</a>
		<a href="{{ route('books.edit', $book->id ) }}" class="button-shared">{{ __('Edit') }}</a>
    </x-slot>

	<p class="mb-4">
	{{ __('ID') }} : {{ $book->id }}<br>
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
	<p class="mb-4">{!! nl2br(e($book->description)) !!}</p>
	@if( $book->media->isEmpty() )
		<h4 class="text-red-500">{{ __('No media linked ! Book will not be displayed on front page.') }}</h4>
	@else
		<h4>Attached media :</h4>
		<p class="grid grid-cols-8 gap-4">
			@foreach ($book->media as $medium)
				<a href="{{ route('media.display', $medium->id )}}"><img src="{{ asset('storage/uploads/'.$medium->thumb) }}" srcset="{{ asset('storage/uploads/'.$medium->thumb) }} 1x, {{ asset('storage/uploads/'.$medium->thumb2x) }} 2x"></a>
			@endforeach
		</p>
	@endif
	    
</x-app-layout>