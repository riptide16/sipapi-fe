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
                    <a href="{{ route('admin.berita.index') }}" class="text-info">
                        All Berita
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Berita</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Data Berita</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.berita.update', ['beritum' => $news['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Title')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="title" value="{{ $news['title'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Publish Date')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="published_date" type="datetime-local" value="{{ $publishedDate }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Description')"/>
                </div>
                <div class="col-md-9">
                    <textarea name="body" class="form-control" id="summernote" cols="30" rows="10">{{ $news['body'] }}</textarea>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Image')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="image_file" type="file" accept=".jpg, .jpeg, .png" />
                    <small class="text-danger">*Orientasi foto landscape, ukuran foto disarankan 600x400</small>
                    <br>
                    <img src="{{ $news['image'] }}" width="200" height="200">
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Edit Berita')"/>
                    <x-buttons.cancel :href="route('admin.berita.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#summernote').summernote({
                height: 150
            });
        });
    </script>
@endpush
