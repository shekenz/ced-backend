<x-index-layout lang="FR_fr">

	<x-slot name="title">Index</x-slot>

	<?php $randMax = rand(3,10) ?>
	@for ($i = 0; $i < $randMax; $i++)
	<article class="grid grid-cols-9 mx-20">
		<div class="slider col-span-7 mr-12">
			<img src="{{ asset('img/testimage_full.jpg') }}" alt="test image">
		</div>
		<div id="info" class="col-start-8 col-span-2">
			<p class="mb-6">
				{{ $title }}<br>{{ $artist }}
			</p>
			<p class="mb-6">
				{{ $size }}<br>{{ $coverType }}<br>{{ $pages }} pages<br>{{ $edition }}
			</p>
			<p class="mb-6">
				{{ $price }} €<br><a href="#" class="underline hover:bg-black hover:text-white">add to cart</a>
			</p>
			<p class="mb-6 mr-6">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh.
			</p>
		</div>
		<div class="col-span-9 mt-8 mb-12">1/12.</div>
	</article>
	@endfor
</x-index-layout>