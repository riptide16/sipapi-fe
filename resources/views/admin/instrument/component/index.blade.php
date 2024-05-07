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
                <li class="breadcrumb-item active" aria-current="page">Instrument</li>
            </ol>
        </nav>
        <h2 class="h4">Data Instrument</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        {{-- <x-buttons.create :href="route('admin.akreditasi.create')" :title="__('Instrument')" /> --}}
    </div>
</div>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: none;">
        <button class="nav-link @if(isset($type) && $type == 'main' || $type == null) active @endif" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Komponen</button>
        <button class="nav-link @if(isset($type) && $type == 'sub_1') active @endif" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Sub-Komponen Pertama</button>
        <button class="nav-link @if(isset($type) && $type == 'sub_2') active @endif" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Sub-Komponen Kedua</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade @if(isset($type) && $type == 'main' || $type == null) active show @endif" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <div class="btn-toolbar mb-2 mb-md-0">
                    <x-buttons.create :href="route('admin.kategori_instrumen.create', ['type' => 'main'])" :title="__('Komponen')" />
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0 rounded-start" style="max-width:20px">No</th>
                                <th class="border-0" style="max-width:120px">Jenis Perpustakaan</th>
                                <th class="border-0" style="max-width:150px">Komponen</th>
                                <th class="border-0" style="max-width:30px">Bobot</th>
                                <th class="border-0" style="max-width:200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @forelse ($components as $data)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $data['category'] }}</td>
                                    <td>{{ $data['name'] }}</td>
                                    <td>{{ $data['weight'] }}</td>
                                    <td>
                                        @include('components.general-actions', [
                                            'route' => 'admin.kategori_instrumen',
                                            'id' => $data['id'],         
                                            'type' => 'main',                               
                                            'actions' => [
                                                'show' => true,
                                                'edit' => true,
                                                'delete' => true,
                                                'type' => true
                                            ]
                                        ])
                                    </td>
                                </tr>
                            @php $i++; @endphp
                            @empty
                                <tr>
                                    <td colspan="5">No Have Match Data in Table</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade @if(isset($type) && $type == 'sub_1') active show @endif" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <div class="btn-toolbar mb-2 mb-md-0">
                    <x-buttons.create :href="route('admin.kategori_instrumen.create', ['type' => 'sub_1'])" :title="__('Sub-Komponen Pertama')" />
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-2" class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0 rounded-start" style="max-width:20px">No</th>
                                <th class="border-0" style="max-width:120px">Jenis Perpustakaan</th>
                                <th class="border-0" style="max-width:150px">Komponen</th>
                                <th class="border-0" style="max-width:150px">Sub-Komponen Pertama</th>
                                <th class="border-0" style="max-width:200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @forelse ($firstSubComponents as $data)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{!! wordwrap($data['parent']['category'], 10, "<wbr>", true); !!}</td>
                                    <td>{!! wordwrap($data['parent']['name'], 15, "<wbr>", true); !!}</td>
                                    <td>{!! wordwrap($data['name'], 15, "<wbr>", true); !!}</td>
                                    <td style="width: 200px">
                                        @include('components.general-actions', [
                                            'route' => 'admin.kategori_instrumen',
                                            'id' => $data['id'],        
                                            'type' => 'sub_1',                                
                                            'actions' => [
                                                'show' => true,
                                                'edit' => true,
                                                'delete' => true,
                                                'type' => true
                                            ]
                                        ])
                                    </td>
                                </tr>
                            @php $i++; @endphp
                            @empty
                                <tr>
                                    <td colspan="5">No Have Match Data in Table</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade @if(isset($type) && $type == 'sub_2') active show @endif" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <div class="btn-toolbar mb-2 mb-md-0">
                    <x-buttons.create :href="route('admin.kategori_instrumen.create', ['type' => 'sub_2'])" :title="__('Sub-Komponen Kedua')" />
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-3" class="table table-centered table-nowrap mb-0 rounded">
                        <thead>
                            <tr>
                                <th class="border-0 rounded-start">No</th>
                                <th class="border-0">Jenis Perpustakaan</th>
                                <th class="border-0">Komponen</th>
                                <th class="border-0">Sub-Komponen Pertama</th>
                                <th class="border-0">Sub-Komponen Kedua</th>
                                <th class="border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @forelse ($secondSubComponents as $data)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $data['parent']['parent']['category'] }}</td>
                                    <td>{!! wordwrap($data['parent']['parent']['name'], 15, "<wbr>", true); !!}</td>
                                    <td>{!! wordwrap($data['parent']['name'], 15, "<wbr>", true); !!}</td>
                                    <td>{!! wordwrap($data['name'], 15, "<wbr>", true); !!}</td>
                                    <td style="width: 300px !important">
                                        @include('components.general-actions', [
                                            'route' => 'admin.kategori_instrumen',
                                            'id' => $data['id'],
                                            'type' => 'sub_2',
                                            'actions' => [
                                                'show' => true,
                                                'edit' => true,
                                                'delete' => true,
                                                'type' => true
                                            ]
                                        ])
                                    </td>
                                </tr>
                            @php $i++; @endphp
                            @empty
                                <tr>
                                    <td colspan="5">No Have Match Data in Table</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection

@push('js')
    <script src="{{ asset('admin/js/data-table.js') }}"></script>
@endpush
