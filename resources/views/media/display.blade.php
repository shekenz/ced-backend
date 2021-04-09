<x-app-layout>
    <x-slot name="title">
        {{ $medium->name }}.{{ $medium->extension }}
    </x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/media.js') }}" defer></script>
	</x-slot>

	<x-slot name="controls">
		<form method="POST" action="{{ route('media.delete', $medium->id) }}" class="inline">
			@csrf
			<input type="submit" class="button-shared button-warning cursor-pointer" value="Delete" onclick="return confirm('{{ __('Are you sure you want to permanently delete '.$medium->name.' ? This action is not reversible.')}}');">
		</form>
	</x-slot>

	@if ($errors->any())
        <div class="mb-4" :errors="$errors">
            <div class="font-medium text-red-600">
                {{ __('Whoops! Something went wrong.') }}
            </div>

            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
	<form action="{{ route('media.update', $medium->id) }}" method="POST" class="flex flex-row gap-x-4 mb-4 items-center">
		@csrf
		@method('patch')
		<label for="name" class="label-shared whitespace-nowrap">{{ __('New name') }} : </label>
		<input class="input-shared" id="name" name="name" type="text" value="{{ old('name') ?? $medium->name }}" maxlength="64">
		<input class="button-shared" type="submit" value="{{ __('Rename') }}">
	</form>

    <img id="frame" class="m-auto" src="{{ asset('storage/uploads/'.$medium->filename) }}" data-hash="{{ $medium->filehash }}" data-ext="{{ $medium->extension }}">

	<div class="m-1">
		@foreach(config('optimage') as $key => $item)
			@if(Storage::disk('public')->exists('uploads/'.$medium->filehash.'_'.$key.'.'.$medium->extension))
				<?php $imagesize = getimagesize('storage/uploads/'.$medium->filehash.'_'.$key.'.'.$medium->extension); ?>
				@if($imagesize[0] < intval($item['width']) || $imagesize[1] < intval($item['height']))
				<a href="#" class="inline-block bg-yellow-200 rounded m-1 px-2 py-0.5 font-bold opti-button" data-opti="{{ $key }}">
					<x-tabler-alert-triangle class="text-yellow-500 inline-block" />
					{{ ucfirst($item['caption']) }}
					({{ round(Storage::disk('public')->size('uploads/'.$medium->filehash.'_'.$key.'.'.$medium->extension)/1024) }} KB)
				</a>
				@else
				<a href="#" class="inline-block bg-green-200 rounded m-1 px-2 py-0.5 font-bold opti-button" data-opti="{{ $key }}">
					<x-tabler-circle-check class="text-green-500 inline-block" />
					{{ ucfirst($item['caption']) }}
					({{ round(Storage::disk('public')->size('uploads/'.$medium->filehash.'_'.$key.'.'.$medium->extension)/1024) }} KB)
				</a>
				@endif
			@else
			<span class="inline-block bg-red-200 rounded m-1 px-2 py-0.5 font-bold">
				<x-tabler-circle-x class="text-red-500 inline-block" />
				{{ ucfirst($item['caption']) }}
			</span>
			@endif
		@endforeach
		<a id="original" href="#" class="inline-block bg-gray-300 rounded m-1 px-2 py-0.5 font-bold" data-opti="{{ $key }}">
			<x-tabler-photo class="text-gray-600 inline-block" />
			Original
			({{ round(Storage::disk('public')->size('uploads/'.$medium->filehash.'.'.$medium->extension)/1024) }} KB)
		</a>
	</div>

	@env('local')
	<div>
		<h4>File info</h4>
		ID : {{ $medium->id }}<br>
		Hash : {{ $medium->filehash }}<br>
		Format : <span class="bg-gray-400 rounded px-2 py-0.5 font-bold uppercase text-white text-sm">{{ $medium->extension }}</span><br>
	</div>
	@endenv

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