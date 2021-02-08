<x-guest-layout>
    <x-auth-card>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- Last name -->
            <div class="mt-4">
                <x-label for="lastname" :value="__('Last name')" :required="true" />
                <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" maxlength="64" :value="old('lastname')" required autofocus />
            </div>

            <!-- First name -->
            <div class="mt-4">
                <x-label for="firstname" :value="__('First name')" :required="true" />
                <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" maxlength="64" :value="old('firstname')" required autofocus />
            </div>

            <!-- Username -->
            <div class="mt-4">
                <x-label for="username" :value="__('Username')" :required="true" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" maxlength="64" :value="old('username')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" :required="true" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" :required="true" />
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" :required="true" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
            
            <!-- Birth date -->
            <div class="mt-4">
                <x-label for="birthdate" :value="__('Birth date')"/>
                <x-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
