@extends('layouts.public')

@section('content')
<div class="bg-gradient-to-r from-yellow-200 to-green-400">
    <div class="flex items-center justify-center h-auto p-5">
        <div class="container">
            <div class="flex justify-center">
                <div class="margin-100 bg-white shadow-xl rounded-lg w-full">
                    <ul class="divide-y divide-gray-300">
                        @foreach ($files['data'] as $item)
                        <li class="p-4 hover:bg-gray-50 cursor-pointer">
                            <a href="{{ $item['attachment'] }}">Download File {{ $item['filename'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5 bg-transparent">
        <div class="flex items-center space-x-1">
            <a href="{{ route('layanan.unduh.index', ['page' => $files['meta']['current_page'] - 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                Previous
            </a>
            <a href="{{ $files['meta']['last_page'] == $files['meta']['current_page'] ? route('layanan.unduh.index', ['page' => 1]) : route('layanan.unduh.index', ['page' => $files['meta']['current_page'] + 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                Next
            </a>
        </div>
    </div>
</div>
@endsection