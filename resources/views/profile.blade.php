<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:align-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex-grow md:flex-none">
                    <img class="rounded-full shadow-md w-32 md:w-16 mx-auto mt-5 md:m-4" src="{{ asset('img/default-thumbnail.jpg') }}" alt="Test thumbnail">
                </div>
                <div class="flex-grow p-4 md:px-0">
                    <span class="text-xl">{{ Auth::user()->username }}</span><br>
                    <span class="text-gray-500">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
