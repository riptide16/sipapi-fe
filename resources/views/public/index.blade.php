@extends('layouts.public')

@push('css')
	<style>
		#banner-carousel .item{
			cursor:grab;
			cursor:-webkit-grab;
		}
		/* Styling Pagination*/
		.owl-theme .owl-controls .owl-page span{
			-webkit-border-radius: 0;
			-moz-border-radius: 0;
			border-radius: 0;
			width: 100px;
			height: 5px;
			margin-left: 2px;
			margin-right: 2px;
			background: #ccc;
			border:none;
		}
		.owl-theme .owl-controls .owl-page.active span,
		.owl-theme .owl-controls.clickable .owl-page:hover span{
			background: #3F51B5;
		}
        /* .headline-news {
            min-height: 100%;
            background-size: cover;
            background-position: center;
            object-fit: cover;
            object-position: center;
            width: 100%;
        } */
        .highcharts-background {
            width: auto !important;
        }
        .highcharts-legend-item {
            display: none;
        }
        .owl-dots {
            display: none;
        }
        @media only screen and (min-width: 900px) {
            #banner-carousel .item img {
                display: block;
                width: 100%;
                min-height: 445px;
                height: 100%;
                background-size: cover;
                background-position: center center;
            }
            .bg-green-info {
                background-color: #06732A;
            }
        }
        @media only screen and (max-width: 900px) {
            #banner-carousel .item img {
                width: 100%;
                height: 100%;
            }
            .owl-prev {
                display: none;
            }
            .owl-next {
                display: none;
            }
        }
	</style>
@endpush

@section('content')
<div id="banner-carousel" class="owl-carousel owl-theme">
	@foreach ($banners['data'] as $item)
		<div class="item">
			<img class="object-cover" src="{{ $item['image'] }}" alt="Banner"/>
		</div>
	@endforeach
</div>

