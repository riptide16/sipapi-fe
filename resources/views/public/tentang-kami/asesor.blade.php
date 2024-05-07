@extends('layouts.public')

@section('content')
    @if (!empty($assessors['data']))
        <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5">
            @foreach ($assessors['data'] as $item)
                <div class="rounded overflow-hidden shadow-lg">
                    <a href="{{ route('tentang-kami.asesor.show', ['id' => $item['id']]) }}">
                        <img class="w-full h-5/6 object-cover" src="{{ !empty($item['profile_picture']) ? $item['profile_picture'] : asset('images/no-photo.png') }}">
                        <div class="px-6 py-4">
                            <div class="font-bold text-sm text-center mb-2">
                                {{ strtoupper($item['name']) }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
            <div class="flex items-center space-x-1">
                <a href="{{ route('tentang-kami.asesor', ['page' => $assessors['meta']['from'] - 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                    Previous
                </a>
                <a href="{{ $assessors['meta']['last_page'] == $currentPage ? route('tentang-kami.asesor', ['page' => 1]) : route('tentang-kami.asesor', ['page' => $assessors['meta']['from'] + 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                    Next
                </a>
            </div>
        </div>
    @endif
@endsection
