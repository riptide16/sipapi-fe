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
                <li class="breadcrumb-item active" aria-current="page">Show Halaman</li>
            </ol>
        </nav>
        <h2 class="h4">Show Data Halaman</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('Nama Halaman')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="$page['name']"/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('URL Slug')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="$page['slug']"/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('Status')"/>
            </div>
            <div class="col-12">
                <x-forms.label class="text-info" :label="$page['is_published'] ? 'Publish' : 'Unpublish'"/>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="col-12">
                <x-forms.label :label="__('Content')"/>
            </div>
            <div class="col-12">
                {!! $page['body'] !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <x-buttons.back :href="route('admin.content-website.page.index')"/>
            </div>
        </div>
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
            $('.summernote').summernote('disable');
        });
    </script>
@endpush
