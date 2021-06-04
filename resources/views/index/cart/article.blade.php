<div class="grid grid-cols-3 md:block">
	<div class="col-span-2">
		<a href="/#{{ Str::slug($article->title, '-') }}"><img class="mb-4 w-full" src="{{ asset('storage/'.$article->media->get(0)->preset('md')) }}" alt="test thumbnail"></a>
	</div>
	<div class="ml-3 md:ml-0">
	<p class="mb-2 md:mb-3">
		<a class="base-link" href="/#{{ Str::slug($article->title, '-') }}">{{ $article['title'] }}</a><br>
		@if(isset($article['author']))
			{{ $article['author'] }}
		@else
			&nbsp;
		@endif
	</p>
	<p class="mb-2 md:mb-3">
		{{ __('Quantity') }} : {{ $article['cartQuantity'] }} <a class="base-link" href="{{ route('cart.add', $article->id) }}">+</a>&nbsp;\&nbsp;<a class="base-link" href="{{ route('cart.remove', $article->id) }}">-</a><br>
		{{ __('Subtotal') }} : {{ $article['price'] * $article['cartQuantity'] }}€
	</p>
	<p class="mb-2 md:mb-3">
		<a href="{{ route('cart.removeAll', $article->id) }}" class="base-link">{{ __('Retirer') }} </a>
	</p>
	</div>
</div>
