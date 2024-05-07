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
                    <a href="{{ route('admin.log.index') }}" class="text-info">
                        All Log
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">View Log</li>
            </ol>
        </nav>
        <h2 class="h4">View Data Log</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Name :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data']['causer']['name'] ?? __('-')"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('IP :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data']['ip_address'] ?? __('-')"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('User Agent :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data']['user_agent'] ?? __('-')"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Aksi :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data']['description'] ?? __('-')"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Modul :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$fetchData['data']['subject_type'] ?? __('-')"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Tanggal :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="Carbon\Carbon::parse($fetchData['data']['created_at'])->setTimezone('Asia/Jakarta')"/>
            </div>
        </div>
        @forelse($fetchData['data']['changes'] as $key => $item)
            @if ($fetchData['data']['description'] == 'created')
                <div class="form-group mb-2">
                    <h5>Data :</h5>
                </div>
                @foreach($item as $key2 => $item2)
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__($key2.' :')"/>
                    </div>
                    <div class="col-md-9">
                        <x-forms.label :label="__($item2)"/>
                    </div>
                </div>
                @endforeach
            @elseif($fetchData['data']['description'] == 'updated')
                @if ($key == 'old')
                    <div class="form-group mb-2">
                        <h5>Old Data :</h5>
                    </div>
                    @foreach($item as $key2 => $item2)
                        <div class="form-group row mb-2">
                            <div class="col-md-3">
                                <x-forms.label :label="__($key2.' :')"/>
                            </div>
                            <div class="col-md-9">
                                <x-forms.label :label="__($item2)"/>
                            </div>
                        </div>
                    @endforeach
                @elseif($key == 'attributes')
                    <div class="form-group mb-2">
                        <h5>Change Data :</h5>
                    </div>
                    @foreach($item as $key2 => $item2)
                        <div class="form-group row mb-2">
                            <div class="col-md-3">
                                <x-forms.label :label="__($key2 .' :')"/>
                            </div>
                            <div class="col-md-9">
                                <x-forms.label :label="__($item2)"/>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        @empty
        @endforelse
        <div class="form-group">
            <div class="col-md-12">
                <x-buttons.back :href="route('admin.log.index')"/>
            </div>
        </div>
    </div>
</div>
@endsection
