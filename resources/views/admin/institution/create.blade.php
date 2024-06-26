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
                <li class="breadcrumb-item active" aria-current="page">Create Data Kelembagaan</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Kelembagaan</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        @if (session()->has('invalid_institution'))
            <div class="alert alert-danger">
                <p class="text-center" style="padding-top: 10px;">Pengajuan data kelembagaan Anda ditolak oleh admin. Silakan melengkapi kembali.</p>
            </div>
        @endif
        <form action="{{ route('admin.data_kelembagaan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-category-instrument name="category" :placeholder="__('Jenis Perpustakaan')" :fill="$data['category'] ?? ''" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="library_name" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('NPP')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="npp" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Lembaga Induk')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="agency_name"  required/>
                </div>
            </div>
            <div class="form-group row mb-2" id="typology" style="display:none">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tipologi Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="typology" id="typology_a" value="A" >
                        <label class="form-check-label" for="typology_a">A</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="typology" id="typology_b" value="B" >
                        <label class="form-check-label" for="typology_b">B</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="typology" id="typology_c" value="C" >
                        <label class="form-check-label" for="typology_c">C</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Wilayah')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-region name="region_id" :placeholder="__('Region')" :fill="$data['region']['id'] ?? ''" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Provinsi')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-province name="province_id" :placeholder="__('Provinsi')" :fill="$data['province']['id'] ?? ''" required disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kota')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-city name="city_id" :placeholder="__('Kota')" :fill="$data['city']['id'] ?? ''" required disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kecamatan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-subdistrict name="subdistrict_id" :placeholder="__('Kecamatan')" :fill="$data['subdistrict']['id'] ?? ''" required disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kelurahan/Desa')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-village name="village_id" :placeholder="__('Kelurahan/Desa')" :fill="$data['village']['id'] ?? ''" required disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Alamat')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="address" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Kepala Induk Lembaga')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="institution_head_name" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Email')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="email" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nomor Telepon')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="telephone_number" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nomor Ponsel')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="mobile_number" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Kepala Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="library_head_name" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Tenaga Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="library_worker_name[]" required/>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3">
                    <button type="button" class="btn btn-outline-primary add-field float-start" onclick="addWorker()">Tambah</button>
                    <button type="button" class="btn btn-outline-primary add-field float-start mx-2" onclick="removeWorker()">Hapus</button>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jumlah Koleksi Perpustakaan (Judul)')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="title_count" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Upload Surat Pernyataaan Penulisan Sertifikat')"/>
                </div>
                <div class="col-md-9">
                    <x-file-download-url class="d-block text-info" :filename="'Contoh Surat Pernyataan Penulisan Sertifikat'" target="_blank" />
                    <input type="file" name="registration_form_file" required /> <br>
                    <span>Maksimum ukuran file: 2 MB dan format file: .pdf, .jpg, .jpeg</span>
                    @error('registration_form')
                    <br><span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Predikat Terakhir')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-last-predicate :placeholder="__('Predikat Terakhir')" name="last_predicate" :fill="''" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tanggal Sertifikasi Terakhir')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="last_certification_date" type="date" />
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Data Kelembagaan')"/>
                    <x-buttons.cancel :href="route('admin.data_kelembagaan.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@include('admin.institution.js-stack')
