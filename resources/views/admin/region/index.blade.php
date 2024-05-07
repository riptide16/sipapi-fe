@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Master Data</li>
            </ol>
        </nav>
        <h2 class="h4">Master Data</h2>
    </div>
    
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        @include('admin.region.table', ['regions' => $regions, 'masterData' => $masterData, 'default' => 'regions'])
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('admin/js/data-table-country.js') }}"></script>
    <script>
        $(function () {
            let session = "{{ session()->get('section.0')}}";
            if (session != "") {
                $('#pills-'+session+'-tab').trigger('click');
            }
        })
    </script>
@endpush