<x-index-layout>
	<x-slot name="title">
		{{ __('Contact') }}
	</x-slot>

	@if ($errors->any())
			<div class="mb-4 m-auto max-w-lg">
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
	<form class="text-custom grid md:grid-cols-9 xl:gap-4 xl:items-center" action="{{ route('messages.forward') }}" method="post" enctype="multipart/form-data" autocomplete="off">
		@csrf
		<label class="sm:mt-0 mb-1 md:col-start-2 xl:mt-0 xl:col-start-3 xl:text-right" for="email">{{ __('Email') }}</label>
		<input class="md:col-start-2 md:col-span-7 xl:col-span-3" id="email" name="email" type="email" value="{{ old('email') }}">
		<label class="mt-4 mb-1 md:row-start-3 md:col-start-2 xl:mt-0 xl:row-start-2 xl:col-start-3 xl:text-right" for="subject">{{ __('Sujet') }}</label>
		<input class="md:row-start-4 md:col-start-2 md:col-span-7 xl:row-start-2 xl:col-start-4 xl:col-span-3" id="subject" name="subject" type="text" value="{{ old('subject') }}">
		<label class="mt-4 mb-1 md:row-start-5 md:col-start-2 xl:row-start-3 xl:col-start-3 xl:text-right xl:self-start xl:mt-2" for="message">{{ __('Message') }}</label>
		<textarea class="h-72 md:row-start-6 md:col-start-2 md:col-span-7 xl:row-start-3 xl:col-start-4 xl:col-span-3 md:h-96" id="message" name="message">{{ old('content') }}</textarea>
		<span class="my-4 md:row-start-7 md:col-start-2 md:col-span-7 xl:mt-0 text-right xl:row-start-4 xl:col-start-6 xl:col-span-1">
			<button class="button">{{ __('Envoyer') }}</button>
		</span>
	</form>

</x-index-layout>