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
                <li class="breadcrumb-item active" aria-current="page">Report</li>
            </ol>
        </nav>
        <h2 class="h4">Report</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Report Jumlah Akreditasi Berdasarkan Jenis Perpustakaan Dalam Tahun</h2>
        <a href="?export=1" class="btn btn-success float-end">Export File</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Jenis Perpustakaan</th>
                    @foreach ($resultYears as $item)
                        <th class="border-0">{{ $item }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fetchData['data']['per_year'] as $key => $value)
                        <tr>
                            <td><a href="{{ route('admin.report.library_type.in_year.detail_type_year', ['category' => $key]) }}">{{ $key }}</a></td>
                            @foreach ($resultYears as $year)
                                <td>{{ $value[$year] ?? 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        @foreach ($resultYears as $item)
                        <td>{{ $fetchData['data']['totals'][$item] ?? 0 }}</td>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
