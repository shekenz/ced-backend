<x-app-layout>
	<x-slot name="title">
		{{ __('Settings') }}
	</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/settings.js') }}" defer></script>
	</x-slot>

	<form method="POST" action="{{ route('settings.update') }}">
			@csrf
			@method('patch')
			@if ($errors->any())
				<div class="mb-4" :errors="$errors">
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
			<div>
				<label class="label-shared lg:text-lg">{{ __('Shipping methods') }} : </label>
				<table>
					<tr>
						<td>{{ $shippingMethods->label }}</td>
						<td>{{ $shippingMethods->price }}€</td>
					</tr>
				</table>
			</div>
			<div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-8">
				<div class="col-span-2">
					<label for="paypal-client-id" class="label-shared lg:text-lg">{{ __('Paypal client ID') }} : </label>
					<input type="text" class="input-shared" id="paypal-client-id" name="paypal-client-id" value="{{ old('paypal-client-id') ?? setting('app.paypal.client-id') }}">
				</div>
				<div class="col-span-2">
					<label for="paypal-secret" class="label-shared lg:text-lg">{{ __('Paypal secret') }} : </label>
					<input type="text" class="input-shared" id="paypal-secret" name="paypal-secret" value="{{ old('paypal-secret') ?? setting('app.paypal.secret') }}">
				</div>
				<div class="col-span-2">
					<label for="paypal-sandbox" class="label-shared lg:text-lg">{{ __('Sandbox') }} : </label>
					<input type="checkbox" class="" id="paypal-sandbox" name="paypal-sandbox" value="true" {{ (old('paypal-sandbox') || setting('app.paypal.sandbox')) ? 'checked' : '' }}>
				</div>
				<div class="col-span-2 mt-8">
					@php
						$countryList = (setting('app.shipping.allowed-countries')) ? implode(',', setting('app.shipping.allowed-countries')) : '';
					@endphp
					<label for="shipping-allowed-countries" class="label-shared lg:text-lg">{{ __('Shipping to countries (Country codes separated by a coma, leave blank for international)') }} : </label>
					<input type="text" class="input-shared" id="shipping-allowed-countries" name="shipping-allowed-countries" value="{{ old('shipping-allowed-countries') ??  $countryList }}">
				</div>
				<div class="mt-8">
					<label class="label-shared lg:text-lg" for="about-0">{{ __('About: First Column') }}</label>
					<textarea class="input-shared h-96" id="about-0" name="about[]">{!! (Storage::disk('raw')->exists('about_0.txt')) ? Storage::disk('raw')->get('about_0.txt') : '' !!}</textarea>
				</div>
				<div class="mt-8">
					<label class="label-shared lg:text-lg" for="about-1">{{ __('About: Second Column') }}</label>
					<textarea class="input-shared h-96" id="about-1" name="about[]">{!! (Storage::disk('raw')->exists('about_1.txt')) ? Storage::disk('raw')->get('about_1.txt') : '' !!}</textarea>
				</div>
			</div>
			<div class="text-right mt-4">
				<input class="button-shared" type="submit" value="{{ __('Save') }}">
			</div>
	</form>
</x-layout-app>