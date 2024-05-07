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
                    <a href="{{ route('admin.sertifikasi.index') }}" class="text-info">
                        Data Sertifikasi
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data Sertifikasi</li>
            </ol>
        </nav>
        <h2 class="h4">Update Data Sertifikasi</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form id="institutionForm" action="{{ route('admin.sertifikasi.update', ['sertifikasi' => $data['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kode Pengajuan')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" value="{{ $data['code'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Lembaga Induk')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" value="{{ $data['institution']['agency_name'] ?? '-' }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" value="{{ $data['institution']['library_name'] ?? '-' }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tanggal Pengajuan')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" value="{{ \Helper::formatDate($data['created_at'], 'd F Y') }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tanggal Penilaian')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" value="{{ \Helper::formatDate($data['evaluation']['created_at'], 'd F Y') }}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Hasil Akreditasi')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" value="{{ $data['predicate'] ?? '-'}}" disabled />
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Status')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-certificate-status name="certificate_status" :placeholder="__('Status')" :fill="$data['certificate_status'] ?? ''" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('File Sertifikat')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" accept=".pdf" name="certificate_file" id="certificate_file" type="file"/>           
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('File Rekomendasi Akreditasi')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" accept=".pdf" name="recommendation_file" id="recommendation_file" type="file"/>
             
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    @if (!empty($data['certificate_file']))
                        <a class="btn btn-info col-2 mt-3" href="{{ $data['certificate_file'] }}">Download File Sertifikat</a>
                    @endif
                    @if (!empty($data['recommendation_file']))
                        <a class="btn btn-info col-4 mt-3" href="{{ $data['recommendation_file'] }}">Download File Rekomendasi Akreditasi</a>
                    @endif
                </div>
            </div>
            <div class="form-group row mb-2" id="tglkirim">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tanggal Kirim')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="certificate_sent_at" type="date" value="{{ $data['certificate_sent_at'] }}" />
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update Data Sertifikasi')"/>
                    <x-buttons.cancel :href="route('admin.sertifikasi.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(function () {
            toggleCertificateSent($('#certificate_status').val());

            $('#certificate_status').change(function () {
                toggleCertificateSent($(this).val());
            });
        });

        function toggleCertificateSent(value) {
            if (value == 'dikirim') {
                $('#tglkirim').show();
                $('#certificate_sent_at').prop('required', true);
            } else {
                $('#tglkirim').hide();
                $('#certificate_sent_at').prop('required', false);
            }
        }
    </script>
@endpush
