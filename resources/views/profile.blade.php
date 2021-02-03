<x-app-layout>

            <div class="flex flex-row items-center">
                <div class="flex-grow md:flex-none">
                    <img class="rounded-full shadow-md w-32 sm:w-16 sm:mr-4" src="{{ asset('img/default-thumbnail.jpg') }}" alt="Test thumbnail">
                </div>
                <div class="flex-grow">
                    <span class="text-xl">{{ $user->username }}</span><br>
                    <span class="text-gray-500">{{ $user->email }}</span>
                </div>
            </div>

</x-app-layout>
