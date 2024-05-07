@extends('layouts.public')

@push('css')
    <style>
        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        #myImg:hover {opacity: 0.7;}
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }
        /* Modal Content (Image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }
        /* Caption of Modal Image (Image Text) - Same Width as the Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }
        /* Add Animation - Zoom in the Modal */
        .modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }
        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-5">
    @foreach ($galleries['data'] as $key => $item)
        <div class="rounded overflow-hidden shadow-lg">
            <img class="w-full h-52 object-cover myImages" alt="{{ $item['caption'] }}" src="{{ $item['image'] }}" style="cursor: pointer">
            <div class="px-6 py-4">
                <div class="font-bold text-16 mb-2" style="line-height: 18px;">
                    {{ $item['title'] }}
                </div>
                <p class="text-gray-700 text-12" style="line-height: 12px;">
                    {{ $item['caption'] }}
                </p>
            </div>
        </div>
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
    @endforeach
</div>
<div class="margin-100 p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
    <div class="flex items-center space-x-1">
        <a href="{{ route('media.galeri.album', ['slug' => $slug, 'page' => $galleries['meta']['from'] - 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
            Previous
        </a>
        <a href="{{ $galleries['meta']['last_page'] == $galleries['meta']['from'] ? route('media.galeri.album', ['slug' => $slug, 'page' => 1]) : route('media.galeri.album', ['slug' => $slug, 'page' => $galleries['meta']['from'] + 1]) }}" class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400 hover:text-white">
            Next
        </a>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            var count = {{ count($galleries['data']) }};
            var modal = document.getElementById("myModal");
            var images = document.getElementsByClassName("myImages");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            var span = document.getElementsByClassName("close")[0];
            span.onclick = function() {
                modal.style.display = "none";
            }
            for (i=0;i <= count;i++) {
                var img = images[i];
                img.onclick = function(){
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;
                }
            }
        });
    </script>
@endpush
