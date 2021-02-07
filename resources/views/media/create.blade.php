<x-app-layout>
    <x-slot name="title">
        Upload new file
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

        <form action="{{ route('media.store') }}" method="post" enctype="multipart/form-data" class="flex flex-col lg:m-2">
            @csrf
            <label class="label-shared-first lg:text-lg" for="name">{{ __('Name') }} :</label>
            <input class="input-shared" id="name" name="name" type="text" value="{{ old('name') }}" >
            <label class="label-shared lg:text-lg" for="file">File :</label>
            <input class="input-shared mt-1" id="file" name="file" type="file">
            <span class="text-gray-500">(JPG, PNG, GIF, Max 512 Ko)</span>
            <input class="button-shared md:px-4 md:self-end" type="submit">
        </form>
    </div>
</x-app-layout>