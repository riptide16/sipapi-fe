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
                    <a href="{{ route('admin.master_data.index') }}" class="text-info">
                        Master Data
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Kecamatan</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Kecamatan</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.master_data.subdistricts.store') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Provinsi')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-province :placeholder="__('Provinsi')" :fill="__('')" name="province_id" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kota/Kabupaten')"/>
                </div>
                <div class="col-md-9">
                    <select name="city_id" class="form-control" id="city_id" required>
                        <option value="">-- Select Kota/kabupaten --</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Name')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" required/>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Kecamatan')"/>
                    <x-buttons.cancel :href="route('admin.master_data.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            font-size: 0.875rem;
            padding: 0.5rem 1rem 0.5rem 1rem;
            display: block;
            line-height: 1.5;
            height: 40px;
            width: 100%
        }
    </style>
@endpush

@push('js')
    <script>
        function getLocation(url = false, target = 'province_id') {
            jQuery.ajax({
                type: 'GET',
                dataType : 'json',
                url: url,
                headers : {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }).done((result) => {
                $('#'+target).empty()
                $('#'+target).append('<option value="">-- Please Select --</option>')
                $.each(result.data, function (key, value) {
                    $('#'+target).append('<option value="'+ value.id + '">'+ value.name + '</option>')
                });
            }).fail(() => {
                $('#'+target).append('<option value="999999">error</option>')
            });
        }
        $(function () {
            $('#city_id').select2();
            $('#province_id').change(function () {
                let provinceId = $(this).val();
                url = "{{ route('admin.master_data.get_location') }}?province_id="+provinceId;

                getLocation(url, 'city_id');

                if (provinceId != "") {
                    $('#city_id').prop('disabled', false);   
                } else {
                    $('#city_id').prop('disabled', 'disabled');
                }
            })
        })
    </script>
@endpush