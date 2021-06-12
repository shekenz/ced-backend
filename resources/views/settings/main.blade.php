<x-app-layout>
	<x-slot name="title">
		{{ __('Settings') }}
	</x-slot>

	<form method="POST" action="{{ route('settings.update') }}">
			@csrf
			@method('patch')
			<div class="flex gap-x-4">
				<div class="flex-grow">
					<label class="label-shared lg:text-lg" for="about-0">{{ __('About: First Column') }}</label>
					<textarea class="input-shared h-96" id="about-0" name="about[]">{!! (Storage::disk('raw')->exists('about_0.txt')) ? Storage::disk('raw')->get('about_0.txt') : '' !!}</textarea>
				</div>
				<div class="flex-grow">
					<label class="label-shared lg:text-lg" for="about-1">{{ __('About: Second Column') }}</label>
					<textarea class="input-shared h-96" id="about-1" name="about[]">{!! (Storage::disk('raw')->exists('about_1.txt')) ? Storage::disk('raw')->get('about_1.txt') : '' !!}</textarea>
				</div>
			</div>
			<div class="text-right mt-4">
				<input class="button-shared" type="submit">
			</div>
	</form>
</x-layout-app>