<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPKL')</title>
    <!-- Meta, CSS, dan link lainnya -->
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="This is a system for managing internship programs, including student and mentor management, industry partnerships, and reporting.">
    <meta name="keywords" content="bootstrap 5, admin dashboard, colorlibhq">
    <meta name="color-scheme" content="light dark" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.1/css/OverlayScrollbars.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
    @stack('styles')
</head>

<body class="layout-fixed">
    <div class="wrapper">
        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')
        <main class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <div class="fs-3">@yield('title')</div>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                @if (request()->routeIs('admin.*'))
                                    <li class="breadcrumb-item active">Admin</li>
                                @elseif (request()->routeIs('users.*'))
                                    <li class="breadcrumb-item active">Users</li>
                                @elseif (request()->routeIs('siswas.*'))
                                    <li class="breadcrumb-item active">Siswa</li>
                                @elseif (request()->routeIs('pembimbings.*'))
                                    <li class="breadcrumb   -item active">Pembimbing</li>
                                @elseif (request()->routeIs('industris.*'))
                                    <li class="breadcrumb-item active">Industri</li>
                                @elseif (request()->routeIs('laporans.*'))
                                    <li class="breadcrumb-item active">Laporan</li>
                                @else
                                    <li class="breadcrumb-item active">c</li> @endif
                                    <li class="breadcrumb-item
        active">@yield('title')</li>
    </ol>
    </div>
    </div>
    </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <!-- /.content-wrapper -->
    </main>
    @include('layouts.partials.footer')
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.1/js/OverlayScrollbars.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
    @stack('scripts')
    </body>

</html>
