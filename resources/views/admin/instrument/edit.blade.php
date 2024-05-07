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
                        All Instrument
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Instrument</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Instrument</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.instrumen.store') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $instrument }}" name="instrumentID">
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Komponen')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select name="component_id" :items="$fetchDataComponent['data']" :fill="__('')" :placeholder="__('Komponen')"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Sub Komponen 1')"/>
                </div>
                <div class="col-md-9">
                    <select name="component_sub_first_id" class="form-control" id="component_sub_first_id" disabled></select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Sub Komponen 1')"/>
                </div>
                <div class="col-md-9">
                    <select name="component_sub_second_id" class="form-control" id="component_sub_second_id" disabled></select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Aspect')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.textarea name="aspect"/>
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
                        <option value="proof">{{ __('Proof') }}</option>
                        <option value="both">{{ __('Both') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Order')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input type="number" name="order" min="0" required/>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-2">
                    <div class="col-md-3 required">
                        <x-forms.label :label="__('Opsi Jawaban')"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Opsi 1" required/>
                    </div>
                    <div class="col-md-6 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Opsi 2" required/>
                    </div>
                    <div class="col-md-6 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Opsi 3" required/>
                    </div>
                    <div class="col-md-6 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Opsi 4" required/>
                    </div>
                    <div class="col-md-6 mb-2">
                        <x-forms.input name="opsi[]" placeholder="Opsi 5" required/>
                    </div>
                </div>
            @endif
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Order')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="order" value="{{ $instrument['order'] }}" required/>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Instrument')"/>
                    <x-buttons.cancel :href="route('admin.instrumen.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            let componentId = ;
            let subComponentFirstId;
            let url = "{{ route('admin.instruments.sub_component') }}";

            $('#component_id').change(function () {
                componentId = $(this).val();
                url = url + "?is_first=" + componentId;

                getSubComponent(url, 'component_sub_first_id');

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
                url = url + "?is_first=" + componentId +"&is_second="+subComponentFirstId;

                getSubComponent(url, 'component_sub_second_id');

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
                        $('#'+target).append('<option value="'+ key + '">'+ value + '</option>')
                    });
                }).fail(() => {
                    $('#'+target).append('<option value="999999">error</option>')
                })
            }
        })
    </script>
@endpush