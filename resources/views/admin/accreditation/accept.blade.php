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
                    <a href="{{ route('admin.akreditasi.index') }}" class="text-info">
                        All Akreditasi
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">View Akreditasi</li>
            </ol>
        </nav>
        <h2 class="h4">View Data Akreditasi</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <h2>Pengajuan Akreditasi No. {{ $fetchData['data']['code'] }} - Selesai</h2>
        <small>{{ Carbon\Carbon::now()->diffInMinutes(Carbon\Carbon::parse($fetchData['data']['accredited_at'])->addSeconds(60)) }} mins ago</small>

        <p>{{ $fetchData['data']['notes'] }}</p>

        <center>
            <b><p>Akreditasi</p> <h4>{{ $fetchData['data']['predicate'] }}</h4></b>

            <div class="form-group row">
                <div class="d-flex justify-content-center">
                    <div class="col-md-2">
                        <x-buttons.save :href="route('admin.akreditasi.accept.process', ['id' => $id, 'accept' => true])" :title="__('Terima')"/>
                    </div>
                    <div class="col-md-2">
                        <x-buttons.cancel :href="route('admin.akreditasi.accept.process', ['id' => $id, 'accept' => false])" :title="__('Banding')"/>
                    </div>
                </div>
            </div>
        </center>
    </div>
</div>
@endsection