@if (!empty($news['data']))
<div class="mx-auto px-5 lg:px-0 mt-10 h-full">
    <div class="margin-100">
        <div class="flex justify-between">
            <div>
                <h6 class="lg:text-3xl mb-10 ml-4 text-green-600">Berita Terbaru</h6>
            </div>
            <div>
                <h6 class="lg:text-2xl mb-10 ml-1 text-green-600 mr-5">
                    <a href="{{ route('media.berita.index') }}" aria-label="News">
                        Lihat Semua
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </h6>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-2 grid-flow-row">
            <div class="p-5 text-center col-span-2 w-fit hidden md:hidden lg:block">
                <a href="{{ route('media.berita.show', ['id' => $news['data'][0]['id']]) }}" aria-label="News">
                    <div class="max-w overflow-hidden h-full hidden md:hidden lg:block" style="margin-top: -15px;">
                        <img class="w-full object-cover rounded headline-news" src="{{ $news['data'][0]['image'] }}" alt="Image News">
                        <p class="text-gray-700 text-base" style="position: relative;top: -100px;color: #FFF;">
                            {{ $news['data'][0]['title'] }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="w-full lg:w-full mt-1 lg:block">
                @foreach (collect($news['data'])->slice(1)->all() as $item)
                    <div class="w-full mb-10">
                        <div class="flex flex-col lg:flex-row overflow-hidden h-auto lg:h-full">
                            <img class="block h-auto rounded w-full object-cover lg:w-52 flex-none bg-cover h-24 headline-news-side" src="{{ $item['image'] }}" alt="Image News">
                            <a href="{{ route('media.berita.show', ['id' => $item['id']]) }}" aria-label="News">
                                <div class="bg-white rounded-b lg:rounded-b-none lg:rounded-r md:pt-1 lg:pt-1 p-4 flex flex-col justify-between leading-normal">
                                    <div class="text-black font-bold text-xl leading-tight mb-2">
                                        <p class="text-xs">{{ $item['title'] }}</p>
                                    </div>
                                    <p class="text-grey-darker text-xs">{{ \Carbon\Carbon::parse($item['published_date'])->diffForHumans() }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<div class="md:block mx-auto h-max px-5 mb-10" style="background-image: url('{{ asset('images/Infografis_Background.png') }}');background-size: cover;">
	<div class="margin-100">
        <div class="flex justify-between">
            <div class="mt-10">
                <h6 class="lg:text-3xl mb-10 text-green-600">Infografis</h6>
            </div>
        </div>
        <div class="container mx-auto py-4 px-5 flex flex-wrap flex-col sm:flex-row justify-center bg-transparent bg-green-info md:mb-10 lg:mb-10 md:shadow-md lg:shadow-md md:rounded-md lg:rounded-md">
            <div id="infographics" class="hidden md:block" style="width: 900px; height: 400px;"></div>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 md:grid-cols-4 gap-4">
            <div class="shadow-md rounded-md bg-white w-full">
                <div class="p-5">
                    <h5 style="text-align: center;" class="text-xl font-semibold mb-2 text-green-500">
                        {{-- <span class="countfect" data-num="{{ $infographics['library'] }}"></span> --}}
                        22
                    </h5>
                    <p style="text-align: center;" class="mb-4 text-green-500 text-lg">Perpustakaan Terdaftar</p>
                </div>
            </div>
            <div class="shadow-md rounded-md bg-white w-full">
                <div class="p-5">
                    <h5 style="text-align: center;" class="text-xl font-semibold mb-2 text-green-500">
                        {{-- <span class="countfect" data-num="{{ $infographics['accreditationLibrary'] }}"></span> --}}
                        4
                    </h5>
                    <p style="text-align: center;" class="mb-4 text-green-500 text-lg">Perpustakaan Terakreditasi</p>
                </div>
            </div>
            <div class="shadow-md rounded-md bg-white w-full">
                <div class="p-5">
                    <h5 style="text-align: center;" class="text-xl font-semibold mb-2 text-green-500">
                        {{-- <span class="countfect" data-num="{{ $infographics['assessor'] }}"></span> --}}
                        18
                    </h5>
                    <p style="text-align: center;" class="mb-4 text-green-500 text-lg">Asesor</p>
                </div>
            </div>
            <div class="shadow-md rounded-md bg-white w-full">
                <div class="p-5">
                    <h5 style="text-align: center;" class="text-xl font-semibold mb-2 text-green-500">
                        {{-- <span class="countfect" data-num="{{ $infographics['predicateA'] }}"></span> --}}
                        5
                    </h5>
                    <p style="text-align: center;" class="mb-4 text-green-500 text-lg">Predikat A</p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10 h-10"></div>
</div>


@if (!empty($videos['data']))
<div class="mx-auto px-5 mt-20 h-full bg-gray-200">
	<div class="margin-100">
        <div class="flex justify-between">
            <div class="mt-10">
                <h6 class="lg:text-3xl mb-10 ml-1 text-green-600">Video</h6>
            </div>
            <div class="mt-10">
                <h6 class="lg:text-2xl mb-10 ml-4 text-green-600">
                    <a href="{{ route('media.video.index') }}" aria-label="Youtube">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </h6>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center w-full h-3/6">
            <div class="flex-1 container px-1 rounded shadow shadow-lg" style="background-color: #585656;">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-2 grid-flow-row">
                    <div class="p-1 hidden md:block text-center col-span-4 h-full relative">
                        <div class="p-5 text-center h-full">
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videos['data'][0]['youtube_id'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="p-5 px-5 text-center">
                        @foreach ($videos['data'] as $item)
                            <div class="p-1 text-center lg:w-full lg:block">
                                <a href="{{ route('media.video.show', ['id' => $item['id']]) }}" aria-label="Youtube">
                                    <img src="https://img.youtube.com/vi/{{ $item['youtube_id'] }}/hqdefault.jpg" class="w-full h-4/5" alt="Youtube">
                                </a>
                                <p class="md:hidden lg:hidden text-base" style="margin-top: 15px;text-align: left;">{{ $item['title'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10 h-10"></div>
</div>
@endif

@if (!empty($galleries['data']))
<div class="hidden md:block mx-auto h-max px-5 bg-gradient-to-r from-yellow-200 to-green-400">
    <div class="margin-100">
        <div class="flex justify-between">
            <div class="mt-10">
                <h6 class="lg:text-3xl ml-1 text-green-600">Galeri</h6>
            </div>
            <div class="mt-10">
                <h6 class="lg:text-2xl ml-4 text-green-600">
                    <a href="{{ route('media.galeri.index') }}" aria-label="Galeri">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </h6>
            </div>
        </div>
        <div class="flex justify-center grid grid-cols-1 lg:grid-cols-3 gap-4 grid-flow-row mt-10 mb-10">
            <div class="col-start-1 col-end-4" style="margin-left: auto;margin-right:auto;">
                <div id="carousel">
                    @foreach ($galleries['data'] as $item)
                        <img src="{{ $item['image'] }}" class="w-96" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10 h-10"></div>
</div>
<div class="lg:hidden md:hidden md:block mx-auto h-max px-5 bg-gradient-to-r from-yellow-200 to-green-400">
    <div class="margin-100">
        <div class="flex justify-between">
            <div class="mt-10">
                <h6 class="lg:text-3xl ml-4 text-green-600">Galeri</h6>
            </div>
            <div class="mt-10">
                <h6 class="lg:text-2xl ml-4 text-green-600">
                    <a href="{{ route('media.galeri.index') }}" aria-label="Galeri">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </h6>
            </div>
        </div>
        <div class="flex justify-center grid grid-cols-2 gap-4 grid-flow-row mt-10">
            @foreach ($galleries['data'] as $item)
                <img src="{{ $item['image'] }}" class="w-96" alt="Galeri"/>
            @endforeach
        </div>
    </div>
    <br>
</div>
@endif

<div class="md:block mx-auto h-96 px-5" style="background-image: url('{{ asset('images/Infografis_Background.png') }}');background-size: cover;">
    <div class="margin-100 ">
        <div class="flex justify-between">
            <div class="mt-10">
                <h6 class="lg:text-3xl mb-10 ml-1 text-green-600">Testimoni</h6>
            </div>
            <div class="mt-10">
                <h6 class="lg:text-2xl mb-10 ml-4 text-green-600">
                    <a href="{{ route('tentang-kami.testimoni') }}" aria-label="testimoni">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </h6>
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div class="testimonial-section">
                <div class="container-testimonial">
                    <div class="owl-carousel slide">
                        @foreach ($testimonies['data'] as $item)
                            <div class="testimonial-wrapper">
                                <div class="client-pic-name">
                                    <div class="pic-client max-w-md mx-auto rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                                        <div class="md:flex">
                                            <div class="md:flex-shrink-0">
                                                <img alt="customer-pic" class="object-cover md:h-52 md:w-48 rounded-lg shadow-xl mb-4" border="0" src="{{ $item['photo'] }}" alt="testimoni">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="name-client">
                                        <div class="name-client-child">
                                            <p class="text-xs text-justify lg:text-center md:text-center lg:text-lg md:text-md">{!! $item['content'] !!}</p>
                                        </div>
                                        <div class="hidden lg:block md:block name-client-child">
                                            -{{ $item['name'] }}-
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('js/charts.js') }}"></script>
    <script>
        $(document).ready(function() {
            var result = @json($infographicsMapping);
            // var data = [];
            // result.forEach(function(obj){
            //     data.push([
            //         obj['province_code'],
            //         obj['total']
            //     ]);
            // });
            const data = [
                ['id-ac', 171],
                ['id-su', 134],
                ['id-sb', 302],
                ['id-ri', 203],
                ['id-ja', 80],
                ['id-sl', 225],
                ['id-be', 45],
                ['id-1024', 110],
                ['id-bb', 328],
                ['id-kr', 17],
                ['id-jk', 598],
                ['id-jr', 910],
                ['id-jt', 1287],
                ['id-yo', 882],
                ['id-ji', 2433],
                ['id-bt', 183],
                ['id-ba', 539],
                ['id-nb', 157],
                ['id-nt', 47],
                ['id-kb', 167],
                ['id-kt', 108],
                ['id-ks', 233],
                ['id-ki', 237],
                ['id-ku', 32],
                ['id-sw', 30],
                ['id-st', 28],
                ['id-se', 236],
                ['id-sg', 101],
                ['id-go', 110],
                ['id-sr', 29],
                ['id-ma', 14],
                ['id-la', 19],
                ['id-pa', 8],
                ['id-ib', 25]
            ];
            Highcharts.mapChart('infographics', {
                chart: {
                    map: 'countries/id/id-all'
                },
                title: {
                    text: ''
                },
                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },
                colorAxis: {
                    min: 0
                },
                series: [{
                    data: data,
                    name: 'Perpustakaan Terakreditasi',
                    states: {
                        hover: {
                            color: '#BADA55'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            if (this.point['hc-key'] === 'id-ib') {
                                return 'Papua Barat';
                            }

                            return this.point.name;
                        }
                    }
                }],

                tooltip: {
                    pointFormatter: function() {
                        if (this['hc-key'] === 'id-ib') {
                            return 'Papua Barat: ' + this.value;
                        }

                        return this.name + ' ' + this.value;
                    }
                }
            });
        });
    </script>
	<script>
		$(document).ready(function() {
			$("#banner-carousel").owlCarousel({
				loop: true,
				nav: false,
				dots: true,
				autoplay: true,
				items: 1,
				responsiveClass: true
			});
		});
	</script>
@endpush
