@extends('layouts.public')

@section('content')
    @if (!empty($videos['data']))
        <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5">
            @foreach ($videos['data'] as $key => $item)
                <!-- modal div -->
                <div class="mt-6" x-data="{ open: false }">
                    <div class="rounded overflow-hidden shadow-lg">
                        <img src="https://img.youtube.com/vi/{{ $item['youtube_id'] }}/hqdefault.jpg" class="w-full" data-id="{{$key}}" @click="open = true" style="cursor: pointer">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">
                                <p class="text-sm">
                                    {{ $item['title'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dialog (full screen) -->
                    <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full" style="background-color: rgba(0,0,0,.5);position: fixed;" x-show="open"  >
                    <!-- A basic modal dialog with title, body and one button to close -->
                    <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:w-max md:h-5/6 md:p-6 lg:p-8 md:mx-0" @click.away="open = false">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            {{$item['title']}}
                        </h3>

                        <div class="mt-2">
                            <iframe class="h-96" width="100%" height="100%" src="https://www.youtube.com/embed/{{ $item['youtube_id'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <!-- One big close button.  --->
                    <div class="mt-5 sm:mt-6">
                    <span class="flex w-full rounded-md shadow-sm">
                        <button @click="open = false" class="inline-flex justify-center w-full px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
                        Close Video
                        </button>
                    </span>
                    </div>
                </div>
                </div>
            </div>

            @endforeach
        </div>
        <div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
            <div class="flex items-center space-x-1">
                <a href="{{ route('media.video.index', ['page' => $videos['meta']['from'] - 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                    Previous
                </a>
                <a href="{{ $videos['meta']['last_page'] == $currentPage ? route('media.video.index', ['page' => 1]) : route('media.video.index', ['page' => $videos['meta']['from'] + 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
                    Next
                </a>
            </div>
        </div>
    @endif
@endsection
