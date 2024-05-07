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
                <li class="breadcrumb-item active" aria-current="page">Rekap Penilaian</li>
            </ol>
        </nav>
        <h2 class="h4">Rekap Penilaian</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Kode Pengajuan :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$result['code']"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Nama Perpustakaan :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$result['institution']['library_name'] ?? '-'"/>
            </div>
        </div>
        <hr>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
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
                        <tr>
                            <td><strong>Berita Acara</strong></td>
                            @if (isset($result['evaluation']['document_file']))
                                <td><a class="btn-info px-3 py-1 rounded" href="{{ $result['evaluation']['document_file'] }}">Download</a></td>
                            @else
                                <td>-</td>
                            @endif
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
                            <td class="border-bottom-1">{{ round($item['score'], 2) }}</td>
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
                        <td><b>{{ round($result['evaluation']['final_result']['score'], 2) }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @if (isset($result['evaluation']['recommendations']))
        <div class="card-body">
            <h5>Rekomendasi</h5>
            <table class="table table-centered table-nowrap mb-0 rounded" style="border-collapse: separate; border-spacing:0 10px;">
                <tbody>
                    @foreach ($result['evaluation']['recommendations'] as $recommendation)
                        <tr>
                            <td class="border-bottom-1 ps-0 pe-4" width="50">{{ 'Komponen '.$recommendation['name'] }}</td>
                            <td class="border-1 border-dark rounded">{{ $recommendation['content'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if (\Helper::isAsesor())
        <div class="card-body">
            <form action="{{ route('admin.penilaian.upload', [$result['evaluation']['id']]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row mb-2">
                    <h5>Unggah Dokumen Berita Acara</h5>
                    <x-forms.input type="file" name="file" accept=".doc,.docx,.pdf" required />
                </div>
                <div class="form-group row mt-2 mb-2">
                    <div class="col-md-12">
                        <button id="btn-finalize" class="btn btn-info" type="submit">Submit</button>
                        <x-buttons.cancel :href="route('admin.penilaian.show', [$id])"/>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
