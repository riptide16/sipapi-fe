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
                <li class="breadcrumb-item active" aria-current="page">View Penilaian</li>
            </ol>
        </nav>
        <h2 class="h4">View Data Penilaian</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <ul class="nav navbtn nav-justified" style="border: none;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.penilaian.file_download', [$id]) }}">Download File</a>
            </li>
            @if (isset($assignment) && \Carbon\Carbon::parse($assignment['scheduled_date'], 'Asia/Jakarta')->isPast())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id]) }}">Nilai</a>
                </li>
            @endif
            @if (!\Helper::isAsesor())
                <li class="nav-item">
                    <a class="nav-link" href="#">Proses</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.penilaian.recap', [$id]) }}">Rekap</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Kode Pengajuan :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data'][0]['accreditation']['code']"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Nama Lembaga Induk :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data'][0]['accreditation']['institution']['agency_name']"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Nama Perpustakaan :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data'][0]['accreditation']['institution']['library_name']"/>
            </div>
        </div>
        <hr>
        <div class="form-group mb-2">
        <div class="col-md-3">
            <x-forms.label :label="__('Nilai Self Assessment')"/>
        </div>
        <div class="col-md-9">
            <x-forms.label class="text-info" :label="round($finalResult, 2)"/>
        </div>
    </div>
    <div class="form-group mb-2">
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
                    @foreach ($result['results'] as $item)
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
                        <td><b>{{ $result['finalResult']['total_value'] }}</b></td>
                        <td><b>{{ $result['finalResult']['total_instrument'] }}</b></td>
                        <td><b>{{ $result['finalResult']['weight'] }}</b></td>
                        <td><b>{{ round($result['finalResult']['score'], 2) }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </div>
    
    <div class="card-body">
        @if (!empty($fetchData['data']))
            @foreach ($fetchData['data'] as $data)
                <h3>{{ $fetchData['meta']['current_page'] }}. {{ $data['name'] }}</h3>
                @foreach ($data['aspects'] ?? [] as $dataAspect)
                    @if ($dataAspect['type'] == 'multi_aspect')
                        <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $loop->iteration.'. '.$dataAspect['aspect'] }}</h5><br>
                        @foreach ($dataAspect['children'] as $multiChildAspect)
                            @if (!empty($multiChildAspect['points']))
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $multiChildAspect['aspect'] }}</h5><br>

                                @foreach ($multiChildAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1 position-relative">
                                        @if (!empty($dataAspect['answers']))
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                            @else
                                                <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                            @endif
                                        @endif
                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                    @if (!empty($dataAspect['points']))
                        <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $loop->iteration.'. '.$dataAspect['aspect'] }}</h5><br>

                        @foreach ($dataAspect['points'] as $key3 => $point)
                            <div class="col-md-9 mb-1">
                                @if (!empty($dataAspect['answers']))
                                    @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                        <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                    @else
                                        <input type="radio" disabled style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                    @endif
                                @endif
                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                @foreach ($data['children'] ?? [] as $key => $data1)
                    <h4>
                        {{ $fetchData['meta']['current_page'] }}.{{ $key + 1 }}. {{ $data1['name'] }}
                    </h4>
                    @foreach ($data1['aspects'] as $dataAspect)
                        @if ($dataAspect['type'] == 'multi_aspect')
                            <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $loop->iteration.'. '.$dataAspect['aspect'] }}</h5><br>
                            @foreach ($dataAspect['children'] as $multiChildAspect)
                                @if (!empty($multiChildAspect['points']))
                                    <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $multiChildAspect['aspect'] }}</h5><br>

                                    @foreach ($multiChildAspect['points'] as $key3 => $point)
                                        <div class="col-md-9 mb-1 position-relative">
                                            @if (!empty($dataAspect['answers']))
                                                @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                    <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                @else
                                                    <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                @endif
                                            @endif
                                            <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                        @if (!empty($dataAspect['points']))
                            <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $loop->iteration.'. '.$dataAspect['aspect'] }}</h5><br>

                            @foreach ($dataAspect['points'] as $key3 => $point)
                                <div class="col-md-9 mb-1">
                                    @if (!empty($dataAspect['answers']))
                                        @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                            <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                        @else
                                            <input type="radio" disabled style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                        @endif
                                    @endif
                                    <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                    @foreach ($data1['children'] as $key2 => $data2)
                        {{-- <br><h5>{{ $data2['name'] }}</h5> --}}
                        <h5>{{ $fetchData['meta']['current_page'] }}.{{ $key + 1 }}.{{ $key2 + 1 }}. {{ $data2['name'] }}</h5>
                        @foreach ($data2['aspects'] as $dataAspect)
                            @if ($dataAspect['type'] == 'multi_aspect')
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $loop->iteration.'. '.$dataAspect['aspect'] }}</h5><br>
                                @foreach ($dataAspect['children'] as $multiChildAspect)
                                    @if (!empty($multiChildAspect['points']))
                                        <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $multiChildAspect['aspect'] }}</h5><br>

                                        @foreach ($multiChildAspect['points'] as $key3 => $point)
                                            <div class="col-md-9 mb-1 position-relative">
                                                @if (!empty($dataAspect['answers']))
                                                    @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                        <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                    @else
                                                        <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                    @endif
                                                @endif
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if (!empty($dataAspect['points']))
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $loop->iteration.'. '.$dataAspect['aspect'] }}</h5><br>

                                @foreach ($dataAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1">
                                        @if (!empty($dataAspect['answers']))
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                            @else
                                                <input type="radio" disabled style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                            @endif
                                        @endif
                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
                <hr>
                @if (!empty($data['answers']))
                    @foreach ($data['answers'] as $proof)
                        <h5>{{ $proof['aspect'] }}</h5>
                        <a class="btn btn-info" href="{{ $proof['file'] }}" rel="noopener noreferrer">Download Bukti</a>
                    @endforeach
                @endif
            @endforeach
        @endif
        <div class="col-md-12">
            <br>
            @if(!empty($fetchData['links']['prev']))
                <x-buttons.prev :href="route('admin.penilaian.show', ['penilaian' => $id, 'page' => $fetchData['meta']['current_page'] - 1])"/>
            @endif
            @if (!empty($fetchData['links']['next']))
                <x-buttons.next :href="route('admin.penilaian.show', ['penilaian' => $id, 'page' => $fetchData['meta']['current_page'] + 1])"/>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $('.multi_aspect_select').change(function (e) {
        let selfIndex = $(this).data('index');
        let selfAspectId = $(this).data('aspect-id');
        $('select.multi_'+selfAspectId).each(function () {
            console.log($(this).data('index'));
            if ($(this).data('index') != selfIndex) {
                $(this).val("");
                $(this).prop('required', false);
                $(this).removeAttr('name');
            } else {
                $(this).prop('required', true);
                $(this).prop('name', 'evaluations['+selfAspectId+']');
            }
        });
    });

    $(function () {
        let selected = $('.evaluation select').map(function () {
            return this.value ? this : null;
        }).get();
        selected.forEach(function (select) {
            $(select).change();
        });
    });
</script>
@endpush
