<x-app-layout>
        @if($user->username == Auth::user()->username)
            <x-slot name="title">
                {{ __('Edit your profile') }}
            </x-slot>
            <div class="flex flex-col gap-8 sm:flex-row items-start p-8">
                <div class="flex-none m-auto sm:m-0 text-center">
                    <img class="rounded-full shadow-md border border-gray-400 w-32 sm:w-48 my-2" src="{{ asset('img/default-thumbnail.jpg') }}" alt="Test thumbnail">
                    <a href="#" class="default text-sm">Edit profile picture</a>
                </div>
                <div class="flex-none mx-3 sm:mx-0 my-2">
                    @if ($errors->any())
                        <div class="mb-4">
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

                    <form action="{{ route('users.update', $user->id) }}" method="post" class="lg:w-96">
                        @csrf
                        @method('PATCH')
                        <label for="username" class="label-shared">{{ __('Username') }}</label>
                        <input id="username" name="username" type="text" class="input-shared" value="{{ old('username') ?? $user->username }}">
                        <label for="firstname" class="label-shared">{{ __('First name') }}</label>
                        <input id="firstname" name="firstname" type="text" class="input-shared" value="{{ old('firstname') ?? $user->firstname }}">
                        <label for="lastname" class="label-shared">{{ __('Last name') }}</label>
                        <input id="lastname" name="lastname" type="text" class="input-shared" value="{{ old('lastname') ?? $user->lastname }}">
                        <label for="email" class="label-shared">{{ __('Email') }}</label>
                        <input id="email" name="email" type="text" class="input-shared" value="{{ old('email') ?? $user->email }}">
                        <label for="password" class="label-shared">{{ __('New password') }}</label>
                        <input id="password" name="password" type="password" class="input-shared">
                        <label for="password_confirmation" class="label-shared">{{ __('Confirm password') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="input-shared">
                        <label for="birthdate" class="label-shared">{{ __('Birthdate') }}</label>
                        <input id="birthdate" name="birthdate" type="date" class="input-shared" value="{{ old('birthdate') ?? $user->birthdate }}">
                        <input class="button-shared" type="submit">
                    </form>
                </div>
            </div>
        @else
            <x-slot name="title">
                You don't have access to this section
            </x-slot>
        @endif


</x-app-layout>
