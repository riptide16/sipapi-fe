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
                    <a href="{{ route('admin.penilaian.index') }}" class="text-info">
                        All Penilaian
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.penilaian.show', [$id]) }}" class="text-info">
                        View Penilaian
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Data Kelembagaan Detail</li>
            </ol>
        </nav>
        <h2 class="h4">Data Kelembagaan - {{ $fetchDataInstitution['data']['library_name'] }}</h2>
    </div>
    @if (\Helper::isAsesi() && !empty($fetchDataInstitution['data']['validated_at']))
        @if ($fetchDataInstitution['data']['status'] != 'menunggu_verifikasi')
            <div class="btn-toolbar mb-2 mb-md-0">
                <x-buttons.update :href="route('admin.data_kelembagaan.edit', ['id' => $fetchDataInstitution['data']['id']])" :title="__('Data Kelembagaan')" />
            </div>
        @endif
    @endif
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                @if (\Helper::isAsesi())
                    <tr>
                        <td><strong>Status</strong></td>
                        @if ($fetchDataInstitution['data']['status'] == 'valid')
                            <td><span class="lembaga-status valid">Valid</span></td>
                        @elseif($fetchDataInstitution['data']['status'] == 'tidak_valid')
                            <td><span class="lembaga-status tidak_valid">Belum Lengkap</span></td>
                        @else
                            <td><span class="lembaga-status request">Request</span></td>
                        @endif
                    </tr>
                @endif
                <tr>
                    <td><strong>Jenis Perpustakaan</strong></td>
                    <td>{{ $fetchDataInstitution['data']['category'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Wilayah</strong></td>
                    <td>{{ isset($fetchDataInstitution['data']['region']) ? $fetchDataInstitution['data']['region']['name'] : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Perpustakaan</strong></td>
                    <td>{{ $fetchDataInstitution['data']['library_name'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>NPP</strong></td>
                    <td>{{ $fetchDataInstitution['data']['npp'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Lembaga Induk</strong></td>
                    <td>{{ $fetchDataInstitution['data']['agency_name'] ?? '-' }}</td>
                </tr>
                @if($fetchDataInstitution['data']['category'] == 'Provinsi' || $fetchDataInstitution['data']['category'] == 'Kota')
                <tr>
                    <td><strong>Tipologi Perpustakaan</strong></td>
                    <td>{{ $fetchDataInstitution['data']['typology'] ?? '-' }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Provinsi</strong></td>
                    <td>{{ isset($fetchDataInstitution['data']['province']) ? $fetchDataInstitution['data']['province']['name'] : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Kabupaten/Kota</strong></td>
                    <td>{{ isset($fetchDataInstitution['data']['city']) ? $fetchDataInstitution['data']['city']['type'] == 'Kabupaten' ? 'Kab. '.$fetchDataInstitution['data']['city']['name'] : 'Kota '.$fetchDataInstitution['data']['city']['name'] : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Kecamatan</strong></td>
                    <td>{{ isset($fetchDataInstitution['data']['subdistrict']) ? $fetchDataInstitution['data']['subdistrict']['name'] : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Kelurahan/Desa</strong></td>
                    <td>{{ isset($fetchDataInstitution['data']['village']) ? $fetchDataInstitution['data']['village']['name'] : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>{{ $fetchDataInstitution['data']['address'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Kepala Induk Lembaga</strong></td>
                    <td>{{ $fetchDataInstitution['data']['institution_head_name'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>{{ $fetchDataInstitution['data']['email'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor Telepon</strong></td>
                    <td>{{ $fetchDataInstitution['data']['telephone_number'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor Ponsel</strong></td>
                    <td>{{ $fetchDataInstitution['data']['mobile_number'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Kepala Perpustakaan</strong></td>
                    <td>{{ $fetchDataInstitution['data']['library_head_name'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Tenaga Perpustakaan</strong></td>
                    @if (!empty($fetchDataInstitution['data']['library_worker_name']))
                        <td>
                            {{ implode(', ', $fetchDataInstitution['data']['library_worker_name']) }}
                        </td>
                    @else
                        <td>-</td>
                    @endif
                </tr>
                <tr>
                    <td><strong>Jumlah Koleksi Perpustakaan (Judul)</strong></td>
                    <td>{{ $fetchDataInstitution['data']['title_count'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Predikat Terakhir</strong></td>
                    <td>{{ $fetchDataInstitution['data']['last_predicate'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Sertifikasi Terakhir</strong></td>
                    <td>{{ $fetchDataInstitution['data']['last_certification_date'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Surat Pendaftaran Asesi</strong></td>
                    <td>
                        @if (!empty($fetchDataInstitution['data']['registration_form_file']))
                            <a class="btn btn-info" href="{{ $fetchDataInstitution['data']['registration_form_file'] }}">Link Download Surat Pendaftaran</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @if (isset($fetchDataInstitution['data']['update_form_file']))
                    <tr>
                        <td><strong>Surat Perubahan Data</strong></td>
                        <td>
                            @forelse ($fetchDataInstitution['data']['update_form_file'] as $updateFile)
                                <a class="btn btn-info" href="{{ $updateFile }}">Link Download Surat Perubahan Data</a>
                            @empty
                                -
                            @endif
                        </td>
                    </tr>
                @endif
                @if (isset($fetchDataInstitution['data']['user']['name']))
                    <tr>
                        <td><strong>Nama Asesi</strong></td>
                        <td>{{ $fetchDataInstitution['data']['user']['name'] ?? '-' }}</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="col-md-12 mt-3">
            @if(session()->get('user.data.role.name') != 'asesi')
            <x-buttons.back :href="route('admin.penilaian.show',[$id])"/>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
