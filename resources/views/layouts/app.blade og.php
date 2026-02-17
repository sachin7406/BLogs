<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Siemens Smart Expert Partner of NX CAD Design, Manufacturing Simulation and Industry 4.0 Software')
    </title>

    {{-- ================= CORE CSS ================= --}}

    {{-- Bootstrap (USE ONLY ONE VERSION – v5) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">


    {{-- Font Awesome (USE ONE VERSION, NO integrity) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    {{-- Animation Libraries --}}
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">

</head>

<body>

    {{-- PAGE LOADER --}}
    @include('partials.loader')

    {{-- HEADER --}}
    @include('layouts.header')

    @include('components.header-menu')
    {{-- SPA ROOT --}}
    <div id="spa-content">
        @yield('content')
    </div>

    {{-- FOOTER --}}
    @include('layouts.footer')

    {{-- ================= CORE JS ================= --}}

    {{-- jQuery (required for your SPA & old scripts) --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    {{-- Bootstrap JS (v5 – ONLY ONCE) --}}
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- SPA + Custom --}}
    <script src="{{ asset('assets/js/spa.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/loader.js') }}"></script>

</body>

</html>