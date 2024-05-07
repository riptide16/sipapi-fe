@props(['href'])

<a class="btn btn-success font-weight-normal btn-flat" href="{{ $href }}" {{ $attributes }}>
    <span class="fa fa-floppy-o"></span>
    {{ __('Next') }}
</a>