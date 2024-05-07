@props(['href'])

<a class="btn btn-outline-warning font-weight-normal btn-flat" href="{{ $href }}" {{ $attributes }}>
    <span class="fa fa-floppy-o"></span>
    {{ __('Back') }}
</a>