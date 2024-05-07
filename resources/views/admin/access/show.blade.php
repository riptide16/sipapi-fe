@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Access</li>
            </ol>
        </nav>
        <h2 class="h4">Show {{ $fetchData['data']['display_name'] }} Access</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form id="updateAccess" action="" method="POST">
            @csrf
            <div class="table-responsive">
                <table id="datatable-menus" class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">Permission</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fetchMenu['data'] as $menu)
                            <tr>
                                <td><label>{{ $menu['title'] }}</label></td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="table">
                                        @foreach($menu['permissions'] as $permission)
                                            @foreach ($fetchData['data']['permissions'] as $item)
                                                <tr>
                                                    <td>{{ $permission['key'] }}</td>
                                                    <td class="w-25">
                                                        <input type="checkbox" name="action[]" value="{{ $permission['id'] }}" {{ $item['id'] == $permission['id'] ? 'checked': '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div class="form-group row">
            <div class="col-md-12">
                <x-buttons.cancel :href="route('admin.access.index')"/>
            </div>
        </div>
    </div>
</div>
@endsection