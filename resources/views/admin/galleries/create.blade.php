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
                    <a href="{{ route('admin.galeri.index') }}" class="text-info">
                        All Gallery
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Gallery</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Gallery</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Title')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="title" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Caption')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="caption" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Published Date')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="published_date" type="datetime-local" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Album')"/>
                </div>
                <div class="col-md-9">
                    <div class="col-md-9">
                        <input list="album" name="album" class="form-control" required>
                        <datalist id="album">
                            @foreach ($albums['data'] as $item)
                                <option value="{{ $item['name'] }}">
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Image')"/>
                </div>
                <div class="col-md-9">
                    {{-- <input class="form-control" accept=".png, .jpg, .jpeg" name="image_file" type="file" required/> --}}
                    <div class="input-images"></div>
                    @error('image_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tambahkan Pada Homepage')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_homepage" value="1">
                        <label class="form-check-label">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_homepage" value="0">
                        <label class="form-check-label">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Gallery')"/>
                    <x-buttons.cancel :href="route('admin.galeri.index')"/>
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
    $(function () {
        $('.input-images').imageUploader({
            extensions: ['.jpg', '.jpeg', '.png'],
            mimes: ['image/jpeg','image/png'],
            imagesInputName:'image_file',
            preloadedInputName:'preloaded',
            label:'Drag & Drop files here or click to browse'
        });
    })
</script>
@endpush
