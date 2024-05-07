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
                    <a href="{{ route('admin.faq.index') }}" class="text-info">
                        All FAQ
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit FAQ</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Data FAQ</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.faq.update', ['faq' => $fetchData['data']['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Pertanyaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="title" value="{{ $fetchData['data']['title'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Jawaban')"/>
                </div>
                <div class="col-md-9">
                    <textarea name="content" class="form-control" id="summernote" cols="30" rows="10">{{ $fetchData['data']['content'] }}</textarea>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Edit FAQ')"/>
                    <x-buttons.cancel :href="route('admin.faq.index')"/>
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
