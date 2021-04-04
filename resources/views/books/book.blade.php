<article id="glide-{{ $bookGlideIndex }}"class="grid grid-cols-9">
	<div class="
		base-slider
		col-span-9
		mr-0
		xl:col-span-7
		xl:mr-12
	" data-slick='{"slidesToShow": 1, "slidesToScroll": 4}'>
		<div class="glide">
			<div data-glide-el="track" class="glide__track">
				<ul class="glide__slides">
					@foreach ($book->media as $medium)
						<li class="glide__slide text-center"><img class="m-auto" src="{{ asset('storage/uploads/'.$medium->filename) }}"></li>
					@endforeach
				</ul>
			</div>
			<div class="glide__arrows hidden xl:block" data-glide-el="controls">
				<button class="glide__arrow2 glide__arrow2--left" data-glide-dir="<"></button>
				<button class="glide__arrow2 glide__arrow2--right" data-glide-dir=">"></button>
			</div>
			<div class="glide__bullets xl:hidden" data-glide-el="controls[nav]">
				<button class="glide__bullet" data-glide-dir="=0"></button>
				<button class="glide__bullet" data-glide-dir="=1"></button>
				<button class="glide__bullet" data-glide-dir="=2"></button>
			</div>
					
		</div>
		<div id="counter-{{ $bookGlideIndex }}" class="hidden xl:block xl:mt-8 xl:mb-12"><span class="counter-index">1</span>/<span class="counter-total">{{ $book->media->count() }}</span>.</div>
	</div>
	<div id="info" class="
		grid
		grid-cols-3
		col-span-9
		pb-16
		pt-4
		xl:pt-0
		xl:block
		xl:col-start-8
		xl:col-span-2
	">
		<div class="">
				{{ $book->title }}<br>
				{{ $book->author }}<br><br>
				@if ( !(empty($book->height) || empty($book->width)) )
				{{ $book->height }}mm x {{ $book->width }}mm<br>
				@endif
				@if ( !empty($book->cover) )
				{{ $book->cover }}<br>
				@endif
				@if ( !empty($book->pages) )
					{{ $book->pages }} pages<br>
				@endif
				@if ( !empty($book->price) )
					{{ $book->edition }}<br>
				@endif
				<br>
				@if ( !empty($book->price) )
					{{ $book->price }} €<br><a href="#" class="underline hover:bg-black hover:text-white">Add to cart</a><br><br>
				@endif
				@auth
					<a href="{{ route('books.edit', $book->id) }}" class="base-con-edit">{{ __('Edit in Dashboard') }}</a><br><br>
					<a href="{{ route('books.archive', $book->id) }}" class="base-con-edit">{{ __('Archive') }}</a><br><br>
				@endauth
		</div>
		<div class="col-span-2">
			<p class="mb-6 mr-6">
				{{ $book->description }}
			</p>
		</div>
	</div>
</article>