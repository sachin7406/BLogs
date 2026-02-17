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
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/admin_blog.css') }}">
</head>

<body>

    @include('admin.partials.sidebar')
    <div class="d-flex">
        @include('admin.partials.navbar')
        <div class="content main">
            <div class="container-fluid px-4 mt-4">

                @yield('content')
            </div>

        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuBtn = document.getElementById('menuBtn');

        menuBtn?.addEventListener('click', () => {
            sidebar.classList.add('active');
            overlay.classList.add('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#blogsTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                searching: true,
                responsive: true,
                columnDefs: [{
                        orderable: false,
                        targets: [6]
                    } // Action column
                ]
            });
        });
    </script>

    
</body>

</html>