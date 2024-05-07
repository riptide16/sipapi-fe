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
                <li class="breadcrumb-item active" aria-current="page">Edit File Download</li>
            </ol>
        </nav>
        <h2 class="h4">Edit File Download</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.file-download.update', ['file_download' => $result['data']['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('File Name')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="filename" value="{{ $result['data']['filename'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Attachement')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" accept=".pdf, .jpg, .jpeg, .png" name="attachment_file" type="file"/>
                    @error('attachment_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Status')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check mb-2 form-switch">
                        <x-forms.label class="form-check-label mb-0" :label="__('Publish')" for="is_publish"/>
                        <input class="form-check-input" name="is_publish" type="checkbox" id="is_publish" value="1" @if($result['data']['is_published'] == 1) checked @endif>
                        @error('is_publish')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update File Download')"/>
                    <x-buttons.cancel :href="route('admin.file-download.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
