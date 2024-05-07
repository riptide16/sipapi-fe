@extends('layouts.public')

@push('css')
    <style>
        .custom-page p, h2 {
            margin: revert !important;
        }

        .custom-page h1, h2, h3, h4, h5, h6 {
            font-size: revert !important;
            font-weight: revert !important;
        }
    </style>
@endpush

@section('content')
<div class="margin-100 p-10 custom-page">
    {!! $pages['data']['body'] !!}
</div>
@endsection
