<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        label.required::after,
        div.required > label::after {
            content: "*";
            color: red;
        }

        @media only screen and (min-width: 900px) {
            .content {
                margin-left: 220px;
            }
        }

        @media only screen and (max-width: 600px) {
            #datatable_length {
                position: absolute;
                margin-left: 37px;
                margin-top: -40px;
            }
            #datatable_filter {
                position: absolute;
                margin-top: 10px;
                margin-left: 23px;
            }
            #datatable_info {
                position: absolute;
                margin-top: 15px;
                margin-left: 20px;
            }
            #datatable_paginate {
                position: absolute;
                margin-top: 55px;
                margin-left: 40px;
            }
            div.table-responsive > div.dataTables_wrapper > div.row {
                margin-top: 58px;
            }
            .icon-bell {
                color: white !important;
            }
            .mobile-hide {
                display: none;
            }
        }

    </style>
    @stack('css')
    @laravelPWA
</head>
<body>
    @if(in_array(request()->route()->getName(), \Helper::routeList()))
        @include('components.nav')
        @include('components.sidenav')
        @if (\Helper::isAsesor() || \Helper::isAsesi())
            @include('components.bottom-nav')
        @endif
        <main class="content">
            @include('components.topbar')
            @yield('content')
            @include('components.footer')
        </main>
        @elseif (in_array(request()->route()->getName(), ['register.index', 'login', 'forgot_password.index', 'forgot_password.edit', 'register.index.asesor', 'reset_password.edit']))
        @yield('content')
        @include('components.footer-auth')
        @elseif(in_array(request()->route()->getName(), ['404', '500', 'lock', 'verification.index', 'storage.file', 'storage.secure']))
        @yield('content')
    @endif
    <!-- Core -->
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('js')
    <script>
        $(function () {
            @if(Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: "{{ Session::get('success_title') ?? 'Success!' }}",
                    text: "{{ Session::get('success') }}"
                })
            @elseif(Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf..',
                    text: "{{ Session::get('error') }}"
                })
            @endif

            $('.link-logout').on('click', function () {
                Swal.fire({
                    title: "{{ __('Are you sure logout?') }} ",
                    // text: "{{ __('You wont be able to forward this page!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout!'
                }).then((event) => {
                    if (event.isConfirmed) {
                        window.location.href = "{{ route('logout') }}"
                    } else {
                        Swal.fire('Info', 'cancelled logout!', 'info');
                    }
                })
            })
        })
    </script>
</body>
</html>
