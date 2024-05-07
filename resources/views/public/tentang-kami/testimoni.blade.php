@extends('layouts.public')

@section('content')
<div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-5">
    @foreach ($testimonies['data'] as $item)
        @if ($loop->iteration % 2 == 0)
            <div class="w-full flex justify-center">
                <div class="flex flex-col md:flex-row rounded-lg bg-white border mb-10">
                    <img class="w-full h-96 md:h-auto object-cover md:w-48 rounded-t-lg md:rounded-none md:rounded-l-lg" src="{{ $item['photo'] }}" />
                    <div class="p-6 flex flex-col justify-start">
                        <h5 class="text-gray-900 text-xl font-medium mb-2">{{ $item['name'] }}</h5>
                        <p class="text-gray-700 text-base mb-4">
                            {!! $item['content'] !!}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="w-full flex justify-center">
                <div class="flex flex-col md:flex-row rounded-lg bg-white border mb-10">
                    <div class="p-6 flex flex-col justify-start">
                        <h5 class="text-gray-900 text-xl font-medium mb-2">{{ $item['name'] }}</h5>
                        <p class="text-gray-700 text-base mb-4">
                            {!! $item['content'] !!}
                        </p>
                    </div>
                    <img class="w-full h-96 md:h-auto object-cover md:w-48 rounded-t-lg md:rounded-none md:rounded-r-lg" src="{{ $item['photo'] }}" />
                </div>
            </div>
        @endif
    @endforeach
</div>
<div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
    <div class="flex items-center space-x-1">
        <a href="{{ route('tentang-kami.testimoni', ['page' => $testimonies['meta']['from'] - 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
            Previous
        </a>
        <a href="{{ $testimonies['meta']['last_page'] == $testimonies['meta']['from'] ? route('tentang-kami.testimoni', ['page' => 1]) : route('tentang-kami.testimoni', ['page' => $testimonies['meta']['from'] + 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
            Next
        </a>
    </div>
</div>

@endsection
