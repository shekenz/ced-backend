<x-index-layout>

	<x-slot name="title">
		{{ __('Checkout') }}
	</x-slot>

	<form method="POST" action="{{ route('cart.checkout') }}">
		@csrf
		<fieldset class="border mt-4 p-2">
			<legend>{{ __('Your contact informations') }}</legend>

			<label for="lastname">{{ __('Last name') }} :</label>
			<input type="text" name="lastname" id="lastname" maxlength="64" value="{{ old('lastname') }}">
			@error('lastname')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="firstname">{{ __('First name') }} :</label>
			<input type="text" name="firstname" id="firstname" maxlength="64" value="{{ old('firstname') }}">
			@error('firstname')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="company">{{ __('Company') }} :</label>
			<input type="text" name="company" id="company" maxlength="64" value="{{ old('company') }}">
			@error('company')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>
			
			<label for="phone">{{ __('Phone number') }} :</label>
			<input type="text" name="phone" id="phone" value="{{ old('phone') }}">
			@error('phone')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="email">{{ __('Email') }} :</label>
			<input type="text" name="email" id="email" value="{{ old('email') }}">
			@error('email')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>
		</fieldset>

		<fieldset class="border mt-4 p-2">
			<legend>{{ __('Your shipping address') }}</legend>

			<label for="shipping-address-1">{{ __('Address line 1') }} :</label>
			<input type="text" name="shipping-address-1" id="shipping-address-1" maxlength="128" value="{{ old('shipping-address-1') }}">
			@error('shipping-address-1')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="shipping-address-2">{{ __('Address line 2') }} :</label>
			<input type="text" name="shipping-address-2" id="shipping-address-2" maxlength="128" value="{{ old('shipping-address-2') }}">
			@error('shipping-address-2')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="shipping-city">{{ __('City') }} :</label>
			<input type="text" name="shipping-city" id="shipping-city" maxlength="96"  value="{{ old('shipping-city') }}">
			@error('shipping-city')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="shipping-postcode">{{ __('Postcode') }} :</label>
			<input type="text" name="shipping-postcode" id="shipping-postcode" value="{{ old('shipping-postcode') }}">
			@error('shipping-postcode')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="shipping-country">{{ __('Country') }} :</label>
			<select name="shipping-country" id="shipping-country">
				@foreach(config('countries') as $code => $country)
					<option value="{{ $code }}" {{ (old("shipping-country") == $code) ? 'selected' : '' }}>{{ $country }}</option>
				@endforeach
			</select><br>
		</fieldset>
		<fieldset class="border mt-4 p-2">
			<legend>{{ __('Your invoice address') }}</legend>

			<label for="address-duplicate">{{ __('Same as shipping address') }} :</label>
			<input type="checkbox" id="address-duplicate"><br>

			<label for="invoice-address-1">{{ __('Address line 1') }} :</label>
			<input type="text" name="invoice-address-1" id="invoice-address-1" maxlength="128" value="{{ old('invoice-address-1') }}">
			@error('invoice-address-1')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="invoice-address-2">{{ __('Address line 2') }} :</label>
			<input type="text" name="invoice-address-2" id="invoice-address-2" maxlength="128"  value="{{ old('invoice-address-2') }}">
			@error('invoice-address-2')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="invoice-city">{{ __('City') }} :</label>
			<input type="text" name="invoice-city" id="invoice-city" maxlength="96" value="{{ old('invoice-city') }}">
			@error('invoice-city')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="invoice-postcode">{{ __('Postcode') }} :</label>
			<input type="text" name="invoice-postcode" id="invoice-postcode" value="{{ old('invoice-postcode') }}">
			@error('invoice-postcode')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>

			<label for="invoice-country">{{ __('Country') }} :</label>
			<select name="invoice-country" id="invoice-country">
				@foreach(config('countries') as $code => $country)
					<option value="{{ $code }}" {{ (old("invoice-country") == $code) ? 'selected' : '' }}>{{ $country }}</option>
				@endforeach
			</select><br>
			<input type="hidden" id="invoice-country-hidden" name="invoice-country" disabled>
		</fieldset>
			<label for="sale-conditions">{{ __('Accept sale condition') }} :</label>
			<input type="checkbox" name="sale-conditions" value="1" id="sale-conditions" {{ old('sale-conditions') ? 'checked' : '' }}>
			@error('sale-conditions')
				<span class="text-red-500">{{ $message }}</span>
			@enderror
			<br>
			<input class="base-button" type="submit" value="{{ __('Next') }}">

		
</x-index-layout>