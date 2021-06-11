<div class="bg-transparent text-white rounded-sm shadow-sm inline-block mt-3 ml-3 cursor-grab" draggable="true">
	@if ($input)
		<input name="media[]" type="hidden" value="{{ $medium->id }}">
	@endif
	<img class="not-draggable" src="{{ asset('storage/'.$medium->preset('thumb')) }}" data-id="{{ $medium->id }}">
</div>