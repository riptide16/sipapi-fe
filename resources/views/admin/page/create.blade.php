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
                    <a href="{{ route('admin.content-website.page.index') }}" class="text-info">
                        All Halaman
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Halaman</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Halaman</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.content-website.page.store') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Nama Halaman')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('URL Slug')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="slug" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Status')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_published" id="type_menu" value="1" checked>
                        <label class="form-check-label" for="type_menu">Publish</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_published" id="type_submenu" value="0">
                        <label class="form-check-label" for="type_submenu">Unpublish</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Content')"/>
                </div>
                <div class="col-md-9">
                    <textarea name="body" class="form-control summernote body" id="body" cols="30" rows="10" required>{{ old('body') }}</textarea>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Halaman')"/>
                    <x-buttons.cancel :href="route('admin.content-website.page.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
@endpush

@include('admin.page.js-stack')
