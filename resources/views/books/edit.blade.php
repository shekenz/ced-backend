<x-app-layout>
	<x-slot name="title">
		{{ __('Edit book') }}
	</x-slot>

	<x-slot name="controls">
		<a href="{{ route('books') }}" class="button-shared">{{ __('Cancel') }}</a> 
	</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/media-library-dragdrop.js') }}" type="text/javascript" defer></script>
	</x-slot>
	
	<div class="m-4">
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

        <form action="{{ route('books.update', $book->id) }}" method="post" enctype="multipart/form-data" class="flex flex-col gap-y-2 md:grid md:grid-cols-4 lg:m-2 md:gap-x-4">
            @csrf
			@method('patch')
			<div>
            	<label class="label-shared-first lg:text-lg" for="title">{{ __('Title') }} :</label>
            	<input class="input-shared" id="title" name="title" type="text" value="{{ old('title') ?? $book->title }}" maxlength="128">
			</div>
			<div class="md:row-start-2">
            	<label class="label-shared-first lg:text-lg" for="author">{{ __('Author') }} :</label>
            	<input class="input-shared" id="author" name="author" type="text" value="{{ old('author') ?? $book->author }}" maxlength="64">
			</div>
			<div class="md:row-start-3">
            	<label class="label-shared-first lg:text-lg" for="year">{{ __('Year') }} :</label>
            	<input class="input-shared" id="year" name="year" type="number" value="{{ old('year') ?? $book->year }}" min="0" max="{{ now()->addYear(1)->year }}">
			</div>
			<div>
            	<label class="label-shared-first lg:text-lg" for="width">{{ __('Width') }} (mm) :</label>
            	<input class="input-shared" id="width" name="width" type="number" value="{{ old('width') ?? $book->width }}">
			</div>
			<div class="md:row-start-2">
            	<label class="label-shared-first lg:text-lg" for="height">{{ __('Height') }} (mm) :</label>
            	<input class="input-shared" id="height" name="height" type="number" value="{{ old('height') ?? $book->height }}">
			</div>
			<div>
            	<label class="label-shared-first lg:text-lg" for="cover">{{ __('Cover') }} :</label>
            	<input class="input-shared" id="cover" name="cover" type="text" value="{{ old('cover') ?? $book->cover }}" maxlength="32">
			</div>
			<div class="md:row-start-2">
            	<label class="label-shared-first lg:text-lg" for="pages">{{ __('Pages count') }} :</label>
            	<input class="input-shared" id="pages" name="pages" type="number" value="{{ old('pages') ?? $book->pages }}">
			</div>
			<div>
            	<label class="label-shared-first lg:text-lg" for="quantity">{{ __('Quantity') }} :</label>
            	<input class="input-shared" id="quantity" name="quantity" type="number" value="{{ old('quantity') ?? $book->quantity }}">
			</div>
			<div class="md:row-start-2">
            	<label class="label-shared-first lg:text-lg" for="price">{{ __('Price') }} :</label>
            	<input class="input-shared" id="price" name="price" type="text" value="{{ old('price') ?? $book->price }}" maxlength="10">
			</div>
			<div class="col-span-4">
            	<label class="label-shared lg:text-lg" for="description">{{ __('Description') }} :</label>
            	<textarea id="description" class="input-shared h-96" name="description">{{ old('description') ?? $book->description }}</textarea>
			</div>
			<input type="hidden" name="lang" value="fr">

			@if( $media->isNotEmpty() )
				<div class="col-span-4">
					<label class="label-shared lg:text-lg">{{ __('Linked media') }} :</label>
					<div id="media-link" class="dropzone input-mimic">
						@php $input = true; @endphp
						@if($book->media->isEmpty())
							<div id="media-link-placeholder" class="placeholder flex m-3 justify-center items-center">
								<span class="text-3xl text-gray-300 font-bold">{{ __('Drop media from the library here')}}.</span>
							</div>
						@endif
						@foreach( $book->media as $medium )
							@include('books.form-image')
						@endforeach
					</div>
				</div>
				
				<div class="col-span-4">
					<label class="label-shared lg:text-lg">{{ __('Media library') }} :</label>
					<div id="media-library" class="dropzone input-mimic">
						@php $input = false; @endphp
						@if($media->isNotEmpty() && $media->diff($book->media)->isEmpty())
							<div id="media-library-placeholder" class="placeholder flex m-3 justify-center items-center">
								<span class="text-3xl text-gray-300 font-bold">{{ __('Move media here to unlink from book')}}.</span>
							</div>
						@endif
						@foreach($media->diff($book->media) as $medium)
							@include('books.form-image')
						@endforeach
					</div>
				</div>
			@endif

			<div class="col-span-4">
				<label class="label-shared lg:text-lg">{{ __('Upload and link new media') }} :</label>
				<div class="input-mimic">
					<input type="file" name="files[]" accept=".jpg,.jpeg,.png,.gif" multiple>
				</div>
			</div>

			<div class="col-span-4 mt-2 lg:text-right">
            	<input class="button-shared w-full lg:w-auto" type="submit"  value="{{ __('Save') }}">
			</div>
			
        </form>
    </div>

</x-app-layout>