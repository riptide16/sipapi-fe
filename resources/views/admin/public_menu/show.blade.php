@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-icons.home/>
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.content-website.public-menu.index') }}" class="text-info">
                        All Menu
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Show Menu</li>
            </ol>
        </nav>
        <h2 class="h4">Show Data Menu</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('Nama Menu')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="$menu['name']"/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('URL Slug')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="$menu['url']"/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('Tipe Menu')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="!empty($menu['parent']) ? 'Submenu' : 'Menu'"/>
            </div>
        </div>
        <div class="form-group row mb-2 parent_select" style="{{ empty($menu['parent']) ? 'display:none' : '' }}">
            <div class="col-md-3">
                <x-forms.label :label="__('Parent Menu')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="!empty($menu['parent']) ? $menu['parent']['name'] : ''"/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('Sort Menu')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="$menu['order']"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <x-buttons.back :href="route('admin.content-website.public-menu.index')"/>
            </div>
        </div>
    </div>
</div>
@endsection

@include('admin.public_menu.js-stack')
@push('js')
    <script>
        $(function () {
            let menuType = "{{ $menu['parent'] ? 'submenu' : 'menu' }}";
            toggleParentSelect(menuType);
        });
    </script>
@endpush
