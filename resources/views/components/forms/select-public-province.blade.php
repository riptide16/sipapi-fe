@props(['placeholder', 'fill'])

<select id="{{ $attributes->get('name') }}"
    {{ $attributes->merge(['class' => 'custom-select form-control']) }} value="{{ $fill ?? old($attributes->get('name')) }}">
    <option value="" selected>--- {{ __('Pilih') }} {{ __($placeholder) }} ---</option>
    @foreach ($provinces ?: [] as $item)
        <option value="{{ $item['id'] }}" {{ ( $item['id'] == $fill) ? 'selected=selected' : '' }}>{{ __($item['name'] ?? $item['name']) }}</option>
    @endforeach
</select>
@error($attributes->get('name'))
    <span class="form-text text-danger">{{ $message }}</span>
@enderror

@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            font-size: 0.875rem;
            padding: 0.5rem 1rem 0.5rem 1rem;
            display: block;
            line-height: 1.5;
            height: 40px;
            width: 100%
        }
    </style>
@endpush


@push('js')
    <script>
        $(document).ready(function () {
            // $('#province_id').select2();
        })
    </script>
@endpush
