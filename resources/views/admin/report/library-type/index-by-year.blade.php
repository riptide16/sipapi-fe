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
        <h2 class="card-title">Report Jumlah Akreditasi Berdasarkan Jenis Perpustakaan Pertahun</h2>
        <a href="?export=1&year={{ $year }}" class="btn btn-success float-end" id="export">Export File</a>
    </div>
    <div class="card-body">
        <div class="form-group mb-4 row">
            <div class="col-md-2">
                <x-forms.label :label="__('Tahun')"/>
            </div>
            <div class="col-md-3">
                <select name="tahun" id="tahun" class="form-control">
                    @for ($i = 2021; $i < date('Y') + 5; $i++)
                        <option value="{{ $i }}" @if ($year == $i) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Jenis Perpustakaan</th>
                        <th class="border-0">A</th>
                        <th class="border-0">B</th>
                        <th class="border-0">C</th>
                        <th class="border-0">{{ $year }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $countA = 0;
                        $countB = 0;
                        $countC = 0;
                    @endphp
                    @foreach ($fetchData['data'] as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            @if (count($fetchData['data'][$key]) > 0)
                                @php
                                    $countD = 0;
                                @endphp
                                @if (array_key_exists('A', $value))
                                    <td>{{ $value['A'] ?? 0 }}</td>
                                    @php
                                        $countA += $value['A'] ?? 0;
                                        $countD += $value['A'] ?? 0;
                                    @endphp
                                @else
                                <td>0</td>
                                @endif
                                @if (array_key_exists('B', $value))
                                    <td>{{ $value['B'] ?? 0 }}</td>
                                    @php
                                        $countB += $value['B'] ?? 0;
                                        $countD += $value['B'] ?? 0;
                                    @endphp
                                @else
                                <td>0</td>
                                @endif
                                @if (array_key_exists('C', $value))
                                    <td>{{ $value['C'] ?? 0 }}</td>
                                    @php
                                        $countC += $value['C'] ?? 0;
                                        $countD += $value['C'] ?? 0;
                                    @endphp
                                @else
                                <td>0</td>
                                @endif
                                <td>{{ $countD }}</td>
                            @else
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        <td>{{ $countA }}</td>
                        <td>{{ $countB }}</td>
                        <td>{{ $countC }}</td>
                        <td>{{ $countA + $countB + $countC }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        const url = "{{ route('admin.report.library_type.by_year') }}";
        $(document).ready(function () {
            $('#tahun').change(function () {
                let year = $(this).val();

                window.location.href = url + '?year=' + year;
            });
        });
    </script>
@endpush
