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
                    <a href="{{ route('admin.data_kelembagaan.index') }}" class="text-info">
                        Data Kelembagaan
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data Kelembagaan</li>
            </ol>
        </nav>
        <h2 class="h4">Update Data Kelembagaan</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        @if ($data['status'] == 'tidak_valid')
        <div class="alert alert-danger">
            <p class="text-center" style="padding-top: 10px;">Pengajuan data kelembagaan Anda ditolak oleh admin. Silakan melengkapi kembali.</p>
        </div>
        @endif
        <form id="institutionForm" action="{{ route('admin.data_kelembagaan.update', ['id' => $data['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="statusVerify" value="{{ $data['status'] }}">
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-category-instrument name="category" :placeholder="__('Jenis Perpustakaan')" :fill="$data['category']" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="library_name" value="{{ $data['library_name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('NPP')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="npp" value="{{ $data['npp'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Lembaga Induk')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="agency_name" value="{{ $data['agency_name'] }}"  required/>
                </div>
            </div>
            <div class="form-group row mb-2" id="typology" style="display:none">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tipologi Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="typology" id="typology_a" value="A" {{ $data['typology'] == 'A' ? 'checked' : '' }}>
                        <label class="form-check-label" for="typology_a">A</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="typology" id="typology_b" value="B" {{ $data['typology'] == 'B' ? 'checked' : '' }}>
                        <label class="form-check-label" for="typology_b">B</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="typology" id="typology_c" value="C" {{ $data['typology'] == 'C' ? 'checked' : '' }}>
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
                    <x-forms.select-province name="province_id" :regionId="$data['region']['id']" :placeholder="__('Provinsi')" :fill="$data['province']['id'] ?? ''" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kota')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-city name="city_id" :provinceId="$data['province']['id']" :placeholder="__('Kota')" :fill="$data['city']['id'] ?? ''" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kecamatan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-subdistrict name="subdistrict_id" :cityId="$data['city']['id']" :placeholder="__('Kecamatan')" :fill="$data['subdistrict']['id'] ?? ''" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kelurahan/Desa')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-village name="village_id" :subdistrictId="$data['subdistrict']['id']" :placeholder="__('Kelurahan/Desa')" :fill="$data['village']['id'] ?? ''" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Alamat')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="address" value="{{ $data['address'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Kepala Induk Lembaga')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="institution_head_name" value="{{ $data['institution_head_name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Email')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="email" value="{{ $data['email'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nomor Telepon')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="telephone_number" value="{{ $data['telephone_number'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nomor Ponsel')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="mobile_number" value="{{ $data['mobile_number'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Kepala Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="library_head_name" value="{{ $data['library_head_name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Tenaga Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    @forelse ($data['library_worker_name'] as $worker)
                        <x-forms.input name="library_worker_name[]" value="{{ $worker }}" required />
                    @empty
                        <x-forms.input name="library_worker_name[]" value="" required />
                    @endforelse
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
                    <x-forms.input name="title_count" value="{{ $data['title_count'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Upload Surat Perubahan Data')"/>
                </div>
                <div class="col-md-9">
                    <x-file-download-url class="d-block text-info" :filename="'Contoh Surat Perubahan Data'" target="_blank" />
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
                    <x-forms.select-last-predicate :placeholder="__('Predikat Terakhir')" name="last_predicate" :fill="$data['last_predicate']" />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tanggal Sertifikasi Terakhir')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="last_certification_date" type="date" value="{{ $data['last_certification_date'] }}" />
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update Data Kelembagaan')"/>
                    <x-buttons.cancel :href="route('admin.data_kelembagaan.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@include('admin.institution.js-stack')
