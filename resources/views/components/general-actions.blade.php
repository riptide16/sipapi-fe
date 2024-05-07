@php
    $param = $param ?? [];
@endphp
<div class="form-group row">
    @if (array_key_exists('show', $actions))
        @if (array_key_exists('type', $actions))
            <div class="col-sm-2">
                @if(isset($url))
                <x-buttons.icon-view class="btn-sm" href="{{ url($url . '/' . $id . '/' . $type) }}"/>
                @else
                <x-buttons.icon-view class="btn-sm" href="{{ route($route.'.show', array_merge(['id' => $id, 'type' => $type], $param)) }}"/>
                @endif
            </div>
        @else
            <div class="col-sm-2">
                @if(isset($url))
                <x-buttons.icon-view class="btn-sm" href="{{ url($url . '/' . $id) }}"/>
                @else
                <x-buttons.icon-view class="btn-sm" href="{{ route($route.'.show', array_merge(['id' => $id], $param)) }}"/>
                @endif
            </div>
        @endif
    @endif
    @if (array_key_exists('edit', $actions))
        @if (array_key_exists('type', $actions))
            <div class="col-sm-2">
                @if(isset($url))
                <x-buttons.icon-edit class="btn-sm" href="{{ url($url. '/edit/' . $id . '/' . $type) }}"/>
                @else
                <x-buttons.icon-edit class="btn-sm" href="{{ route($route.'.edit', array_merge(['id' => $id, 'type' => $type], $param)) }}"/>
                @endif
            </div>
        @else
            <div class="col-sm-2">
                @if(isset($url))
                <x-buttons.icon-edit class="btn-sm" href="{{ url($url . '/edit/' .$id) }}"/>
                @else
                <x-buttons.icon-edit class="btn-sm" href="{{ route($route.'.edit', array_merge(['id' => $id], $param)) }}"/>
                @endif
            </div>
        @endif
    @endif
    @if (array_key_exists('delete', $actions))
        <div class="col-sm-2">
            @if(isset($url))
            <x-buttons.icon-delete class="btn-sm swal-delete" data-url="{{ url($url . '/delete/' . $id) }}"/>
            @else
            <x-buttons.icon-delete class="btn-sm swal-delete" data-url="{{ route($route.'.delete', array_merge(['id' => $id], $param)) }}"/>
            @endif
        </div>
    @endif
    @if (array_key_exists('verify', $actions) && $actions['verify'])
        <div class="col-sm-2">
            @if(isset($url))
            <x-buttons.icon-verify class="btn-sm" href="{{ url($url . '/verify/' . $id) }}"/>
            @else
            <x-buttons.icon-verify class="btn-sm" href="{{ route($route.'.verify', array_merge(['id' => $id], $param)) }}"/>
            @endif
        </div>
    @endif
</div>
