<div class="bg-gray-300 text-white rounded-sm shadow-sm overflow-hidden">
	<input class="absolute" id="mediumId{{ $medium->id }}" name="{{ $inputName }}[]" type="checkbox" value="{{ $medium->id }}">
	<label for="mediumId{{ $medium->id }}"><img class="" src="{{ asset('storage/uploads/'.$medium->thumb) }}"></label>
</div>