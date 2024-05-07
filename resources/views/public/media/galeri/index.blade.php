@extends('layouts.public')

@section('content')
<section class="text-gray-600 body-font">
    <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5">
        @foreach ($albums['data'] as $key => $item)
            <a href="{{ route('media.galeri.album', ['slug' => $item['slug']]) }}">
                <div class="rounded overflow-hidden shadow-lg">
                    <img class="w-full h-52 object-cover" src="{{ $item['galleries'][0]['image'] }}">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">
                            <p class="text-center">
                                {{ $item['name'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
        <div class="flex items-center space-x-1">
            <a href="{{ route('media.galeri.index', ['page' => $albums['meta']['from'] - 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                Previous
            </a>
            <a href="{{ $albums['meta']['last_page'] == $albums['meta']['from'] ? route('media.galeri.index', ['page' => 1]) : route('media.galeri.index', ['page' => $albums['meta']['from'] + 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                Next
            </a>
        </div>
    </div>
</section>
@endsection
