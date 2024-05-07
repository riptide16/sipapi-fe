@extends('layouts.public')

@section('content')
<div class="mb-20 mt-10 md:mb-0 w-full max-w-screen-md mx-auto relative" style="height: 30em;">
    <div class="p-5 text-center h-full">
        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $video['data']['youtube_id'] }}?rel=0&autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; allowfullscreen" allowfullscreen></iframe>
    </div>
</div>
@endsection