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
                    <a href="{{ route('admin.instrumen.index') }}" class="text-info">
                        All Instrument
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Instrument</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Instrument</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.instrumen.store') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Name')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Kategori')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="category" required/>
                </div>
            @endif
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Order')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="order" required/>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Instrument')"/>
                    <x-buttons.cancel :href="route('admin.instrumen.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection