<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Post') }}
    </x-slot>

    <x-slot name="controls">
       <a href="{{ route('posts') }}" class="button-shared">{{ __('Cancel') }}</a> 
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

        <form action="{{ route('posts.update', $post->id) }}" method="post" class="flex flex-col lg:m-2">
            @csrf
            @method('patch')
            <label class="label-shared-first lg:text-lg" for="title">{{ __('Title') }} :</label>
            <input class="input-shared" id="title" name="title" type="text" value="{{ old('title') ?? $post->title}}">
            <label class="label-shared lg:text-lg" for="content">{{ __('Article') }} :</label>
            <textarea id="editor" class="input-shared h-96" name="content">{{ old('content') ?? $post->content }}</textarea>
            <input type="hidden" name="lang" value="fr">
            <input class="button-shared md:px-4 md:self-end" type="submit">
        </form>
    </div>
</x-app-layout>