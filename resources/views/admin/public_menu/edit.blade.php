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
                <li class="breadcrumb-item active" aria-current="page">Edit Menu</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Data Menu</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.content-website.public-menu.update', [$id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Nama Menu')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" value="{{ $menu['name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Nama Halaman')"/>
                </div>
                <div class="col-md-9">
                    @if($menu['is_default'])
                    <x-forms.select-page-slug :placeholder="__('Nama Halaman')" :fill="$menu['page_id']" name="page_id" disabled/>
                    @else
                    <x-forms.select-page-slug :placeholder="__('Nama Halaman')" :fill="$menu['page_id']" name="page_id" required />
                    @endif
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Tipe Menu')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="menu_type" id="type_menu" value="menu" {{ empty($menu['parent']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_menu">Menu</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="menu_type" id="type_submenu" value="submenu" {{ !empty($menu['parent']) ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_submenu">Submenu</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2 parent_select" style="{{ empty($menu['parent']) ? 'display:none' : '' }}">
                <div class="col-md-3">
                    <x-forms.label :label="__('Parent Menu')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-public-menu :placeholder="__('Parent Menu')" name="parent_id" :fill="!empty($menu['parent']) ? $menu['parent']['id'] : ''" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Sort Menu')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input type="number" min="1" name="order" value="{{ $menu['order'] }}" required />
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update Menu')"/>
                    <x-buttons.cancel :href="route('admin.content-website.public-menu.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@include('admin.public_menu.js-stack')
