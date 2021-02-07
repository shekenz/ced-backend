<x-app-layout>
    <x-slot name="title">
        {{ $post['title'] }}
    </x-slot>

    <div class="p-4 md:text-lg text-gray-500">
        {{ $post['content'] }}
    </div>
</x-app-layout>