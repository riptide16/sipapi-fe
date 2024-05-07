<div class="form-group row">
    @if (array_key_exists('create', $actions))
        <div class="col-sm-2">
            @if(isset($targetRoute))
            <x-buttons.icon-edit class="btn-sm" href="{{ url($targetRoute) }}"/>
            @else
            <x-buttons.icon-edit class="btn-sm" href="{{ route($route.'.create', [$model => $id]) }}"/>
            @endif
        </div>
    @endif
    @if (array_key_exists('show', $actions))
        <div class="col-sm-2">
            @if(isset($sub_model))
            <x-buttons.icon-view class="btn-sm" href="{{ route($route.'.show', [$sub_model => $sub_id, $model => $id]) }}"/>
            @else
                <x-buttons.icon-view class="btn-sm" href="{{ route($route.'.show', [$model => $id, 'status' => $status ?? null]) }}"/>
            @endif
        </div>
    @endif
    @if (array_key_exists('edit', $actions) && $actions['edit'])
        <div class="col-sm-2">
            @if(isset($sub_model))
            <x-buttons.icon-edit class="btn-sm" href="{{ route($route.'.edit', [$sub_model => $sub_id, $model => $id]) }}"/>
            @else
                @php
                    $querystr = [$model => $id];
                    if (isset($args)) {
                        $querystr = array_merge($querystr, $args);
                    }
                @endphp
            <x-buttons.icon-edit class="btn-sm" href="{{ route($route.'.edit', $querystr) }}"/>
            @endif
        </div>
    @endif
    @if (array_key_exists('delete', $actions) && $actions['delete'])
        <div class="col-sm-2">
            @if(isset($sub_model))
            <x-buttons.icon-delete class="btn-sm swal-delete" data-url="{{ route($route.'.destroy', [$sub_model => $sub_id, $model => $id]) }}"/>
            @else
            <x-buttons.icon-delete class="btn-sm swal-delete" data-url="{{ route($route.'.destroy', [$model => $id]) }}"/>
            @endif
        </div>
    @endif
</div>
