<div class="h-20 bg-gray-300 text-white rounded-sm shadow-sm">
	<input class="absolute" id="mediumId{{ $medium->id }}" name="media[]" type="checkbox" value="{{ $medium->id }}">
	<label for="mediumId{{ $medium->id }}"><img src="{{ asset('storage/uploads/'.$medium->filename) }}"></label>
</div>