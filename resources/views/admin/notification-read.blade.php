@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
      <div class="lh-1">
        <h1 class="h6 mb-0 text-white lh-1">Notification</h1>
      </div>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm" style="background: #FFF !important">
        <h6 class="border-bottom pb-2 mb-0">{{ $fetchData['data']['content']['title'] }}</h6>
        <p class="col-md-12 mt-2">
            {{ $fetchData['data']['content']['body'] }}
        </p>

        <div class="mb-5 d-flex justify-content-center">
            @if ($fetchData['data']['type'] == 'App\\Notifications\\AcceptAccreditationEvaluation')
                <a href="{{ route('admin.akreditasi.accept.process', ['id' => $fetchData['data']['content']['accreditation_id'], 'accept' => 0]) }}" class="btn btn-success btn-sm px-4" style="color: #FFF">Banding</a>&nbsp;
                <a href="{{ route('admin.akreditasi.accept.process', ['id' => $fetchData['data']['content']['accreditation_id'], 'accept' => 1]) }}" class="btn btn-info btn-sm px-4">Terima</a>
            @elseif (!empty($fetchData['data']['content']['target_url']))
                <a href="{{ $fetchData['data']['content']['target_url'] }}" class="btn btn-info btn-sm px-4">Pergi Kehalaman</a>
            @endif
        </div>
    </div>
</div>
@endsection
