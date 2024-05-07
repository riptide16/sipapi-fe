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
                    <a href="{{ route('admin.file-download.index') }}" class="text-info">
                        All File Download
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">View File Download</li>
            </ol>
        </nav>
        <h2 class="h4">View File Download</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group row mb-2">
            <div class="col-md-3 required">
                <x-forms.label :label="__('File Name')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label name="filename" label="{{ $result['data']['filename'] }}"/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-3 required">
                <x-forms.label :label="__('Attachement')"/>
            </div>
            <div class="col-md-9">
                <a href="{{ $result['data']['attachment'] }}" target="_blank">Download</a>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-md-3 required">
                <x-forms.label :label="__('Status')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label name="filename" label="{{ $result['data']['is_published'] == 1 ? 'Publish' : 'Unpublish' }}"/>
            </div>
        </div>
        <div class="form-group row text-center">
            <div class="col-md-12">
                <x-buttons.cancel :href="route('admin.file-download.index')"/>
            </div>
        </div>
    </div>
</div>
@endsection
