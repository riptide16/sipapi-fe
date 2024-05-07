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
                    <a href="{{ route('admin.email-template.index') }}" class="text-info">
                        All Email Template
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Email Template</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Data Email Template</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.email-template.update', ['email_template' => $fetchData['data']['id']]) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Subject')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="subject" value="{{ $fetchData['data']['subject'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Action Button')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="action_button" value="{{ $fetchData['data']['action_button'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Body')"/>
                </div>
                <div class="col-md-9">
                    <textarea name="body" class="form-control" id="summernote" cols="30" rows="10">{{ $fetchData['data']['body'] }}</textarea>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Edit Email Template')"/>
                    <x-buttons.cancel :href="route('admin.email-template.index')"/>
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
            $('#summernote').summernote();
        });
    </script>
@endpush
