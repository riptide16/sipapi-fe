@props(['placeholder', 'fill'])

<select id="{{ $attributes->get('name') }}"
    {{ $attributes->merge(['class' => 'custom-select form-control']) }} value="{{ $fill ?? old($attributes->get('name')) }}">
    <option value="" selected>--- {{ __('Pilih') }} {{ __($placeholder) }} ---</option>
    @foreach ($statuses ?: [] as $item)
        <option value="{{ $item['id'] }}" {{ ( $item['id'] == $fill) ? 'selected=selected' : '' }}>{{ __($item['display_name'] ?? $item['name']) }}</option>
        {{-- @empty --}}
    @endforeach
</select>
@error($attributes->get('name'))
    <span class="form-text text-danger">{{ $message }}</span>
@enderror
