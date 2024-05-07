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
                <li class="breadcrumb-item active" aria-current="page">View Kota</li>
            </ol>
        </nav>
        <h2 class="h4">View Data Kota</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Province :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$city['province']['name']"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Name :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$city['name']"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <x-buttons.back :href="route('admin.master_data.index')"/>
            </div>
        </div>
    </div>
</div>
@endsection