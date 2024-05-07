@extends('layouts.public')

@section('content')
<div class="mx-auto px-5">
    <div class="margin-100">
        <div class="mb-4 mt-10 md:mb-0 w-full relative" style="height: 24em;">
            <div class="absolute left-0 bottom-0 w-full h-full z-10" style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div><img class="absolute left-0 top-0 w-full h-full z-0 object-cover" src="{{ $news['data']['image'] }}">
            <div class="p-4 absolute bottom-0 left-0 z-20">
                <h2 class="text-4xl font-semibold text-gray-100 leading-tight">{{ $news['data']['title'] }}</h2>
            </div>
        </div>
        <div class="mb-10 px-4 lg:px-0 mt-12 text-gray-700 mx-auto text-lg leading-relaxed">
            {!! $news['data']['body'] !!}
        </div>
    </div>
</div>
@endsection
