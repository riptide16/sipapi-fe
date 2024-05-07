@props(['placeholder', 'fill', 'wilayah'])

<select id="{{ $attributes->get('name') }}"
    {{ $attributes->merge(['class' => 'custom-select form-control']) }} value="{{ $fill ?? old($attributes->get('name')) }}">
    <option value="" selected>--- {{ __('Choose') }} {{ __($placeholder) }} ---</option>
    @foreach ($asesors['data'] ?: [] as $item)
        <option value="{{ $item['id'] }}" {{ ( $item['id'] == $fill) ? 'selected=selected' : '' }}>{{ __($item['name']) }}</option>
        {{-- @empty --}}
    @endforeach
</select>
@error($attributes->get('name'))
    <span class="form-text text-danger">{{ $message }}</span>
@enderror
