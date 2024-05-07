@props(['href', 'title'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-sm btn-gray-800 d-inline-flex align-items-center']) }}>
    {{ __('Update') }} {{ $title }}
</a>
