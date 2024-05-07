@extends('layouts.public')

@section('content')
    @if (!empty($news['data']))
        <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5">
            @foreach ($news['data'] as $item)
                <div class="rounded overflow-hidden shadow-lg">
                    <img class="w-full headline-news-media object-cover" src="{{ $item['image'] }}">
                    <a href="{{ route('media.berita.show', ['id' => $item['id']]) }}">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">
                                {{ $item['title'] }}
                            </div>
                            <p class="text-gray-700 text-base">{{ \Carbon\Carbon::parse($item['published_date'])->diffForHumans() }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
            <div class="flex items-center space-x-1">
                <a href="{{ route('media.berita.index', ['page' => $news['meta']['from'] - 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                    Previous
                </a>
                <a href="{{ $news['meta']['last_page'] == $news['meta']['from'] ? route('media.berita.index', ['page' => 1]) : route('media.berita.index', ['page' => $news['meta']['from'] + 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                    Next
                </a>
            </div>
        </div>
    @endif
@endsection
