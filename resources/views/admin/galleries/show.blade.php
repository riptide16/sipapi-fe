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
                <li class="breadcrumb-item active" aria-current="page">Show Gallery</li>
            </ol>
        </nav>
        <h2 class="h4">Show Data Gallery</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.galeri.update', ['galeri' => $fetchData['data']['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group row mb-2">
                <div class="col-md-3 disabled">
                    <x-forms.label :label="__('Title')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="title" value="{{ $fetchData['data']['title'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 disabled">
                    <x-forms.label :label="__('Caption')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="caption" value="{{ $fetchData['data']['caption'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 disabled">
                    <x-forms.label :label="__('Album')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="album" value="{{ $fetchData['data']['album']['name'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 disabled">
                    <x-forms.label :label="__('Published Date')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="published_date" value="{{ date('d/m/Y H:i:s', strtotime($fetchData['data']['published_date'])) }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Homepage')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_homepage" value="1" {{ $fetchData['data']['is_homepage'] == 1 ? 'checked' : '' }} disabled>
                        <label class="form-check-label">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_homepage" value="0" {{ $fetchData['data']['is_homepage'] == 0 ? 'checked' : '' }} disabled>
                        <label class="form-check-label">Tidak</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Image')"/>
                </div>
                <div class="col-md-9">
                    <img src="{{ $fetchData['data']['image'] }}" width="100%">
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.cancel :href="route('admin.galeri.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
