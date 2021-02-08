<x-app-layout>
    <x-slot name="title">
        Posts
    </x-slot>

    <div class="p-4 border-b border-gray-200">
    <a href="{{ route('posts.create') }}" class="button-shared">{{ __('New') }}</a>
    </div>

    <div class="flex flex-row py-1 px-4 border-b border-gray-200">
        <span class="flex-none font-bold">Title</span>
        <span class="flex-grow"></span>
        <span class="flex-none">Created by</span>
    </div>

    @foreach(Auth::user()->posts as $post)
        <div class="flex flex-row text-gray-500 py-1 px-4 border-b border-gray-200">
            <a href="{{ route('posts.display', $post->id) }}" class="flex-none default">{{ $post->title }}</a>
            <span class="flex-grow"></span>
            <span class="flex-none italic">{{ $post->created_at }} by  {{ $post->user->username }}</span>
        </div>
    @endforeach
</x-app-layout>