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
        <h2 class="h4">Show Data Instrument Aspect</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="" method="POST">
            <input type="hidden" value="{{ $instrument }}" name="intrumentID">
            @csrf
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
                        <x-forms.label class="text-info" :label="$fetchData['data']['instrument_component']['parent']['parent']['name']"/>
                    @elseif(
                        !empty($fetchData['data']['instrument_component']['parent']) &&
                        empty($fetchData['data']['instrument_component']['parent']['parent']) &&
                        count($fetchData['data']['instrument_component']['parent']) > 0
                    )
                        <x-forms.label class="text-info" :label="$fetchData['data']['instrument_component']['parent']['name']"/>
                    @elseif(
                        empty($fetchData['data']['instrument_component']['parent']) &&
                        $fetchData['data']['type'] == 'main'
                    )
                        <x-forms.label class="text-info" :label="$fetchData['data']['instrument_component']['name']"/>
                    @else
                        <x-forms.select name="component_id" :items="$fetchDataComponent['data']" :fill="__('')" :placeholder="__('Komponen')" disabled/>
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
                            <x-forms.label class="text-info" :label="$fetchData['data']['instrument_component']['parent']['name']"/>
                        @elseif(
                            isset($fetchData['data']['instrument_component']['parent']) &&
                            empty($fetchData['data']['instrument_component']['parent']['parent'])
                        )
                            <x-forms.label class="text-info" :label="$fetchData['data']['instrument_component']['name']"/>
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
                            <x-forms.label class="text-info" :label="$fetchData['data']['instrument_component']['name']"/>
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
                    <x-forms.label class="text-info" :label="__($fetchData['data']['aspect'])"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Type')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="__($fetchData['data']['type'])"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('No. Urut')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$fetchData['data']['order']"/>
                </div>
            </div>
            <div class="col-12 mb-2">
                @if($fetchData['data']['type'] == 'choice')
                <div class="form-group mb-2">
                    <div class="col-md-3 required">
                        <x-forms.label :label="__('Opsi Jawaban')"/>
                    </div>
                </div>
                <div class="form-group">
                    @foreach ($fetchData['data']['points'] as $key => $item)
                        <div class="col-md-12 mb-2">
                            <x-forms.label class="text-info" :label="$item['statement']"/>
                        </div>
                    @endforeach
                </div>
                @else
                    @foreach($fetchData['data']['children'] as $key => $item)
                        <div class="form-group row mb-2 required">
                            <x-forms.label :label="__('Sub Aspect')"/>
                        </div>
                        <div class="form-group mb-2">
                            <x-forms.label class="text-info" :label="$item['aspect']"/>
                        </div>
                        <div class="form-group mb-2">
                            <div class="col-md-3 required">
                                <x-forms.label :label="__('Opsi Jawaban')"/>
                            </div>
                        </div>
                        <div class="form-group">
                            @foreach ($item['points'] as $key2 => $point)
                                <div class="col-md-6 mb-2">
                                    <x-forms.label class="text-info" :label="$point['statement']"/>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.cancel :href="route('admin.instrumen.aspects.index', ['instrument' => $instrument])"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
