@props(['href', 'title'])

@if(isset($href))
<a class="btn btn-outline-warning font-weight-normal btn-flat" href="{{ $href }}" {{ $attributes }}>
    <span class="fa fa-floppy-o"></span>
    {{ $title ?? __('Cancel') }}
</a>
@else
<button type="button" wire:click="clearField" class="btn font-weight-normal btn-outline-secondary btn-flat" data-dismiss="modal">
    {{ __('Cancel') }}
</button>
@endif
