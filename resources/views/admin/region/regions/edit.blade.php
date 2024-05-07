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
                    <a href="{{ route('admin.master_data.regions.index') }}" class="text-info">
                        All Wilayah
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Input Wilayah</li>
            </ol>
        </nav>
        <h2 class="h4">Update Data Wilayah</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.master_data.regions.update', ['region' => $wilayah['id']]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Wilayah')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="name" id="name" value="{{ $wilayah['name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Provinsi')"/>
                </div>
                <div class="col-md-9">
                    <select class="form-control provinsi-tag" multiple="multiple" name="province_ids[]" required>
                        <option value=""></option>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($provinces['data'] as $key => $item)
                            <option value="{{ $item['id'] }}" {{ in_array($item['id'], $arrayProvinces) ? 'selected' : '' }}>{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                </div>                
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update Wilayah')"/>
                    <x-buttons.cancel :href="route('admin.master_data.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $(".provinsi-tag").select2({
                tags: true
            });
        });
    </script>
@endpush
