@props(['value', 'required' => false, 'format' => false])

@if($required)
<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-gray-700']) }}>
@else
<label {{ $attributes->merge(['class' => 'block text-sm text-gray-700']) }}>
@endif
    {{ $value ?? $slot }}
    @if($required)
        <span class="font-normal text-sm">({{ __('Required') }})</span>
    @endif
    @if($format)
        <span class="font-normal text-sm">({{ $format }})</span>
    @endif
</label>
