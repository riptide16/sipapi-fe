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
                <li class="breadcrumb-item active" aria-current="page">Nilai Akhir Penilaian</li>
            </ol>
        </nav>
        <h2 class="h4">Nilai Akhir Penilaian Perpustakaan</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <tr>
                            <td><strong>Nama Perpustakaan</strong></td>
                            <td>{{ $result['institution']['library_name'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $result['evaluation']['created_at'] ? \Helper::formatDate($result['evaluation']['created_at'], 'd F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tim Asesor</strong></td>
                            @php
                                $assessors = [];
                                foreach ($assignment['assessors'] as $assessor) {
                                    $assessors[] = $assessor['name'];
                                }
                                $assessors = implode(', ', $assessors);
                            @endphp
                            <td>{{ $assessors }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <tr>
                            <td><strong>Predikat</strong></td>
                            <td>{{ $result['evaluation']['final_result']['predicate'] ? __('Akreditasi '.$result['evaluation']['final_result']['predicate']) : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Komponen</th>
                        <th>Jumlah Skor</th>
                        <th>Jumlah Soal</th>
                        <th>Bobot</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($result['evaluation']['evaluation_result'] as $item)
                        <tr>
                            <td class="border-bottom-1 rounded-start">{{ $index }}</td>
                            <td class="border-bottom-1">{{ $item['instrument_component'] }}</td>
                            <td class="border-bottom-1">{{ $item['total_value'] }}</td>
                            <td class="border-bottom-1">{{ $item['total_instrument'] }}</td>
                            <td class="border-bottom-1">{{ $item['weight'] }}</td>
                            <td class="border-bottom-1">{{ $item['score'] }}</td>
                        </tr>
                        @php
                            $index++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot class="bg-dark text-white">
                    <tr>
                        <td colspan="2"><b>Jumlah</b></td>
                        <td><b>{{ $result['evaluation']['final_result']['total_value'] }}</b></td>
                        <td><b>{{ $result['evaluation']['final_result']['total_instrument'] }}</b></td>
                        <td><b>{{ $result['evaluation']['final_result']['weight'] }}</b></td>
                        <td><b>{{ $result['evaluation']['final_result']['score'] }}</b></td>
                    </tr>
                </tfoot>
            </table>

            <form action="{{ route('admin.penilaian.finalize', [$result['evaluation']['id']]) }}" class="pt-3" method="POST" enctype="multipart/form-data">
                @csrf
                <h5>Rekomendasi</h5>
                @foreach ($result['results'] as $recommendation)
                    <div class="form-group row mb-2">
                        <div class="col-md-3">
                            <x-forms.label :label="__('Komponen '.$recommendation['instrument_component'])"/>
                        </div>
                        <div class="col-md-9">
                            <x-forms.input name="recommendations[{{ $recommendation['instrument_component_id'] }}]" value="" style="border-color: #777" required/>
                        </div>
                    </div>
                @endforeach
                <div class="form-group row mt-2 mb-2">
                    <div class="col-md-12">
                        <button id="btn-finalize" class="btn btn-info" type="submit">Save & Download Berita Acara</button>
                        <x-buttons.cancel :href="route('admin.penilaian.show', [$id])"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $('#btn-finalize').on('click', function () {
                const myTimeout = setTimeout(redirect, 5000);
            })

            function redirect() {
                window.location.href = '{{ route('admin.penilaian.index') }}';
            }
        })
    </script>
@endpush
