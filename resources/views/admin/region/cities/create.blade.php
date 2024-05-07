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
                    <a href="{{ route('admin.master_data.index') }}" class="text-info">
                        Master Data
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Kota/Kabupaten</li>
            </ol>
        </nav>
        <h2 class="h4">Insert Kabupaten/Kota Name</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.master_data.cities.store') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Name')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Type Kabupaten atau Kota')"/>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <select name="type" class="custom-select form-control" required>
                                <option value="">--Pilih Type--</option>
                                <option value="Kabupaten">Kabupaten</option>
                                <option value="Kota">Kota</option>
                            </select>
                            @error('type')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Provinsi')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-province :placeholder="__('Provinsi')" :fill="__('')" name="province_id" required/>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Insert Kabupaten/Kota Name')"/>
                    <x-buttons.cancel :href="route('admin.master_data.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection