@props(['name', 'href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-icon-only btn-outline-success']) }} title="Edit">
    <x-icons.pencil/>
</a>