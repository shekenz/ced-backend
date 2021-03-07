<x-index-layout>
	<x-slot name="title">
		{{ __('Contact') }}
	</x-slot>

	<form class="text-custom grid md:grid-cols-9 xl:gap-4 xl:items-center" action="#" method="post" enctype="multipart/form-data">
		<label class="sm:mt-0 mb-1 md:col-start-2 xl:mt-0 xl:col-start-3 xl:text-right" for="email">{{ __('Email') }}</label>
		<input class="md:col-start-2 md:col-span-7 xl:col-span-3 shadow-md dark:bg-dark-800 border-dark-200 dark:shadow-none" id="email" name="email" type="text">
		<label class="mt-4 mb-1 md:row-start-3 md:col-start-2 xl:mt-0 xl:row-start-2 xl:col-start-3 xl:text-right" for="subject">{{ __('Sujet') }}</label>
		<input class="md:row-start-4 md:col-start-2 md:col-span-7 xl:row-start-2 xl:col-start-4 xl:col-span-3 shadow-md dark:bg-dark-800 border-dark-200 dark:shadow-none" id="subject" name="subject" type="text">
		<label class="mt-4 mb-1 md:row-start-5 md:col-start-2 xl:row-start-3 xl:col-start-3 xl:text-right xl:self-start xl:mt-2" for="message">{{ __('Message') }}</label>
		<textarea class="h-72 md:row-start-6 md:col-start-2 md:col-span-7 xl:row-start-3 xl:col-start-4 xl:col-span-3 md:h-96 shadow-md dark:bg-dark-800 border-dark-200 dark:shadow-none" id="message" name="message"></textarea>
		<span class="my-4 md:row-start-7 md:col-start-2 md:col-span-7 xl:mt-0 text-right xl:row-start-4 xl:col-start-6 xl:col-span-1">
			<button class="base-button">{{ __('Envoyer') }}</button>
		</span>
	</form>

</x-index-layout>