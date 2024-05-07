@props(['href'])

<a class="btn btn-info font-weight-normal btn-flat" href="{{ $href }}" {{ $attributes }}>
    <span class="fa fa-floppy-o"></span>
    {{ __('Prev') }}
</a>