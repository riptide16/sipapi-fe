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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.report.index') }}">
                        Report
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Per Jenis/Tahun
                </li>
            </ol>
        </nav>
        <h2 class="h4">Report</h2>
    </div>

</div>
<div class="card border-0 shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Report Jumlah Akreditasi {{ $type }} Dalam Tahun</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Tahun</th>
                        <th class="border-0">A</th>
                        <th class="border-0">B</th>
                        <th class="border-0">C</th>
                    </tr>
                </thead>
                <tbody>
                    @if (
                        count($fetchData['data']['per_year']['A']) > 0
                        || count($fetchData['data']['per_year']['B']) > 0
                        || count($fetchData['data']['per_year']['C']) > 0
                    )
                        @foreach ($fetchData['data']['per_year'] as $key => $value)
                            <tr>
                                @if (
                                    count($fetchData['data']['per_year']['A']) > 0
                                    && count($fetchData['data']['per_year']['B']) > 0
                                    && count($fetchData['data']['per_year']['C']) > 0
                                )
                                    @foreach ($fetchData['data']['per_year']['A'] as $key2 => $item)
                                        @if (
                                            in_array($key2, array_keys($fetchData['data']['per_year']['B']))
                                            && in_array($key2, array_keys($fetchData['data']['per_year']['C']))
                                        )
                                            <td>{{ $key2 }}</td>
                                            <td>{{ $item }}</td>
                                            <td>{{ $fetchData['data']['per_year']['B'][$key2] }}</td>
                                            <td>{{ $fetchData['data']['per_year']['C'][$key2] }}</td>
                                    @endif
                                    @endforeach
                                @else
                                    @if (count($fetchData['data']['per_year']['A']) > 0)
                                        @foreach ($fetchData['data']['per_year']['A'] as $key2 => $item)
                                            <td>{{ $key2 }}</td>
                                            <td>{{ $item }}</td>
                                            <td>{{ $fetchData['data']['per_year']['B'][$key2] ?? '-' }}</td>
                                            <td>{{ $fetchData['data']['per_year']['C'][$key2] ?? '-' }}</td>
                                        @endforeach
                                    @elseif (count($fetchData['data']['per_year']['B']) > 0)
                                        @foreach ($fetchData['data']['per_year']['B'] as $key2 => $item)
                                            <td>{{ $key2 }}</td>
                                            <td>{{ $fetchData['data']['per_year']['A'][$key2] ?? '-' }}</td>
                                            <td>{{ $item }}</td>
                                            <td>{{ $fetchData['data']['per_year']['C'][$key2] ?? '-' }}</td>
                                        @endforeach
                                    @elseif (count($fetchData['data']['per_year']['C']) > 0)
                                        @foreach ($fetchData['data']['per_year']['C'] as $key2 => $item)
                                            <td>{{ $key2 }}</td>
                                            <td>{{ $fetchData['data']['per_year']['A'][$key2] ?? '-' }}</td>
                                            <td>{{ $fetchData['data']['per_year']['B'][$key2] ?? '-' }}</td>
                                            <td>{{ $item }}</td>
                                        @endforeach
                                    @else
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
