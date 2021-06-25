<div id="flash-wrapper" class="@if($attributes->has('permanent')) {{ 'permanent' }} @endif">
	<div {{ $attributes->merge(['class' => 'text-gray-900 p-2 rounded-lg mb-4 text-center transition-all duration-300']) }}>
		{{ $message }}
	</div>
</div>