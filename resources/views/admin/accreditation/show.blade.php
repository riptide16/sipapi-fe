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
                    <a href="{{ route('admin.akreditasi.index') }}" class="text-info">
                        All Akreditasi
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">View Akreditasi</li>
            </ol>
        </nav>
        <h2 class="h4">View Data Akreditasi</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <ul class="nav navbtn nav-justified" style="border: none;">
            @if (!\Helper::isAsesi())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.akreditasi.file_download', [$id]) }}">Download File</a>
                </li>
                <li class="nav-item {{ $accreditation['status'] == 'belum_lengkap' ? 'disabled' : '' }}">
                    <a class="nav-link" href="{{ route('admin.akreditasi.verify', [$id]) }}">Verifikasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Nilai</a>
                </li>
                @if (\Helper::isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.penilaian.recap', ['id' => $id]) }}">Rekap</a>
                    </li>
                    <li class="nav-item" {{ $status != 'penilaian_rapat' ? 'disabled' : '' }}>
                        <a class="nav-link" href="{{ route('admin.akreditasi.process', [$id]) }}">Proses</a>
                    </li>
                @else
                    <li class="nav-item" {{ $status != 'penilaian_rapat' ? 'disabled' : '' }}>
                        <a class="nav-link" href="{{ route('admin.akreditasi.process', [$id]) }}">Proses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.penilaian.recap', ['id' => $id]) }}">Rekap</a>
                    </li>
                @endif
            @endif
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
        <hr>
    </div>
    <div class="card-body">
        @if (!empty($fetchData['data']))
            @php
                $aspectNo = 1;
            @endphp
            @foreach ($fetchData['data'] as $data)
                <h3>{{ $fetchData['meta']['current_page'] }}. {{ $data['name'] }}</h3>
                <input type="hidden" name="action_type" value="{{ $data['action_type'] }}" />
                @foreach ($data['aspects'] ?? [] as $dataAspect)
                    <input type="hidden" name="aspects[]" value="{{ $dataAspect['id'] }}" />
                    @if ($dataAspect['type'] == 'multi_aspect')
                        <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>
                        @foreach ($dataAspect['children'] as $multiChildAspect)
                            @if (!empty($multiChildAspect['points']))
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px;">{{ $multiChildAspect['aspect'] }}</h5><br>


                                @php $index = 'A'; @endphp
                                @foreach ($multiChildAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1 position-relative">
                                        @if (!empty($dataAspect['answers']))
                                            <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
                                            @else
                                                <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                            @endif
                                        @endif
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            @endif
                            <br>
                        @endforeach
                    @endif
                    @if (!empty($dataAspect['points']))
                        <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre-line;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>

                        @php $index = 'A'; @endphp
                        @foreach ($dataAspect['points'] as $key3 => $point)
                            <div class="col-md-9 mb-1">
                                @if (!empty($dataAspect['answers']))
                                    <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                    @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                        <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
                                    @else
                                        <input type="radio" disabled style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                    @endif
                                @endif
                            </div>
                            @php $index++; @endphp
                        @endforeach
                    @endif
                    <br>
                @endforeach
                @foreach ($data['children'] ?? [] as $key => $data1)
                    <h4>
                        {{ $fetchData['meta']['current_page'] }}.{{ $key + 1 }}. {{ $data1['name'] }}
                    </h4>
                    @foreach ($data1['aspects'] as $dataAspect)
                        <input type="hidden" name="aspects[]" value="{{ $dataAspect['id'] }}" />
                        @if ($dataAspect['type'] == 'multi_aspect')
                            <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre-line;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>
                            @foreach ($dataAspect['children'] as $multiChildAspect)
                                @if (!empty($multiChildAspect['points']))
                                    <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre-line;">{{ $multiChildAspect['aspect'] }}</h5><br>

                                    @php $index = 'A'; @endphp
                                    @foreach ($multiChildAspect['points'] as $key3 => $point)
                                        <div class="col-md-9 mb-1 position-relative">
                                            @if (!empty($dataAspect['answers']))
                                                <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                                @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                    <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                    <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
                                                @else
                                                    <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                    <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                                @endif
                                            @endif
                                        </div>
                                        @php $index++; @endphp
                                    @endforeach
                                @endif
                                <br>
                            @endforeach
                        @endif
                        @if (!empty($dataAspect['points']))
                            <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre-line;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>

                                @php $index = 'A'; @endphp
                                @foreach ($dataAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1">
                                        @if (!empty($dataAspect['answers']))
                                            <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
                                            @else
                                                <input type="radio" disabled style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                            @endif
                                        @endif
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            @endif
                            <br>
                    @endforeach
                    @foreach ($data1['children'] as $key2 => $data2)
                        {{-- <br><h5>{{ $data2['name'] }}</h5> --}}
                        <h5>{{ $fetchData['meta']['current_page'] }}.{{ $key + 1 }}.{{ $key2 + 1 }}. {{ $data2['name'] }}</h5>
                        @foreach ($data2['aspects'] as $dataAspect)
                            <input type="hidden" name="aspects[]" value="{{ $dataAspect['id'] }}" />
                            @if ($dataAspect['type'] == 'multi_aspect')
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre-line;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>
                                @foreach ($dataAspect['children'] as $multiChildAspect)
                                    @if (!empty($multiChildAspect['points']))
                                        <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre-line;">{{ $multiChildAspect['aspect'] }}</h5><br>

                                        @php $index = 'A'; @endphp
                                        @foreach ($multiChildAspect['points'] as $key3 => $point)
                                            <div class="col-md-9 mb-1 position-relative">
                                                @if (!empty($dataAspect['answers']))
                                                    <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                                    @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                        <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
                                                    @else
                                                        <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                                    @endif
                                                @endif
                                            </div>
                                            @php $index++; @endphp
                                        @endforeach
                                    @endif
                                    <br>
                                @endforeach
                            @endif
                            @if (!empty($dataAspect['points']))
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre-line;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>

                                @php $index = 'A'; @endphp
                                @foreach ($dataAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1">
                                        @if (!empty($dataAspect['answers']))
                                            <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
                                            @else
                                                <input type="radio" disabled style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
                                            @endif
                                        @endif
                                    </div>
                                    @php $index++; @endphp
                                @endforeach
                            @endif
                            <br>
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
        <div class="form-group">
            <div class="col-md-12">
                <br>
                <x-buttons.back style="float:right;" :href="route('admin.akreditasi.show', ['akreditasi' => $id, 'page' => isset($fetchData['links']) && $fetchData['links']['prev'] != null ? $fetchData['meta']['to'] - 1 : 1])"/>
                <x-buttons.next style="float:right;margin-right:10px;" :href="route('admin.akreditasi.show', ['akreditasi' => $id, 'page' => isset($fetchData['links']) && $fetchData['links']['next'] != null ? $fetchData['meta']['to'] + 1 : 1])"/>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">No</th>
                        <th class="border-0">Komponen</th>
                        <th class="border-0">Link</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @forelse ($fetchDataVideo['data'] as $data)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>Video Pendukung Perpustakaan</td>
                            <td>
                                @if(count($data['answers']) > 0)
                                    <a class="btn btn-info" target="_blank" href="{{ $data['answers'][0]['url'] }}"><x-icons.download/></a>
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @empty
                        <tr>
                            <td colspan="2">No Have Match Data in Table</td>
                        </tr>
                    @endforelse
                    @forelse ($fetchDataGdrive['data'] as $data)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>Link Google Drive Bukti Fisik</td>
                            <td>
                                @if(count($data['answers']) > 0)
                                    <a class="btn btn-info" target="_blank" href="{{ $data['answers'][0]['url'] }}"><x-icons.download/></a>
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @empty
                        <tr>
                            <td colspan="2">No Have Match Data in Table</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
