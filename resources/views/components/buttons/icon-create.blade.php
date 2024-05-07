@props(['name', 'href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-icon-only btn-outline-primary']) }} title="Create">
    <x-icons.plus/>
</a>