@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sertifikasi</li>
            </ol>
        </nav>
        <h2 class="h4">Data Sertifikasi</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">No</th>
                        <th class="border-0">Kode Pengajuan</th>
                        <th class="border-0">Lembaga Induk</th>
                        <th class="border-0">Nama Perpustakaan</th>
                        <!-- <th class="border-0">Tanggal Pengajuan</th> -->
                        <!-- <th class="border-0">Tanggal Penilaian</th> -->
                        <th class="border-0">Tanggal Rapat Sidang Pleno</th>
                        <!-- <th class="border-0">Nilai</th> -->
                        <th class="border-0">Hasil Rapat</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">Tanggal Kirim</th>
                        <th class="border-0">Sertifikat</th>
                        <th class="border-0">Rekomendasi</th>
                        @if (!\Helper::isProvince())
                        <th class="border-0">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @if (!empty($fetchData['data']))
                        @forelse ($fetchData['data'] as $data)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $data['code'] }}</td>
                                <td>{{ $data['institution']['agency_name'] ?? '-' }}</td>
                                <td>{{ $data['institution']['library_name'] ?? '-' }}</td>
                                <!-- <td>{{ \Helper::formatDate($data['created_at'], 'd F Y') }}</td> -->
                                <!-- <td>{{ \Helper::formatDate($data['evaluation']['created_at'], 'd F Y') }}</td> -->
                                <td>{{ \Helper::formatDate($data['meeting_date'], 'd F Y') }}</td>
                                <!-- <td>{{ $data['evaluation']['final_result']['total_value'] }}</td> -->
                                <td>{{ $data['predicate'] }}</td>
                                <td>{{ \Helper::titlize($data['certificate_status']) }}</td>
                                <td>{{ \Helper::formatDate($data['certificate_sent_at'], 'd F Y') }}</td>
                                <td>
                                    @if (!empty($data['certificate_file']))
                                        <a class="btn btn-info" href="{{ $data['certificate_file'] }}"><i class="fa fa-download" aria-hidden="true"></i> Unduh Sertifikat</a>
                                    @else
                                        <p>Belum Di-upload</p>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($data['recommendation_file']))
                                        <a class="btn btn-info" href="{{ $data['recommendation_file'] }}"><i class="fa fa-download" aria-hidden="true"></i> Unduh Rekomendasi</a>
                                    @else
                                        <p>Belum Di-upload</p>
                                    @endif
                                </td>
                                @if (!\Helper::isAsesi() && !\Helper::isProvince())
                                <td>
                                    <x-accreditation-actions />
                                    @include('components.general-actions-resource', [
                                        'route' => 'admin.sertifikasi',
                                        'id' => $data['id'],
                                        'model' => 'sertifikasi',
                                        'actions' => [
                                            'edit' => true,
                                        ]
                                    ])
                                </td>
                                @endif
                            </tr>
                            @php $i++; @endphp
                        @empty
                            <tr>
                                <td colspan="5">No Have Match Data in Table</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/data-table.js') }}"></script>
@endpush
