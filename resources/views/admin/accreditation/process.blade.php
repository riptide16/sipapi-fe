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
                    <a href="{{ route('admin.akreditasi.index') }}" class="text-info">
                        All Akreditasi
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Proses Akreditasi</li>
            </ol>
        </nav>
        <h2 class="h4">Proses Data Akreditasi</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.akreditasi.process.post', [$fetchData['id']]) }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kode Pengajuan')"/>
                </div>
                <div class="col-md-9">
                    <input value="{{ $fetchData['code'] }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <input value="{{ $fetchData['institution']['library_name'] }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tanggal Ajuan')"/>
                </div>
                <div class="col-md-9">
                    <input value="{{ \Helper::formatDate($fetchData['created_at'], 'd F Y') }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <input value="{{ $fetchData['institution']['category'] ?? '-' }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Instansi')"/>
                </div>
                <div class="col-md-9">
                    <input value="{{ $fetchData['institution']['agency_name'] ?? '-' }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nilai Asesor')"/>
                </div>
                <div class="col-md-9">
                    <input value="{{ isset($fetchData['evaluation']['final_result']['score']) ? round($fetchData['evaluation']['final_result']['score'], 2) : '-' }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nilai Asesi')"/>
                </div>
                <div class="col-md-9">
                    <input value="{{ isset($fetchData['finalResult']['score']) ? round($fetchData['finalResult']['score'], 2) : '-' }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Tanggal Rapat')"/>
                </div>
                <div class="col-md-9">
                    <input type="date" name="meeting_date" value="{{ $fetchData['meeting_date'] ?? '' }}" required />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Hasil Rapat')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="predicate" id="predicate_1" value="A" >
                        <label class="form-check-label" for="predicate_1">A</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="predicate" id="predicate_2" value="B" >
                        <label class="form-check-label" for="predicate_2">B</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="predicate" id="predicate_3" value="C" >
                        <label class="form-check-label" for="predicate_3">C</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="predicate" id="predicate_4" value="Tidak Akreditasi" >
                        <label class="form-check-label" for="predicate_4">Tidak Akreditasi</label>
                    </div>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Simpan')"/>
                    <x-buttons.cancel :href="route('admin.akreditasi.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
