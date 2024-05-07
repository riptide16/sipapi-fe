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
                <li class="breadcrumb-item active" aria-current="page">Nilai Hasil Self Assessment</li>
            </ol>
        </nav>
        <h2 class="h4">Nilai Hasil Self Assessment</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <div class="row">
                <div class="col-md-3">
                    <x-forms.label :label="__('Hasil :')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$result['data']['predicate'] ?? '-'"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection
