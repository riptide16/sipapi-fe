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
                <li class="breadcrumb-item active" aria-current="page">Kelembagaan</li>
            </ol>
        </nav>
        <h2 class="h4">Data Kelembagaan</h2>
    </div>
    
</div>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: none;">
        <a class="nav-link {{ $dataFilter['datatype'] == 'request' ? 'active' : '' }}" href="{{ route('admin.data_kelembagaan.index', ['datatype' => 'request']) }}" id="nav-home-tab">Request</a>
        <a class="nav-link {{ $dataFilter['datatype'] == 'valid' ? 'active' : '' }}" href="{{ route('admin.data_kelembagaan.index', ['datatype' => 'valid']) }}" id="nav-home-tab">Data Valid</a>
    </div>
</nav>
<div class="card border-0 shadow mb-4">
    <div class="card-body mb-2">
        <div class="mb-4" id="collapseFilter">
            <div class="card card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <x-forms.label :label="__('Jenis Kelembagaan')"/>
                    </div>
                    <div class="col-md-4">
                        <x-forms.label :label="__('Status')"/>
                    </div>
                    <div class="col-md-4">
                        <x-forms.label :label="__('Tanggal Request')"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <select name="category" class="form-control" id="category-filter">
                            <option value="">--- Pilih Jenis Kelembagaan ---</option>
                            <option value='Perpustakaan Desa' @if(isset($dataFilter['category']) && $dataFilter['category'] == 'Perpustakaan Desa') selected @endif>Perpustakaan Desa</option>
                            <option value="Kecamatan" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'Kecamatan') selected @endif>Kecamatan</option>
                            <option value="Kabupaten Kota" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'Kabupaten Kota') selected @endif>Kabupaten Kota</option>
                            <option value="Provinsi" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'Provinsi') selected @endif>Provinsi</option>
                            <option value="SD MI" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'SD MI') selected @endif>SD MI</option>
                            <option value="SMP MTs" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'SMP MTs') selected @endif>SMP MTs</option>
                            <option value="SMA SMK MA" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'SMA SMK MA') selected @endif>SMA SMK MA</option>
                            <option value="Perguruan Tinggi" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'Perguruan Tinggi') selected @endif>Perguruan Tinggi</option>
                            <option value="Khusus" @if(isset($dataFilter['category']) && $dataFilter['category'] == 'Khusus') selected @endif>Khusus</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="status" id="status-filter" class="form-control">
                            <option value="">--- Pilih Status ---</option>
                            <option value="valid" @if(isset($dataFilter['status']) && $dataFilter['status'] == 'valid') selected @endif>Valid</option>
                            <option value="tidak_valid" @if(isset($dataFilter['status']) && $dataFilter['status'] == 'tidak_valid') selected @endif>Tidak Valid</option>
                            <option value="menunggu_verifikasi" @if(isset($dataFilter['status']) && $dataFilter['status'] == 'menunggu_verifikasi') selected @endif>Menunggu Verifikasi</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type='date' class="form-control" id="created_at" name="created_at" @if(isset($dataFilter['created_at'])) value="{{ $dataFilter['created_at'] }}" @endif>
                    </div>
                </div>
            </div>
        </div>  
        <div class="table-responsive">
            <table id="datatable" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">No</th>
                        <th class="border-0">Lembaga Induk</th>
                        <th class="border-0">Nama Perpustakaan</th>
                        <th class="border-0">Jenis Perpustakaan</th>
                        <th class="border-0">Wilayah</th>
                        <th class="border-0">Provinsi</th>
                        <th class="border-0">Kab./Kota</th>
                        @if ($dataFilter['datatype'] == 'request')
                            <th class="border-0">Nama Asesi</th>
                        @endif
                        <th class="border-0">Tanggal Request</th>
                        <th class="border-0">Status</th>
                        <th class="border-0" style="width: 300px !important">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @forelse ($fetchDataInstitution['data'] as $data)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $data['agency_name'] }}</td>
                            <td>{{ $data['library_name'] }}</td>
                            <td>{{ $data['category'] }}</td>
                            <td>{{ $data['region']['name'] }}</td>
                            <td>{{ $data['province']['name'] }}</td>
                            <td>{{ $data['city']['type'] }} {{ $data['city']['name'] }}</td>
                            @if ($dataFilter['datatype'] == 'request')
                                <td>{{ isset($data['user']) ? $data['user']['name'] : '-' }}</td>
                            @endif
                            <td>{{ \Helper::formatDate($data['created_at'], 'd/m/Y H:i:s') }}</td>
                            <td>{{ \Helper::titlize($data['status']) }}</td>
                            <td>
                                @include('components.general-actions', [
                                    'route' => 'admin.data_kelembagaan',
                                    'param' => ['datatype' => $dataFilter['datatype']],
                                    'id' => $data['id'],
                                    'actions' => [
                                        'show' => true,
                                        'verify' => $dataFilter['datatype'] == 'request',
                                    ]
                                ])
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @empty
                        <tr>
                            <td colspan="8">No Have Match Data in Table</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/data-table.js') }}"></script>
    <script>
        function getDataFilter(param, val)
        {
            let url = new URL(window.location.href)
            let searchParams = new URLSearchParams(url.search)
            if(url.search.length === 0){
                return window.location.href = "?"+param+"="+val+"#rowtable"
            }

            searchParams.forEach(function(value, key) {
                if( key == param ){
                    searchParams.delete(param)
                }

                if (val != "") {
                    searchParams.append(param, val)
                }
            })

            // console.log(searchParams.toString(), param, val);
            // return false;
            
            return window.location.href = "?"+searchParams.toString()+"#rowtable"
        }

        $('#category-filter').change(function () {
            getDataFilter('category', $(this).val())
        })

        $('#status-filter').change(function () {
            getDataFilter('status', $(this).val())
        })

        $('#created_at').change(function () {
            getDataFilter('created_at', $(this).val())
        })
    </script>
@endpush
