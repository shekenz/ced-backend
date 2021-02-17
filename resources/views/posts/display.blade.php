<x-app-layout>
    <x-slot name="title">
        {{ $post->title }}
    </x-slot>

    <x-slot name="controls">
       <a href="{{ route('posts.edit', $post->id) }}" class="button-shared">{{ __('Edit') }}</a> 
    </x-slot>

    <div class="p-4 md:text-lg text-gray-500">
        {{ $post->content }}
    </div>
</x-app-layout>