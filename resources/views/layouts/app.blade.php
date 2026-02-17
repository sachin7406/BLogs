<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>

    <!-- 🔹 BASIC SEO -->
    <meta name="description" content="@yield('meta_description', 'Default description')">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    <!-- 🔹 CANONICAL -->
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- 🔹 OPEN GRAPH -->
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('meta_description')))">
    <meta property="og:image" content="@yield('og_image', asset('default-og.png'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">

    <!-- 🔹 TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', trim($__env->yieldContent('title')))">
    <meta name="twitter:description" content="@yield('twitter_description', trim($__env->yieldContent('meta_description')))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('default-og.png'))">

    @stack('schema')

    {{-- ================= CORE CSS ================= --}}

    {{-- Bootstrap (USE ONLY ONE VERSION – v5) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- Font Awesome (USE ONE VERSION, NO integrity) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Animation Libraries --}}
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">
    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-left: .1rem;
        }
    </style>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SPA + Custom --}}
    <script src="{{ asset('assets/js/spa.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/loader.js') }}"></script>

    <script>
        document.querySelectorAll('.dropdown-submenu .dropdown-toggle')
            .forEach(el => {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.nextElementSibling.classList.toggle('show');
                });
            });
    </script>

</body>

</html>