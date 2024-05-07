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
                    <a href="{{ route('admin.kategori_instrumen.index') }}" class="text-info">
                        All Components
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Component</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Component</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.kategori_instrumen.store', ['type' => $type]) }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-category-instrument name="category" :placeholder="__('Jenis Perpustakaan')" :fill="__('')" required/>
                </div>
            </div>
            @if ($type == 'main')
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Nama Komponen')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.input name="name" required/>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Bobot')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.input type="number" name="weight" />
                    </div>
                </div>
            @elseif ($type == 'sub_1')
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Komponen')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.select class="main_id" name="parent_id" :items="[]" :placeholder="__('Komponen')" :fill="__('')" disabled required/>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Sub-Komponen Pertama')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.input name="name" required/>
                    </div>
                </div>
            @else
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Komponen')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.select class="main_id" :items="[]" :placeholder="__('Komponen')" :fill="__('')" disabled required/>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Sub-Komponen Pertama')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.select class="sub_1_id" :items="[]" name="parent_id" :placeholder="__('Sub-Komponen Pertama')" :fill="__('')" disabled required/>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Sub-Komponen Kedua')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.input name="name" required/>
                    </div>
                </div>
            @endif
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    {{-- <x-forms.label :label="__('Order')"/> --}}
                </div>
                <div class="col-md-9">
                    <input type="hidden" name="order" value="1">
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Component')"/>
                    <x-buttons.cancel :href="route('admin.kategori_instrumen.index', ['type' => $type])"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@include('admin.instrument.component.js-stack')
