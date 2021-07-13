<x-app-layout>
	<x-slot name="title">
		{{ __('Settings') }}
	</x-slot>

	<x-slot name="scripts">
		<script src="{{ asset('js/settings.js') }}" defer></script>
	</x-slot>

	{{-------------------------------------- Form Errors --------------------------------------}}
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
	{{-------------------------------------- Switches --------------------------------------}}
	<div class="border-b flex justify-between items-center">
		<label class="label-shared lg:text-lg">{{ __('Published') }}</label>
		<div class="text-[1.25rem]">
			<form action="{{ route('settings.publish') }}" method="POST">
				@csrf
				<button id="publish-switch" title="{{ __('Publish site') }}" class="switch @if(!setting('app.published')) {{ 'off' }} @endif">
				</button>
			</form>
		</div>
	</div>
	<div class="border-b flex justify-between items-center">
		<label class="label-shared lg:text-lg">{{ __('Enable e-shop') }}</label>
		<div class="text-[1.25rem]">
			<form action="{{ route('settings.toggleShop') }}" method="POST">
				@csrf
				<button id="publish-switch" title="{{ __('Enable shop') }}" class="switch @if(!setting('app.shop.enabled')) {{ 'off' }} @endif">
				</button>
			</form>
		</div>
	</div>
	{{-------------------------------------- Coupons --------------------------------------}}
	<div class="mt-10">
		<h2 class="label-shared lg:text-lg">{{ __('Coupons') }}</h2>
			<div id="coupons-wrapper" class="border grid grid-cols-6 gap-2 p-2">
				@foreach($coupons as $coupon)
					{{-- If coupon has expired OR coupon used equal quantity AND coupon quantity is not 0 --}}
					@if($coupon->expires_at->lt(\Carbon\Carbon::now()) || ($coupon->quantity === $coupon->used && $coupon->quantity !== 0 ))
						<div class="coupon border border-dotted bg-red-200 border-red-500 text-center py-2">
							<span class="font-bold">{{ $coupon->label }}</span> -{{ $coupon->value}}@if($coupon->type){{ '€' }}@else{{ '%' }}@endif{{ ' ('.$coupon->used }}@if($coupon->quantity){{ '/'.$coupon->quantity }}@endif{{ ')' }}
						</div>
					@else
						<div class="coupon border border-dotted bg-gray-100 border-gray-400 text-center py-2">
							<span class="font-bold">{{ $coupon->label }}</span> -{{ $coupon->value}}@if($coupon->type){{ '€' }}@else{{ '%' }}@endif{{ ' ('.$coupon->used }}@if($coupon->quantity){{ '/'.$coupon->quantity }}@endif{{ ')' }}
						</div>
					@endif
				@endforeach
				<a id="add-coupon" href="{{ route('coupons.add') }}" class="bg-green-300 hover:bg-green-400 transition duration-300 rounded text-white text-center font-bold uppercase py-2">{{ __('Add coupon') }}</a>
			</div>
	</div>
	{{-------------------------------------- Shipping methods --------------------------------------}}
	<div class="mt-10">
		<h2 class="label-shared lg:text-lg">{{ __('Shipping methods') }} : </h2>
		<table class="shipping-method w-full m-auto">
			@foreach($shippingMethods as $shippingMethod)
				<tr>
					<td class="font-bold">{{ $shippingMethod->label }}</td>
					<td>{!! preg_replace('/\{tracking\}/', '<span class="font-bold text-white bg-gray-400 text-sm px-1 py-0.5 mx-0.5 uppercase rounded">tracking</span>', $shippingMethod->tracking_url) !!}</td>
					<td class="font-bold text-right">{{ $shippingMethod->price }} €</td>
					<td class="text-right w-14">
						<a href="{{ route('shippingMethods.delete', $shippingMethod->id) }}"><x-tabler-trash class="icon text-red-300 hover:text-red-500 inline-block"/></a>
					</td>
				</tr>
			@endforeach
		</table>
		<form class="flex justify-center items-end m-auto gap-x-2 w-full mt-2" method="post" action="{{ route('shippingMethods.add') }}">
			@csrf
			<div class="flex w-full gap-x-2">
				<input type="text" class="input-shared h-12 w-1/4" placeholder="{{ __('Label') }}" name="label" value="{{ old('label') ?? ''}}"">
				<input type="text" class="input-shared h-12 w-1/4" placeholder="{{ __('Price') }}" name="price" value="{{ old('price') ?? ''}}">
				<input type="text" class="input-shared h-12" placeholder="{{ __('Tracking URL') }}" name="tracking_url" value="{{ old('tracking_url') ?? ''}}">
			</div>
			<button id="shipping-method-form-submit" class="bg-green-300 hover:bg-green-400 transition duration-300 rounded text-white p-2 h-12">
				<x-tabler-circle-plus class="w-8 h-8"/>
			</button>
		</form>
		<span class="text-sm italic text-gray-500">(Important : Enter {tracking} in place of the actual tracking number in the URL string)</span>
	</div>
	{{-------------------------------------- Other settings --------------------------------------}}
	<form method="POST" action="{{ route('settings.update') }}">
		@csrf
		@method('patch')
		<div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-10">
			{{-------------------------------------- Country list --------------------------------------}}
			<div class="col-span-2">
				@php
					$countryList = (setting('app.shipping.allowed-countries')) ? implode(',', setting('app.shipping.allowed-countries')) : '';
				@endphp
				<label for="shipping-allowed-countries" class="label-shared lg:text-lg">{{ __('Shipping to countries (Country codes separated by a coma, leave blank for international)') }} : </label>
				<input type="text" class="input-shared" id="shipping-allowed-countries" name="shipping-allowed-countries" value="{{ old('shipping-allowed-countries') ??  $countryList }}">
			</div>
			{{-------------------------------------- Paypal credentials --------------------------------------}}
			<div class="col-span-2  mt-8">
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
			{{-------------------------------------- About --------------------------------------}}
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