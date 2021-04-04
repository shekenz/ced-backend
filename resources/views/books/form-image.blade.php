<div class="h-20 bg-gray-300 text-white rounded-sm shadow-sm overflow-hidden">
	<input class="absolute" id="mediumId{{ $medium->id }}" name="{{ $inputName }}[]" type="checkbox" value="{{ $medium->id }}">
	<label for="mediumId{{ $medium->id }}"><img class="w-full h-full" src="{{ asset('storage/uploads/'.$medium->filename) }}"></label>
</div>