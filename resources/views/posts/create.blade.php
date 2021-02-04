<x-app-layout>
    <x-slot name="title">
        Create Post
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

    <form action="{{ route('posts.store') }}" method="post" class="flex flex-col">
        @csrf
        <label class="label-shared lg:text-lg" for="title">{{ __('Title') }} :</label>
        <input class="input-shared" id="title" name="title" type="text" value="{{ old('title') }}">
        <label class="label-shared lg:text-lg" for="content">{{ __('Article') }} :</label>
        <textarea id="editor" class="input-shared h-96" name="content">{{ old('content') }}</textarea>
        <input type="hidden" name="lang" value="fr">
        <input class="button-shared lg:w-24" type="submit">
    </form>
</x-app-layout>