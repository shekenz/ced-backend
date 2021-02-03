<x-app-layout>
    <x-slot name="title">
        Posts
    </x-slot>

    <a href="{{ route('posts.create') }}" class="default">{{ __('New') }}</a>
</x-app-layout>