<article class="grid grid-cols-9 mx-20">
	<div class="base-slider col-span-7 mr-12" data-slick='{"slidesToShow": 1, "slidesToScroll": 4}'>
		{{-- <div class="base-slider-wrapper"> --}}
			<div class="glide">
				<div data-glide-el="track" class="glide__track">
					<ul class="glide__slides">
						<li class="glide__slide"><img src="{{ asset('img/testimage_full.jpg') }}" alt="test image"></li>
						<li class="glide__slide"><img src="{{ asset('img/testimage_full.jpg') }}" alt="test image"></li>
						<li class="glide__slide"><img src="{{ asset('img/testimage_full.jpg') }}" alt="test image"></li>
					</ul>
				</div>
				<div class="glide__arrows" data-glide-el="controls">
					<button class="glide__arrow glide__arrow--left" data-glide-dir="<">prev</button>
					<button class="glide__arrow glide__arrow--right" data-glide-dir=">">next</button>
				</div>
			</div>

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