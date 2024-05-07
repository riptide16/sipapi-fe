@props(['href', 'title'])

@if(isset($href))
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-sm btn-gray-800 d-inline-flex align-items-center']) }}>
    <x-icons.plus/>
    {{ __('Create') }} {{ $title }}
</a>
@else
<button type="button" {{ $attributes->merge(['class' => 'btn btn-sm btn-gray-800 d-inline-flex align-items-center']) }}>
    <x-icons.plus/>
    {{ __('Create') }} {{ $title }}
</button>
@endif
