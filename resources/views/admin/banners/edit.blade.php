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
                <li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Data Banner</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.banner.update', ['banner' => $fetchData['data']['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Name')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" value="{{ $fetchData['data']['name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Order')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="order" type="number" min="1" value="{{ $fetchData['data']['order'] }}" required/>
                </div>                
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('URL')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="url" value="{{ $fetchData['data']['url'] }}"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Image')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" accept=".png, .jpg, .jpeg" name="image_file" type="file"/>
                    <small>Format: .jpg, .jpeg, .png. Ukuran Maksimum 2mb Ukuran gambar 1350x445</small>
                    <img class="mt-2 d-block img-fluid" src="{{ $fetchData['data']['image'] }}">
                    @error('image_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>                
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label class="form-check-label mb-0" :label="__('Status')" for="is_active"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" value="1" {{ $fetchData['data']['is_active'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_menu">Publish</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" value="0" {{ !$fetchData['data']['is_active'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_submenu">Unpublish</label>
                    </div>
                    @error('is_active')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update Banner')"/>
                    <x-buttons.cancel :href="route('admin.banner.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
