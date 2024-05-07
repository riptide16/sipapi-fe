@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
      <div class="lh-1">
        <h1 class="h6 mb-0 text-white lh-1">Notification</h1>
      </div>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm" style="background: #FFF !important">
      <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
        @foreach (session('allNotifications')['data'] as $item)
            @if (!empty($item['content']['title']))
                <a href="{{ route('admin.notification.show', ['id' => $item['id']]) }}">
                    <div class="d-flex text-muted pt-3">
                        <p class="pb-3 mb-0 small lh-sm border-bottom">
                        <strong class="d-block text-gray-dark">{{ $item['content']['title'] }}</strong>
                        {{ $item['content']['body'] }}
                        </p>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</div>
@endsection
