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
                        All Instruments
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">View Instrument</li>
            </ol>
        </nav>
        <h2 class="h4">View Data Instrument</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        @if ($type == 'main')
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['category']"/>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Komponen :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['name']"/>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Bobot :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['weight']"/>
                </div>
            </div>
        @elseif ($type == 'sub_1')
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['parent']['category']"/>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Komponen :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['parent']['name']"/>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Sub-Pertama Komponen :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['name']"/>
                </div>
            </div>
        @else
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['parent']['parent']['category']"/>
                </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Komponen :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['parent']['parent']['name']"/>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Sub-Pertama Komponen :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['parent']['name']"/>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Sub-Kedua Komponen :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$instrument['name']"/>
                </div>
            </div>
        @endif
        <div class="form-group">
            <div class="col-md-12">
                <x-buttons.back :href="route('admin.kategori_instrumen.index', ['type' => $type])"/>
            </div>
        </div>
    </div>
</div>
@endsection
