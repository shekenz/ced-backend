<div class="grid grid-cols-3 md:block">
	<div class="col-span-2">
		<img class="mb-6 md:mb-4 xl:mb-6" src="img/testimage_thumb_{{ rand(1,2) }}.jpg" alt="test thumbnail">
	</div>
	<div class="ml-3 md:ml-0">
	<p class="mb-2 md:mb-3 xl:mb-6">
		{{ $title }}<br>
		{{ $artist }}
	</p>
	<p class="mb-2 md:mb-3 xl:mb-6">
		Quantity : {{ $quantity }}
	</p>
	<p class="mb-2 md:mb-3 xl:mb-6">
		<a href="#" class="base-link">Remove</a>
	</p>
	</div>
</div>
