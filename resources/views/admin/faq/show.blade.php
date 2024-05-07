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
                <li class="breadcrumb-item active" aria-current="page">Show FAQ</li>
            </ol>
        </nav>
        <h2 class="h4">Show Data FAQ</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.faq.update', ['faq' => $fetchData['data']['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Pertanyaan :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$fetchData['data']['title']"/>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jawaban :')"/>
                </div>
                <div class="col-md-9">
                    {!! $fetchData['data']['content'] !!}
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.cancel :href="route('admin.faq.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

