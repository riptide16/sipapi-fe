@props(['item'])
@php
    $inputclass = preg_replace('/\[\]$/', '', $attributes->get('name'));
@endphp
<textarea id="{{ $inputclass }}"
    {{ $attributes->merge(['class' => 'form-control min-h-75px '. $inputclass, 'row' => 3]) }}>
    {{ $item ?? '' }}
    </textarea>
@error($inputclass)
    <span class="form-text text-danger">{{ $message }}</span>
@enderror
