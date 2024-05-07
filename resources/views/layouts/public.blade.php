<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="Akreditasi Perpustakaan Nasional">
		<title>Perpustakaan Nasional Republik Indonesia</title>
        <link rel="stylesheet" href="{{ mix('css/public.css') }}">
        <link rel="stylesheet" href="{{ asset('css/maps/jqvmap.css') }}">
		@laravelPWA
		@stack('css')
	</head>
	<body>
		<!-- Navbar goes here -->
		<div class="w-full text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800">
			<div x-data="{ open: false }" class="menu-mobile-hide flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
			  <div class="p-4 flex flex-row items-center justify-between">
				<a href="{{ route('home.index') }}" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
					<img src="{{ asset('images/Logo_SiPAPI.png') }}" alt="Logo" class="w-60 mr-10">
				</a>
				<button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
				  <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
					<path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
					<path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
				  </svg>
				</button>
			  </div>
			  <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
				<a class="px-4 md:hidden lg:block py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('home.index') }}">Beranda</a>
				@foreach (session('publicMenu')['data'] as $menu)
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="tablet-menu flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                        <span>{{ $menu['name'] }}</span>
                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="z-50 absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48" style="display: none">
                            <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                                @foreach ($menu['children'] as $submenu)
                                    <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ $submenu['is_default'] == true ? route('home.index').'/'.$submenu['url'] : route('home.dynamicMenu', ['parent' => explode("/", $submenu['url'])[0], 'child' => explode("/", $submenu['url'])[1]]) }}">{{ $submenu['name'] }}</a>
                                @endforeach
                                {{-- <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('tentang-kami.asesor') }}">Profil Asesor / LAPNAS</a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('tentang-kami.testimoni') }}">Testimoni</a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
				{{-- <div @click.away="open = false" class="relative" x-data="{ open: false }">
					<button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
					  <span>Media</span>
					  <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
					</button>
					<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="z-50 absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
					  <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
						<a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('media.berita.index') }}">Berita</a>
						<a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('media.galeri.index') }}">Galeri</a>
						<a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('media.video.index') }}">Video</a>
					  </div>
					</div>
				  </div>
				<div @click.away="open = false" class="relative" x-data="{ open: false }">
				  <button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
					<span>Layanan</span>
					<svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
				  </button>
				  <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="z-50 absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
					<div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
					  <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('layanan.faq.index') }}">FAQ</a>
					  <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('layanan.unduh.index') }}">Unduh Berkas</a>
					</div>
				  </div>
				</div> --}}
				<a class="px-4 login-register-menu py-2 mt-2 text-sm font-semibold text-white bg-green-500 rounded-lg dark-mode:bg-green-700 dark-mode:hover:perpusnas-green dark-mode:focus:perpusnas-green dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-white md:mt-0 hover:text-white focus:text-white hover:bg-green-500 focus:bg-green-200 focus:outline-none focus:shadow-outline" href="{{ route('login') }}">Masuk</a>
				<a class="px-4 login-register-menu py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('register.index') }}" style="border: 1px solid rgba(52, 211, 153, var(--tw-bg-opacity));">Daftar</a>
			  </nav>
			</div>
		  </div>
          <div class="relative md:flex">
            <!-- mobile menu bar -->
            <div class="text-gray-100 flex justify-between md:hidden">
              <!-- logo -->
              <a href="{{ route('home.index') }}" class="block p-4 text-white font-bold">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-60 mr-10">
              </a>
              <!-- mobile menu button -->
              <button type="button" aria-label="menu" class="mobile-menu-button p-4 focus:outline-none focus:bg-white text-gray-900">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
            </div>
          </div>
          <!-- sidebar -->
          <div class="lg:hidden md:hidden z-40 sidebar bg-white text-blue-100 w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out h-screen">
            <!-- logo -->
            <a href="{{ route('home.index') }}" class="text-white flex items-center space-x-2 px-2">
              <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
              </svg>
              <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-50">
            </a>
            <!-- nav -->
            <nav>
                <a style="color: gray" class="px-4 md:hidden lg:block mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 focus:outline-none focus:shadow-outline" href="{{ route('home.index') }}">Beranda</a>
                @foreach (session('publicMenu')['data'] as $menu)
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="tablet-menu flex flex-row items-center w-full px-4 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 focus:outline-none focus:shadow-outline">
                        <span style="color: gray">{{ $menu['name'] }}</span>
                        <svg style="color: gray" fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="z-50 absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                            <div style="padding: 10px" class="px-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                                @foreach ($menu['children'] as $submenu)
                                    <a style="color: gray" class="block px-4 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:outline-none focus:shadow-outline" href="{{ $submenu['is_default'] == true ? route('home.index').'/'.$submenu['url'] : route('home.dynamicMenu', ['parent' => explode("/", $submenu['url'])[0], 'child' => explode("/", $submenu['url'])[1]]) }}">{{ $submenu['name'] }}</a>
                                @endforeach
                                {{-- <a class="block px-4 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:outline-none focus:shadow-outline" href="{{ route('tentang-kami.asesor') }}">Profil Asesor / LAPNAS</a>
                                <a class="block px-4 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('tentang-kami.testimoni') }}">Testimoni</a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="px-3 mt-5">
                    <button class="h-12 bg-green-500 w-full text-black text-md rounded hover:shadow hover:bg-green-200 mb-2 text-white">
                        <a href="{{ route('login')}}">Masuk</a>
                    </button>
                    <button class="h-12 bg-transparent text-gray-900 w-full text-white text-md rounded hover:shadow hover:bg-blue-800">
                        <a href="{{ route('register.index')}}">Daftar</a>
                    </button>
                </div>
            </nav>
          </div>
		@yield('content')

		<footer class="perpusnas-green body-font">
			<div class="container h-full lg:h-3/4 px-10 py-24 mx-auto flex md:items-center lg:items-start md:flex-row md:flex-nowrap flex-wrap flex-col">
				<div class="flex-grow flex flex-wrap md:pl-20 -mb-10 md:mt-0 mt-10 md:text-left text-center">
					<div class="lg:w-1/4 md:w-1/2 w-full px-4">
						<h2 class="title-font lg:text-2xl font-medium text-white tracking-widest text-sm mb-3">Beranda</h2>
                        <div class="website-counter content-center mb-10">
                            <script type='text/javascript' src='https://www.freevisitorcounters.com/auth.php?id=f9287364c2583c5144672b45d1ba81ad3472053b'></script>
                            <script type="text/javascript" src="https://www.freevisitorcounters.com/en/home/counter/903013/t/5"></script>
                        </div>
					</div>
					@foreach (session('publicMenu')['data'] as $menu)
                    <div class="{{ $menu['name'] == 'Media' ? 'lg:w-32' : 'lg:w-1/4' }} md:w-1/2 w-full px-4">
						<h2 class="title-font lg:text-2xl font-medium text-white tracking-widest text-sm mb-3 text-center lg:text-left">{{ $menu['name'] }}</h2>
						<nav class="list-none mb-10">
							<ul>
								@foreach ($menu['children'] as $submenu)
                                    @if ($submenu['is_default'] == true)
                                    <li class="text-center lg:text-left">
                                        <a class="text-white hover:text-white" href="{{ route('home.index').'/'.$submenu['url'] }}">{{ $submenu['name'] }}</a>
                                    </li>
                                    @endif
                                @endforeach
							</ul>
						</nav>
					</div>
                    @endforeach
				</div>
				<div class="w-64 flex-shrink-0 mx-auto text-center md:text-left mt-10 lg:mt-1">
					<a href="{{ route('home.index') }}" class="flex title-font font-medium items-center md:justify-start justify-center text-white">
						<img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-60 mr-10 position-lg img-center-mobile">
					</a>
				</div>
			</div>
			<div class="perpusnas-green">
				<div class="container w-full py-4 px-5 flex flex-wrap flex-col sm:flex-row md:justify-center lg:justify-center">
					<p class="text-white text-center">Hak Cipta 2021 &copy; Perpustakaan Nasional Republik Indonesia. Seluruhnya dilindungi Hak Cipta.</p>
				</div>
			</div>
		</footer>
	</body>

        <script type="text/javascript" src="{{ mix('js/public.js') }}"></script>
		<script src="{{ asset('js/maps/jquery.vmap.js') }}"></script>
		<script src="{{ asset('js/maps/jquery.vmap.indonesia.js') }}"></script>
		<script>
            // grab everything we need
            const btn = document.querySelector(".mobile-menu-button");
            const sidebar = document.querySelector(".sidebar");

            // add our event listener for the click
            btn.addEventListener("click", () => {
                sidebar.classList.toggle("-translate-x-full");
            });

			function openDropdown(event, dropdownID) {
			let element = event.target;
			while (element.nodeName !== "BUTTON") {
				element = element.parentNode;
			}
			var popper = Popper.createPopper(
				element,
				document.getElementById(dropdownID),
				{
				placement: "bottom-start",
				}
			);
			document.getElementById(dropdownID).classList.toggle("hidden");
			document.getElementById(dropdownID).classList.toggle("block");
			}
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#carousel").waterwheelCarousel({
					// include options like this:
					// (use quotes only for string values, and no trailing comma after last option)
					// option: value,
					// option: value
				});
				$('.testimonial-section .owl-carousel').owlCarousel({
					items: 1,
					loop: true,
					nav: true,
					dots: false,
					navText: ['<i style="color: rgba(5,150,105);" class="fa fa-angle-left"></i>', '<i style="color: rgba(5,150,105);" class="fa fa-angle-right"></i>'],
					autoplay: true,
					// autoplayHoverPause:true,
					responsiveClass: true,
				});
				jQuery('#vmap').vectorMap({
                    map: 'indonesia_id',
                    enableZoom: true,
                    showTooltip: true,
                    selectedColor: null,
                    onRegionClick: function(event, code, region){
                        event.preventDefault();
                    }
                });
				$(".jqvmap-zoomin").hide();
				$(".jqvmap-zoomout").hide();
			});
		</script>
		@stack('script')
</html>
