@props(['title', 'href'])

@if (isset($href) && !empty($href))
<a href="{{ $href }}" class="btn btn-info font-weight-normal btn-flat">{{ $title }}</a>
@else
<button type="submit" class="btn btn-primary" {{ $attributes }}>
    {{ $title ?? __('Save') }}
</button>
@endif