<x-app-layout>
	<x-slot name="title">
		{{ __('New book') }}
	</x-slot>

	<x-slot name="controls">
		<a href="{{ route('books') }}" class="button-shared">{{ __('Cancel') }}</a> 
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

        <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data" class="flex flex-col gap-y-2 md:grid md:grid-cols-4 lg:m-2 md:gap-x-4">
            @csrf
			<div>
				<label class="label-shared-first lg:text-lg" for="title">{{ __('Title') }} :</label>
				<input class="input-shared" id="title" name="title" type="text" value="{{ old('title') }}" maxlength="128">
			</div>
			<div class="md:row-start-2">
				<label class="label-shared-first lg:text-lg" for="author">{{ __('Author') }} :</label>
				<input class="input-shared" id="author" name="author" type="text" value="{{ old('author') }}" maxlength="64">
			</div>
			<div>
				<label class="label-shared-first lg:text-lg" for="width">{{ __('Width (mm)') }} :</label>
				<input class="input-shared" id="width" name="width" type="number" value="{{ old('width') }}">
			</div>
			<div class="md:row-start-2">
				<label class="label-shared-first lg:text-lg" for="height">{{ __('Height (mm)') }} :</label>
				<input class="input-shared" id="height" name="height" type="number" value="{{ old('height') }}">
			</div>
			<div>
				<label class="label-shared-first lg:text-lg" for="cover">{{ __('Cover') }} :</label>
				<input class="input-shared" id="cover" name="cover" type="text" value="{{ old('cover') }}" maxlength="32">
			</div>
			<div class="md:row-start-2">
				<label class="label-shared-first lg:text-lg" for="pages">{{ __('Pages') }} :</label>
				<input class="input-shared" id="pages" name="pages" type="number" value="{{ old('pages') }}">
			</div>
			<div>
				<label class="label-shared-first lg:text-lg" for="edition">{{ __('Edition') }} :</label>
				<input class="input-shared" id="edition" name="edition" type="text" value="{{ old('edition') }}" maxlength="64">
			</div>
			<div class="md:row-start-2">
				<label class="label-shared-first lg:text-lg" for="price">{{ __('Price') }} :</label>
				<input class="input-shared" id="price" name="price" type="text" value="{{ old('price') }}" maxlength="10">
			</div>
			<div class="col-span-4">
				<label class="label-shared lg:text-lg" for="description">{{ __('Description') }} :</label>
				<textarea id="description" class="input-shared h-96" name="description">{{ old('description') }}</textarea>
			</div>
			<input type="hidden" name="lang" value="fr">

			@if( $media->isNotEmpty() )
			<div class="col-span-4">
				<label class="label-shared lg:text-lg">{{ __('Link media from the library') }} :</label>
				<div class="input-mimic grid grid-cols-3 md:grid-cols-7 lg:grid-cols-10 xl:grid-cols-12 gap-4">
					<? $inputName = 'media'; ?>
					@foreach($media as $medium)
						@include('books.form-image')
					@endforeach
				</div>
			</div>
			@endif

			<div class="col-span-4">
				<label class="label-shared lg:text-lg">{{ __('Upload and link new media') }} :</label>
				<div class="input-mimic">
				{{-- <div class="input-mimic grid grid-cols-3 md:grid-cols-7 lg:grid-cols-10 xl:grid-cols-12 gap-4"> --}}
					<input type="file" name="files[]" accept=".jpg,.jpeg,.png,.gif" multiple>
				</div>
			</div>

			<div class="col-span-4 mt-2 lg:text-right">
            	<input class="button-shared w-full lg:w-auto" type="submit">
			</div>
			
        </form>
    </div>

</x-app-layout>