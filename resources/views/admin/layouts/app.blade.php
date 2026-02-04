<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f3f4f7;
            font-size: 14px;
            overflow-x: hidden;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 65px;
            /* 👈 collapsed by default */
            height: 100vh;
            background: #0f172a;
            color: #cbd5e1;
            padding-top: 20px;
            transition: width 0.3s ease;
            z-index: 1050;
        }

        /* Expand on hover */
        .sidebar:hover {
            width: 180px;
        }

        /* Sidebar links */
        .sidebar a {
            color: #cbd5e1;
            padding: 8px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 14px;
            white-space: nowrap;
        }

        /* Icon spacing */
        .sidebar a i {
            min-width: 24px;
            font-size: 20px;
            margin-right: 12px;
        }

        /* Hover active */
        .sidebar a:hover,
        .sidebar a.active {
            background: #1e293b;
            color: #fff;
        }

        /* ===== TEXT VISIBILITY ===== */
        .sidebar .d-sm-inline {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* Show text on hover */
        .sidebar:hover .d-sm-inline {
            opacity: 1;
        }

        /* ===== Topbar ===== */
        .topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 60px;
            /* 👈 match collapsed sidebar */
            right: 0;
            transition: left 0.3s ease;
            z-index: 1030;
        }

        /* Move topbar when sidebar expands */
        .sidebar:hover~.content .topbar {
            left: 180px;
        }

        /* ===== Content ===== */
        .content {
            margin-left: 65px;
            min-height: 100vh;
            padding-top: 80px;
            transition: margin-left 0.3s ease;
            width: 100%;
        }

        /* Move content when sidebar expands */
        .sidebar:hover~.content {
            margin-left: 180px;
        }

        /* ===== Mobile (unchanged) ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                font-size: 12px;
            }

            .sidebar.active {
                transform: translateX(0);
                font-size: 12px;
            }

            .topbar {
                left: 0;
            }

            .content {
                margin-left: 0;
                padding-top: 80px;
                font-size: 12px;
            }
        }

        /* Hamburger button */
        .menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* ===== Cards ===== */
        .card-gradient {
            color: #fff;
            border: none;
        }

        .bg-purple {
            background: linear-gradient(45deg, #6366f1, #8b5cf6);
        }

        .bg-blue {
            background: linear-gradient(45deg, #0ea5e9, #38bdf8);
        }

        .bg-yellow {
            background: linear-gradient(45deg, #f59e0b, #fbbf24);
        }

        .bg-red {
            background: linear-gradient(45deg, #ef4444, #f87171);
        }

        /* ===== BLOG GRID (4 COLUMN FIXED) ===== */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        /* ===== CARD ===== */
        .blog-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
        }

        /* ===== IMAGE ===== */
        .blog-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            position: relative;
        }

        /* image overlay */
        .blog-card::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 180px;
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.05),
                    rgba(0, 0, 0, 0.35));
        }

        /* ===== BODY ===== */
        .blog-body {
            padding: 16px;
            flex: 1;
        }

        .blog-title {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.4;

            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;

            overflow: hidden;
            max-width: 100%;
            min-height: 40px;
        }


        .blog-desc {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 14px;
            overflow: hidden;
            max-width: 100%;
            min-height: 40px;
        }

        /* ===== META ===== */
        .blog-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #6b7280;
        }

        /* status badge */
        .blog-meta .badge {
            padding: 5px 12px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 11px;
        }

        /* ===== FOOTER ===== */
        .blog-footer {
            padding: 14px 16px;
            border-top: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fafafa;
        }

        .blog-footer small {
            font-weight: 600;
            color: #374151;
        }

        .blog-footer .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .blog-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .blog-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .blog-grid {
                grid-template-columns: 1fr;
            }
        }

        /* BLOG LIST */
        /* LIST CONTAINER */
        .blog-list {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        /* ROW */
        .blog-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-bottom: 1px solid #eef0f2;
        }

        .blog-row:last-child {
            border-bottom: none;
        }

        /* LEFT SIDE */
        .blog-left {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0;
        }


        /* IMAGE */
        .blog-thumb {
            width: 72px;
            height: 72px;
            border-radius: 8px;
            object-fit: cover;
            background: #f3f4f6;
            flex-shrink: 0;
        }

        /* TEXT */
        .blog-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
            width: 100%;
        }

        .blog-title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .blog-desc {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.4;
        }

        /* META */
        .blog-meta {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 8px;
            font-size: 12px;
            color: #6b7280;
        }

        .blog-meta .badge {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 999px;
        }

        /* ACTIONS */
        .blog-actions {
            display: flex;
            align-items: center;
        }

        .blog-actions button {
            border-radius: 8px;
        }

        /* HOVER (subtle like Wix) */
        .blog-row:hover {
            background: #f9fafb;
        }

        .created-time {
            margin-left: auto;
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
        }

        /* TOP BAR */
        .wp-topbar {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-bottom: 15px;
        }

        .wp-editor-wrapper {
            display: flex;
            gap: 24px;
        }

        .wp-editor-container {
            flex: 1;
            background: #fff;
            padding: 40px 0;
            border-radius: 6px;
        }

        .wp-title-input {
            max-width: 760px;
            margin: 0 auto 30px auto;
            display: block;
            font-size: 34px;
            font-weight: 400;
            border: none;
            outline: none;
        }

        .wp-editor-area {
            max-width: 760px;
            margin: 0 auto;
            min-height: 300px;
            font-size: 16px;

        }

        .wp-editor-sidebar {
            width: 280px;
        }

        .sidebar-box {
            background: #fff;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 12px;
        }

        .wp-plus-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #dcdcde;
            background: #fff;
            color: #1e1e1e;
            font-size: 20px;
            cursor: pointer;
            margin: 10px auto;
            display: block;
        }

        .wp-plus-btn:hover {
            background: #f6f7f7;
        }

        .ce-block__content {
            max-width: 760px;
        }

        .ce-toolbar__content {
            max-width: 760px;
        }
    </style>
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