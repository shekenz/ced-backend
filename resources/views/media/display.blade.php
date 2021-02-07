<x-app-layout>
    <x-slot name="title">
        {{ $medium['name'] }}
    </x-slot>

    <div class="p-4 md:p-8">
        <img class="m-auto" src="{{ asset('storage/uploads/'.$medium['filename']) }}">
    </div>
</x-app-layout>