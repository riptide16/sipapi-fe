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
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.instrumen.index') }}">
                        Instrumen
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Aspect
                </li>
            </ol>
        </nav>
        <h2 class="h4">Data Aspect - {{ $fetchDataInstrument['data']['category'] }}</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <x-buttons.create :href="route('admin.instrumen.aspects.create', ['instrument' => $instrument])" :title="__('Aspect')" />
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable-4" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start" style="width: 10px">No</th>
                        <th class="border-0">Aspect</th>
                        <th class="border-0">Type</th>
                        <th class="border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @forelse ($fetchData['data'] as $data)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{!! wordwrap($data['aspect'], 40, "<wbr>", true); !!}</td>
                            <td>{{ $data['type'] }}</td>
                            <td style="width: 200px">
                                @include('components.general-actions-resource', [
                                    'route' => 'admin.instrumen.aspects',
                                    'id' => $data['id'],
                                    'model' => 'aspect',
                                    'sub_id' => $instrument,
                                    'sub_model' => 'instrument',
                                    'actions' => [
                                        'edit' => true,
                                        'delete' => true,
                                        'show' => true,
                                    ]
                                ])
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Have Match Data in Table</td>
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
@endpush