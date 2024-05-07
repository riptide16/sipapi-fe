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
                    <a href="{{ route('admin.banner.index') }}" class="text-info">
                        All Banner
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Show Banner</li>
            </ol>
        </nav>
        <h2 class="h4">Show Data Banner</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group row mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Name')"/>
            </div>
            <div class="col-md-9">
                <x-forms.input name="name" value="{{ $fetchData['data']['name'] }}" disabled/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Order')"/>
            </div>
            <div class="col-md-9">
                <x-forms.input name="order" value="{{ $fetchData['data']['order'] }}" type="number" min="1" disabled/>
            </div>                
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('URL')"/>
            </div>
            <div class="col-md-9">
                <x-forms.input name="url" value="{{ $fetchData['data']['url'] }}" disabled/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Image')"/>
            </div>
            <div class="col-md-9">
                <img src="{{ $fetchData['data']['image'] }}">
            </div>                
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-3">
                <x-forms.label class="form-check-label mb-0" :label="__('Status')" for="is_active"/>
            </div>
            <div class="col-md-9">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" value="1" {{ $fetchData['data']['is_active'] ? 'checked' : '' }} disabled>
                    <label class="form-check-label" for="type_menu">Publish</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" value="0" {{ !$fetchData['data']['is_active'] ? 'checked' : '' }} disabled>
                    <label class="form-check-label" for="type_submenu">Unpublish</label>
                </div>
            </div>
        </div>
        <div class="form-group row text-center">
            <div class="col-md-12">
                <x-buttons.cancel :href="route('admin.banner.index')"/>
            </div>
        </div>
    </div>
</div>
@endsection
