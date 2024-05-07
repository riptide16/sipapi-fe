@php
    $inputclass = preg_replace('/\[\]$/', '', $attributes->get('name'));
@endphp
<input id="{{ $inputclass }}"
    {{ $attributes->merge(['class' => 'form-control '.$inputclass, 'type' => 'text']) }} value="{{ old($attributes->get('name')) }}">
@error($attributes->get('name'))
    <span class="form-text text-danger">{{ $message }}</span>
@enderror
