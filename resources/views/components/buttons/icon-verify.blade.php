@props(['name', 'href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-icon-only btn-outline-success']) }} style="margin-left: 20px" title="Verify">
    <x-icons.pencil/>
</a>
