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
                <li class="breadcrumb-item active" aria-current="page">FAQ </li>
            </ol>
        </nav>
        <h2 class="h4">Data FAQ</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <x-buttons.create :href="route('admin.faq.create')" :title="__('FAQ')" />
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">No</th>
                        <th class="border-0">Pertanyaan</th>
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
                            <td>{{ substr($data['title'], 0, 50) }}...</td>
                            <td>
                                @include('components.general-actions-resource', [
                                    'route' => 'admin.faq',
                                    'id' => $data['id'],
                                    'model' => 'faq',
                                    'actions' => [
                                        'edit' => true,
                                        'delete' => true,
                                        'show' => true
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
@endsection

@push('js')
    <script src="{{ asset('admin/js/data-table.js') }}"></script>
@endpush
