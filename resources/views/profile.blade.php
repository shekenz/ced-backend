<x-app-layout>

            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="m-auto sm:m-0">
                    <img class="rounded-full shadow-md w-32 sm:w-16 my-2 sm:my-0 sm:mr-4" src="{{ asset('img/default-thumbnail.jpg') }}" alt="Test thumbnail">
                </div>
                <div class="mx-3 sm:mx-0 my-2 sm:my-0">
                    <span class="text-xl">{{ $user->username }}</span><br>
                    <span class="text-gray-500">{{ $user->email }}</span>
                </div>
            </div>

</x-app-layout>
