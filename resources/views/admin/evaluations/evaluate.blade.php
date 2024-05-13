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
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.penilaian.show', [$id]) }}" class="text-info">
                        View Penilaian
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Nilai Penilaian</li>
            </ol>
        </nav>
        <h2 class="h4">Nilai Data Penilaian</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
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
                <x-forms.label :label="__('Nama Perpustakaan :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data'][0]['accreditation']['institution']['library_name']"/>
            </div>
        </div>
        <hr>
    </div>
    <div class="card-body">
        @if (!empty($fetchData['data']))
        <form action="{{ route('admin.penilaian.save', [$id]) }}" method="POST" enctype="multipart/form-data">
            <ul class="nav navbtn nav-justified mb-5" style="border: none;">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id]) }}">Komponen 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=2']) }}">Komponen 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=3']) }}">Komponen 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=4']) }}">Komponen 4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=5']) }}">Komponen 5</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=6']) }}">Komponen 6</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=7']) }}">Komponen 7</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=8']) }}">Komponen 8</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.penilaian.evaluate', [$id, 'page=9']) }}">Komponen 9</a>
                </li>
            </ul>
            <hr>
            @csrf
            <div class="form-group mb-5">
                <div class="col-md-12">
                    <br>
                    @if(!empty($fetchData['links']['prev']))
                        <x-buttons.prev :href="route('admin.penilaian.evaluate', ['penilaian' => $id, 'page' => $fetchData['meta']['current_page'] - 1])"/>
                    @endif
                    <x-buttons.save :title="__($fetchData['links']['next'] ? 'Simpan' : 'Proses')"/>
                </div>
            </div>
            @php
                $aspectNo = 1;
            @endphp
            @if ($fetchData['links']['next'])
                <input type="hidden" name="next" value="{{ $fetchData['meta']['current_page'] + 1 }}">
            @endif
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

                                <div class="evaluation position-absolute end-0" style="min-width:130px">
                                    <h5>Nilai Aspek</h5>
                                    <select class="multi_aspect_select multi_{{ $dataAspect['id'] }}" name="evaluations[{{ $dataAspect['id'] }}]" data-aspect-id="{{ $dataAspect['id'] }}" data-index="{{ $loop->index }}" required>
                                        <option value="">Select</option>
                                        @foreach (range('A', 'E') as $key3 => $answer)
                                            <option value="{{ $multiChildAspect['points'][$key3]['id'] }}"
                                                {{ isset($dataAspect['answers'][0]['evaluation']) && $dataAspect['answers'][0]['evaluation']['instrument_aspect_point_id'] == $multiChildAspect['points'][$key3]['id'] ? 'selected' : '' }}>
                                                {{ $answer }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @php $index = 'A'; @endphp
                                @foreach ($multiChildAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1 position-relative">
                                        @if (!empty($dataAspect['answers']))
                                            <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }} background-color: #313131; font-weight: bold; color: white;" disabled/>
                                            @else
                                                <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }} {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
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
                        <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>

                        <div class="evaluation position-absolute end-0" style="min-width:130px">
                            <h5>Nilai Aspek</h5>
                            <select name="evaluations[{{ $dataAspect['id'] }}]" required>
                                <option value="">Select</option>
                                @foreach (range('A', 'E') as $key3 => $answer)
                                    <option value="{{ $dataAspect['points'][$key3]['id'] }}"
                                        {{ isset($dataAspect['answers'][0]['evaluation']) && $dataAspect['answers'][0]['evaluation']['instrument_aspect_point_id'] == $dataAspect['points'][$key3]['id'] ? 'selected' : '' }}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @php $index = 'A'; @endphp
                        @foreach ($dataAspect['points'] as $key3 => $point)
                            <div class="col-md-9 mb-1">
                                @if (!empty($dataAspect['answers']))
                                    <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                    @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                        <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }} background-color: #313131; font-weight: bold; color: white;" disabled/>
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
                            <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>
                            @foreach ($dataAspect['children'] as $multiChildAspect)
                                @if (!empty($multiChildAspect['points']))
                                    <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre;">{{ $multiChildAspect['aspect'] }}</h5><br>

                                    <div class="evaluation position-absolute end-0" style="min-width:130px">
                                        <h5>Nilai Aspek</h5>
                                        <select class="multi_aspect_select multi_{{ $dataAspect['id'] }}" name="evaluations[{{ $dataAspect['id'] }}]" data-aspect-id="{{ $dataAspect['id'] }}" data-index="{{ $loop->index }}" required>
                                            <option value="">Select</option>
                                            @foreach (range('A', 'E') as $key3 => $answer)
                                                <option value="{{ $multiChildAspect['points'][$key3]['id'] }}"
                                                    {{ isset($dataAspect['answers'][0]['evaluation']) && $dataAspect['answers'][0]['evaluation']['instrument_aspect_point_id'] == $multiChildAspect['points'][$key3]['id'] ? 'selected' : '' }}>
                                                    {{ $answer }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php $index = 'A'; @endphp
                                    @foreach ($multiChildAspect['points'] as $key3 => $point)
                                        <div class="col-md-9 mb-1 position-relative">
                                            @if (!empty($dataAspect['answers']))
                                                <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                                @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                    <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                    <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }}. {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }} background-color: #313131; font-weight: bold; color: white;" disabled/>
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
                            <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>

                            <div class="evaluation position-absolute end-0" style="min-width:130px">
                                <h5>Nilai Aspek</h5>
                                <select name="evaluations[{{ $dataAspect['id'] }}]" required>
                                    <option value="">Select</option>
                                    @foreach (range('A', 'E') as $key3 => $answer)
                                        <option value="{{ $dataAspect['points'][$key3]['id'] }}"
                                            {{ isset($dataAspect['answers'][0]['evaluation']) && $dataAspect['answers'][0]['evaluation']['instrument_aspect_point_id'] == $dataAspect['points'][$key3]['id'] ? 'selected' : '' }}>
                                            {{ $answer }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                                @php $index = 'A'; @endphp
                                @foreach ($dataAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1">
                                        @if (!empty($dataAspect['answers']))
                                            <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }} {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
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
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>
                                @foreach ($dataAspect['children'] as $multiChildAspect)
                                    @if (!empty($multiChildAspect['points']))
                                        <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre;">{{ $multiChildAspect['aspect'] }}</h5><br>

                                        <div class="evaluation position-absolute end-0" style="min-width:130px">
                                            <h5>Nilai Aspek</h5>
                                            <select class="multi_aspect_select multi_{{ $dataAspect['id'] }}" name="evaluations[{{ $dataAspect['id'] }}]" data-aspect-id="{{ $dataAspect['id'] }}" data-index="{{ $loop->index }}" required>
                                                <option value="">Select</option>
                                                @foreach (range('A', 'E') as $key3 => $answer)
                                                    <option value="{{ $multiChildAspect['points'][$key3]['id'] }}"
                                                        {{ isset($dataAspect['answers'][0]['evaluation']) && $dataAspect['answers'][0]['evaluation']['instrument_aspect_point_id'] == $multiChildAspect['points'][$key3]['id'] ? 'selected' : '' }}>
                                                        {{ $answer }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php $index = 'A'; @endphp
                                        @foreach ($multiChildAspect['points'] as $key3 => $point)
                                            <div class="col-md-9 mb-1 position-relative">
                                                @if (!empty($dataAspect['answers']))
                                                    <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                                    @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                        <input type="radio" disabled checked style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }} {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }} background-color: #313131; font-weight: bold; color: white;" disabled/>
                                                    @else
                                                        <input type="radio" disabled style="position: absolute;z-index:1000;top: 11px;left: 10px;">
                                                        <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }} {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($multiChildAspect['answers']) ? 'margin-top: -24px' : '' }};" disabled/>
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
                                <br><h5 style="margin-bottom: -10px;margin-top: -20px; white-space: pre;">{{ $aspectNo++.'. '.$dataAspect['aspect'] }}</h5><br>

                                <div class="evaluation position-absolute end-0" style="min-width:130px">
                                    <h5>Nilai Aspek</h5>
                                    <select name="evaluations[{{ $dataAspect['id'] }}]" required>
                                        <option value="">Select</option>
                                        @foreach (range('A', 'E') as $key3 => $answer)
                                            <option value="{{ $dataAspect['points'][$key3]['id'] }}"
                                                {{ isset($dataAspect['answers'][0]['evaluation']) && $dataAspect['answers'][0]['evaluation']['instrument_aspect_point_id'] == $dataAspect['points'][$key3]['id'] ? 'selected' : '' }}>
                                                {{ $answer }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @php $index = 'A'; @endphp
                                @foreach ($dataAspect['points'] as $key3 => $point)
                                    <div class="col-md-9 mb-1">
                                        @if (!empty($dataAspect['answers']))
                                            <input type="hidden" name="contents[{{ $dataAspect['id'] }}]" value="{{ $dataAspect['answers'][0]['id'] }}" />
                                            @if ($point['id'] == $dataAspect['answers'][0]['instrument_aspect_point_id'])
                                                <input type="radio" disabled checked style="position: relative;z-index:1000;top: 7px;left: 10px;">
                                                <x-forms.input name="opsi[{{ $key3 }}]" value="{{ $index }} {{ $point['statement'] }}" style="padding-left: 30px;{{ !empty($dataAspect['answers']) ? 'margin-top: -24px' : '' }}; background-color: #313131; font-weight: bold; color: white;" disabled/>
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
                @if(!empty($fetchData['links']['prev']))
                    <x-buttons.prev :href="route('admin.penilaian.evaluate', ['penilaian' => $id, 'page' => $fetchData['meta']['current_page'] - 1])"/>
                @endif
                <x-buttons.save :title="__($fetchData['links']['next'] ? 'Simpan' : 'Proses')"/>
            </div>
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
