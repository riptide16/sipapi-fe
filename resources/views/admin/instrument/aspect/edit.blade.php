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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.instrumen.index') }}" class="text-info">
                        All Instrument
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.instrumen.aspects.index', ['instrument' => $instrument]) }}" class="text-info">
                        All Instrument Aspect
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Show Instrument Aspect</li>
            </ol>
        </nav>
        <h2 class="h4">Show Data Instrument Aspect - {{ $fetchDataInstrument['data']['category'] }}</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.instrumen.aspects.update', ['aspect' => $fetchData['data']['id']]) }}" method="POST">
            <input type="hidden" value="{{ $instrument }}" name="intrumentID">
            @csrf
            @method('put')
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Komponen')"/>
                </div>
                <div class="col-md-9">
                    @if(
                        !empty($fetchData['data']['instrument_component']['parent']) &&
                        count($fetchData['data']['instrument_component']['parent']) > 0 &&
                        !empty($fetchData['data']['instrument_component']['parent']['parent']) &&
                        count($fetchData['data']['instrument_component']['parent']['parent']) > 0
                    )
                        <x-forms.select name="component_id" :items="$fetchDataComponent['data']" :fill="__($fetchData['data']['instrument_component']['parent']['parent']['id'])" :placeholder="__('Komponen')"/>
                    @elseif(
                        !empty($fetchData['data']['instrument_component']['parent']) &&
                        empty($fetchData['data']['instrument_component']['parent']['parent']) &&
                        count($fetchData['data']['instrument_component']['parent']) > 0
                    )
                        <x-forms.select name="component_id" :items="$fetchDataComponent['data']" :fill="__($fetchData['data']['instrument_component']['parent']['id'])" :placeholder="__('Komponen')"/>
                    @elseif(
                        empty($fetchData['data']['instrument_component']['parent']) &&
                        $fetchData['data']['type'] == 'main'
                    )
                        <x-forms.select name="component_id" :items="$fetchDataComponent['data']" :fill="__($fetchData['data']['instrument_component']['id'])" :placeholder="__('Komponen')"/>
                    @else
                        <x-forms.select name="component_id" :items="$fetchDataComponent['data']" :fill="__('')" :placeholder="__('Komponen')"/>
                    @endif
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Sub Komponen 1')"/>
                </div>
                <div class="col-md-9">
                        @if(
                            isset($fetchData['data']['instrument_component']['parent']) &&
                            count($fetchData['data']['instrument_component']['parent']) > 0 &&
                            isset($fetchData['data']['instrument_component']['parent']['parent']) &&
                            count($fetchData['data']['instrument_component']['parent']['parent']) > 0
                        )
                            <x-forms.select name="component_sub_first_id" :items="$fetchDataComponentSub1['data']" :fill="__($fetchData['data']['instrument_component']['parent']['id'])" :placeholder="__('Sub Komponen 1')"/>
                        @elseif(
                            isset($fetchData['data']['instrument_component']['parent']) &&
                            empty($fetchData['data']['instrument_component']['parent']['parent'])
                        )
                            <x-forms.select name="component_sub_first_id" :items="$fetchDataComponentSub1['data']" :fill="__($fetchData['data']['instrument_component']['id'])" :placeholder="__('Sub Komponen 1')"/>
                        @else
                            <x-forms.select name="component_sub_first_id" :items="$fetchDataComponentSub1['data']" :fill="__('')" :placeholder="__('Sub Komponen 1')" disabled/>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Sub Komponen 2')"/>
                </div>
                <div class="col-md-9">
                        @if(
                            !empty($fetchData['data']['instrument_component']['parent']) &&
                            count($fetchData['data']['instrument_component']['parent']) > 0 &&
                            !empty($fetchData['data']['instrument_component']['parent']['parent']) &&
                            count($fetchData['data']['instrument_component']['parent']['parent']) > 0
                        )
                        <x-forms.select name="component_sub_second_id" :items="$fetchDataComponentSub2['data']" :fill="__($fetchData['data']['instrument_component']['id'])" :placeholder="__('Sub Komponen 2')"/>
                        @else
                        <x-forms.select name="component_sub_second_id" :items="$fetchDataComponentSub2['data']" :fill="__('')" :placeholder="__('Sub Komponen 2')" disabled/>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Aspect')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="aspect" value="{{ $fetchData['data']['aspect'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Type')"/>
                </div>
                <div class="col-md-9">
                    <select name="type" id="type" class="form-control" required>
                        <option value="">{{ __('Select Type') }}</option>
                        <option value="choice" {{ $fetchData['data']['type'] == 'choice' ? 'selected' : '-' }}>{{ __('Choice') }}</option>
                        <option value="multi_aspect" {{ $fetchData['data']['type'] == 'multi_aspect' ? 'selected' : '-' }}>{{ __('Multi Aspects') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('No. Urut')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input type="number" min="0" name="order" value="{{ $fetchData['data']['order'] }}" required/>
                </div>
            </div>
            @if($fetchData['data']['type'] == 'choice')
            <div class="col-12 choice-0 {{ $fetchData['data']['type'] == 'choice' ? '' : 'd-none' }} mb-2">
                <div class="form-group mb-2">
                    <div class="col-md-3 required">
                        <x-forms.label :label="__('Opsi Jawaban')"/>
                    </div>
                </div>
                <div class="form-group">
                    @foreach ($fetchData['data']['points'] as $key => $item)
                        <div class="col-md-12 mb-2">
                            <x-forms.input name="opsi[{{ $key }}]" value="{{ $item['statement'] }}"/>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="row mb-2 btn-multi-aspect {{ $fetchData['data']['type'] == 'multi_aspect' ? '' : 'd-none' }} ">
                <div class="col-3">
                    <button type="button" class="btn btn-outline-primary add-field float-start" onclick="addAspect()">Tambah</button>
                    <button type="button" class="btn btn-outline-primary remove-field float-start mx-2" disabled onclick="removeWorker()">Hapus</button>
                </div>
            </div>
            <div class="col-12 cloneInput mb-2" id="entry0">
                @forelse ($fetchData['data']['children'] as $key => $item)
                    <div class="list-sub-aspect">
                        <div class="form-group sub-aspect-hide mb-2  {{ $fetchData['data']['type'] == 'multi_aspect' ? '' : 'd-none' }} ">
                            <div class="col-md-3 title">
                                Sub Aspect
                            </div>
                            <div class="col-md-9">
                                <x-forms.textarea name="sub_aspect[]" :item="__($item['aspect'])"/>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="col-md-3 required">
                                <x-forms.label :label="__('Opsi Jawaban')"/>
                            </div>
                        </div>
                        <div class="form-group">
                            @foreach ($item['points'] as $key2 => $item2)
                                <div class="col-md-12 mb-2">
                                    <x-forms.input name="opsi[]" value="{{ $item2['statement'] }}" placeholder="Jawaban A"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="col-12 cloneInput mb-2" id="entry0">
                        <div class="form-group sub-aspect-hide mb-2  {{ $fetchData['data']['type'] == 'multi_aspect' ? '' : 'd-none' }} ">
                            <div class="col-md-3 title">
                                Sub Aspect
                            </div>
                            <div class="col-md-9">
                                <x-forms.textarea name="sub_aspect[]" class="sub_aspect0"/>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="col-md-3 required">
                                <x-forms.label :label="__('Opsi Jawaban')"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-2">
                                <x-forms.input name="opsi[]" placeholder="Jawaban A"/>
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-forms.input name="opsi[]" placeholder="Jawaban B"/>
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-forms.input name="opsi[]" placeholder="Jawaban C"/>
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-forms.input name="opsi[]" placeholder="Jawaban D"/>
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-forms.input name="opsi[]" placeholder="Jawaban E"/>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="sub-aspect-next">

            </div>
            @endif
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Instrument')"/>
                    <x-buttons.cancel :href="route('admin.instrumen.aspects.index', ['instrument' => $instrument])"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            let componentId;
            let subComponentFirstId;
            let url = "{{ route('admin.instrumen.aspects.sub_components_aspects') }}";

            $('#component_id').change(function () {
                componentId = $(this).val();
                let urls = url + "?is_first=" + componentId;

                getSubComponent(urls, 'component_sub_first_id');

                if (componentId != "") {
                    $('#component_sub_first_id').prop('disabled', false);
                } else {
                    $('#component_sub_first_id').prop('disabled', 'disabled');
                    $('#component_sub_second_id').prop('disabled', 'disabled');
                }
            })

            $('#component_sub_first_id').change(function () {
                componentId = $('#component_id').val();
                subComponentFirstId = $(this).val();
                let urls = url + "?is_first=" + componentId +"&is_second="+subComponentFirstId;

                getSubComponent(urls, 'component_sub_second_id');

                if (subComponentFirstId != "") {
                    $('#component_sub_second_id').prop('disabled', false);
                } else {
                    $('#component_sub_second_id').prop('disabled', 'disabled');
                }
            })

            function getSubComponent(url= false, target='component_id') {
                jQuery.ajax({
                    method: 'GET',
                    dataType: 'json',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                }).done((result) => {
                    $('#'+target).empty();
                    $('#'+target).append('<option value="">-- Please Select --</option>');
                    $.each(result.data, function (key, value) {
                        $('#'+target).append('<option value="'+ value.id + '">'+ value.name + '</option>')
                    });
                }).fail(() => {
                    $('#'+target).append('<option value="999999">error</option>')
                })
            }

            $('#type').change(function () {
                if ($(this).val() == 'multi_aspect') {
                    $('.sub-aspect-hide').removeClass('d-none');
                    $('.btn-multi-aspect').removeClass('d-none');
                } else {
                    $('.sub-aspect-hide').addClass('d-none');
                    $('.btn-multi-aspect').addClass('d-none');
                }
            });

            $('.remove-field').click(function () {
                let num = $('.sub-aspect-next').length
                if (num > 0) {
                    if (num >= 1) {
                        $('#entry'+num).slideUp('slow', function () {$(this).remove();

                            if (num == 0) {
                                $('.remove-field').attr('disabled', true);
                            }
                        });
                    }
                }
            })
        })

        function addAspect() {
            let num = $('.clonedInput').length;
            let newNum = new Number(num + 1);
            let newElem = $("#entry"+num).clone().attr('id', 'entry'+newNum).fadeIn('slow')

            newElem.find('.aspect').attr('id', 'sub_aspect'+newNum).attr('name', 'sub_aspect['+newNum+']').val('')
            $('#entry'+num).after(newElem);
            $('.remove-field').attr('disabled', false);
        }
    </script>
@endpush
