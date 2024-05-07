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
                    <a href="{{ route('admin.testimoni.index') }}" class="text-info">
                        All Testimony
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Testimony</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Data Testimony</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.testimoni.update', ['testimoni' => $fetchData['data']['id']]) }}" method="POST" enctype="multipart/form-data">
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
                    <x-forms.label :label="__('Content')"/>
                </div>
                <div class="col-md-9">
                    <textarea name="content" class="form-control" cols="20" rows="5">{{ $fetchData['data']['content'] }}</textarea>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Photo')"/>
                </div>
                <div class="col-md-9">
                    <div class="input-images"></div>
                    <img class="img-fluid" src="{{ $fetchData['data']['photo'] }}" alt="">
                    @error('photo_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>                
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Edit Testimony')"/>
                    <x-buttons.cancel :href="route('admin.testimoni.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/drag-drop-image-uploader/dist/image-uploader.min.css') }}" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('vendor/drag-drop-image-uploader/dist/image-uploader.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.input-images').imageUploader({
                extensions: ['.jpg', '.jpeg', '.png'],
                mimes: ['image/jpeg','image/png'],
                imagesInputName:'photo_file',
                preloadedInputName:'preloaded',
                label:'Drag & Drop files here or click to browse'
            });
        });
    </script>
@endpush
