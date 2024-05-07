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
                    <a href="{{ route('admin.instrumen.index') }}" class="text-info">
                        All Instrumen
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.instrumen.aspects.index', ['instrument' => $instrument]) }}" class="text-info">
                        All Instrument Aspect
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Instrument Aspect</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Instrumen - {{ $fetchDataInstrument['data']['category'] }}</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.instrumen.aspects.store') }}" method="POST">
            <input type="hidden" value="{{ $instrument }}" name="intrumentID">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Komponen')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select name="component_id" :items="$fetchDataComponent['data']" :fill="__('')" :placeholder="__('Komponen')"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Sub Komponen 1')"/>
                </div>
                <div class="col-md-9">
                    <select name="component_sub_first_id" class="form-control" id="component_sub_first_id" disabled></select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Sub Komponen 2')"/>
                </div>
                <div class="col-md-9">
                    <select name="component_sub_second_id" class="form-control" id="component_sub_second_id" disabled></select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Aspect')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.textarea name="aspect" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Type')"/>
                </div>
                <div class="col-md-9">
                    <select name="type" id="type" class="form-control" required>
                        <option value="">{{ __('Select Type') }}</option>
                        <option value="choice">{{ __('Choice') }}</option>
                        <option value="multi_aspect">{{ __('Multi Aspects') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('No. Urut')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input type="number" name="order" min="0" required/>
                </div>
            </div>
            <div class="row mb-2 btn-multi-aspect d-none">
                <div class="col-3">
                    <button type="button" class="btn btn-outline-primary add-field float-start" onclick="addAspect()">Tambah</button>
                    <button type="button" class="btn btn-outline-primary remove-field float-start mx-2" disabled>Hapus</button>
                </div>
            </div>
            <div class="col-12 cloneInput mb-2" id="entry0">
                <div class="form-group sub-aspect-hide mb-2 d-none">
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
                    <div class="col-md-12 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Jawaban A"/>
                    </div>
                    <div class="col-md-12 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Jawaban B"/>
                    </div>
                    <div class="col-md-12 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Jawaban C"/>
                    </div>
                    <div class="col-md-12 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Jawaban D"/>
                    </div>
                    <div class="col-md-12 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Jawaban E"/>
                    </div>
                </div>
            </div>
            <div class="sub-aspect-next">

            </div>
            
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

            $('#type').change(function () {
                if ($(this).val() == 'multi_aspect') {
                    $('.sub-aspect-hide').removeClass('d-none');
                    $('.btn-multi-aspect').removeClass('d-none');
                } else {
                    $('.sub-aspect-hide').addClass('d-none');
                    $('.btn-multi-aspect').addClass('d-none');
                }
            });

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
            console.log(newNum)
            let newElem = $("#entry"+num).clone().attr('id', 'entry'+newNum).fadeIn('slow')

            newElem.find('.aspect').attr('id', 'sub_aspect'+newNum).attr('name', 'sub_aspect['+newNum+']').val('')
            $('#entry'+num).after(newElem);
            $('.remove-field').attr('disabled', false);
        }
    </script>
@endpush
