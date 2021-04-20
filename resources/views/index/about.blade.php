<x-index-layout lang="FR_fr">

	<x-slot name="title">About</x-slot>

	<div class="
		mx-4
		md:grid
		md:grid-cols-9
		md:mx-0
	">
		<div class="slider
			md:col-span-4
			xl:col-start-2
			xl:col-span-3
			xl:mr-12
		">
			{!! (Storage::disk('raw')->exists('about_0.txt')) ? nl2br(Storage::disk('raw')->get('about_0.txt')) : '' !!}
		</div>
		<div class="
			md:col-start-6
			md:col-span-4
			xl:col-start-6
			xl:col-span-3
		">
			{!! (Storage::disk('raw')->exists('about_1.txt')) ? nl2br(Storage::disk('raw')->get('about_1.txt')) : '' !!}
		</div>
		{{-- <div class="col-span-9 xl:col-start-2 xl:col-span-7 my-8"><a href="#" class="base-link">terms and condition</a></div> --}}
	</div>
</x-index-layout>