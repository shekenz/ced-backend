<div id="article-{{ $article->id }}" class="grid grid-cols-3 md:block">
	<div class="col-span-2">
		<img class="mb-4 w-full" src="{{ asset('storage/'.$article->media->get(0)->preset('md')) }}" alt="test thumbnail">
	</div>
	<div class="ml-3 md:ml-0">
	<p class="mb-2 md:mb-3">
		{{ $article->title }}<br>
		@if(isset($article->author))
			{{ $article->author }}
		@else
			&nbsp;
		@endif
	</p>
	<p class="mb-2 md:mb-3">
		{{ __('Quantity') }} : <span id="quantity-for-id-{{ $article->id }}">{{ $article->cartQuantity }}</span> <a class="qte-button base-link" href="{{ route('cart.api.add', $article->id) }}">+</a>&nbsp;\&nbsp;<a class="qte-button base-link" href="{{ route('cart.api.remove', $article->id) }}">-</a><br>
		{{ __('Subtotal') }} : <span id="subtotal-for-id-{{ $article->id }}">{{ $article->price * $article->cartQuantity }}</span>€
	</p>
	<p class="mb-2 md:mb-3">
		<a href="{{ route('cart.removeAll', $article->id) }}" class="base-link">{{ __('Retirer') }} </a>
	</p>
	</div>
</div>
