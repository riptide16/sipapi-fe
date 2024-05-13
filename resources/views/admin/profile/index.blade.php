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
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Profile</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Name')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" value="{{ $user['name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('E-mail')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="email" value="{{ $user['email'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Username')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="username" value="{{ $user['username'] }}" disabled/>
                </div>
            </div>
            @if (!\Helper::isAsesi() && !\Helper::isAsesor())
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Wilayah')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.select-region name="region_id" :placeholder="__('Wilayah')" :fill="$user['region']['id'] ?? __('')" required/>
                    </div>
                </div>
                @if (\Helper::isProvince())
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Provinsi Asal')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.select-province name="province_id" :placeholder="__('Provinsi')" :fill="$user['province']['id'] ?? __('')" required/>
                    </div>
                </div>
                @endif
            @endif
            @if (\Helper::isAsesor())
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Instansi Asal')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.input name="institution_name" value="{{ $user['institution_name'] ?? '' }}" />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Provinsi Asal')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.select-province name="province_id" :placeholder="__('Provinsi')" :fill="$user['province']['id'] ?? __('')" required/>
                    </div>
                </div>
            @endif
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Photo')"/>
                </div>
                <div class="col-md-9">
                    <div class="input-images">
                        Drag and Drop
                    </div>
                    {{-- <input class="form-control" accept=".png, .jpg, .jpeg" name="photo_upload" id="photo_upload" type="file"/> --}}
                    @if ($user['profile_picture'])
                        <img src="{{ $user['profile_picture'].'?stream' }}" width="200" height="200" alt="">
                    @endif
                    @error('photo_upload')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>                
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Password')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input type="password" name="password" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Password Confirmation')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input type="password" name="password_confirmation" />
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update Profile')"/>
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
            imagesInputName:'photo_upload',
            preloadedInputName:'preloaded',
            label:'Drag & Drop files here or click to browse'
        });
    })
</script>
@endpush
