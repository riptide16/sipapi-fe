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
                    <a href="{{ route('admin.video.index') }}" class="text-info">
                        All Video
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Video</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Video</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.video.store') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Title')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="title" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Youtube Video ID')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="youtube_id" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Description')"/>
                </div>
                <div class="col-md-9">
                    <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
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
                    <x-buttons.save :title="__('Save Video')"/>
                    <x-buttons.cancel :href="route('admin.video.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
