@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-icon-only btn-outline-info']) }} title="View">
    <x-icons.eye/>
</a>