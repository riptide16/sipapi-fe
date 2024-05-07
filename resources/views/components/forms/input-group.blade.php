<input {{ $attributes->merge(['class' => 'form-control', 'type' => 'text']) }} value="{{ old($attributes->get('name')) }}" placeholder="example@company.com" id="{{ $attributes->get('name') }}">
@error($attributes->get('name'))
    <span class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </span>
@enderror
