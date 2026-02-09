<!-- ===== Sidebar ===== -->
<div id="sidebar" class="sidebar">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">

        <!-- LOGO -->
        <a href="{{ url('/') }}" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">{{ session('admin_name') }}</span>
        </a>

        <!-- MENU -->
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">

            <!-- DASHBOARD -->
            <li class="nav-item w-100">
                <a href="{{ route('admin.dashboard') }}" class="nav-link align-middle px-0 text-white">
                    <i class="fs-4 bi-speedometer2"></i>
                    <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                </a>
            </li>

            <!-- BLOGS -->
            <li class="w-100">
                <a href="#blogSubmenu" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi bi-journal-text"></i>
                    <span class="ms-2 d-none d-sm-inline">Blogs</span> </a>

                <ul class="collapse nav flex-column ms-4" id="blogSubmenu" data-bs-parent="#menu">
                    <li class="w-100">
                        <a href="{{ route('admin.blogs') }}" class="nav-link px-0 text-white">
                            <i class="bi bi-list-ul me-2"></i>
                            <span class="d-none d-sm-inline">All Blogs</span>
                        </a>
                    </li>
                    <li class="w-100">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link px-0 text-white">
                            <i class="bi bi-tags me-2"></i>
                            <span class="d-none d-sm-inline">Categories</span>
                        </a>
                    </li>

                    @if(session('admin_role') === 'admin' || session('admin_role') === 'editor')
                    <li class="w-100">
                        <a href="{{ route('admin.blogs.create') }}" class="nav-link px-0 text-white">
                            <i class="bi bi-plus-circle me-2"></i>
                            <span class="d-none d-sm-inline">Create Blog</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>


            <!-- USERS (ADMIN ONLY) -->
            @if(session('admin_role') === 'admin')
            <li class="nav-item w-100">
                <a href="#userSubmenu" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-people"></i>
                    <span class="ms-1 d-none d-sm-inline">Users</span>
                </a>
                <ul class="collapse nav flex-column ms-4" id="userSubmenu" data-bs-parent="#menu">
                    <li class="w-100">
                        <a href="{{ route('admin.users.index') }}" class="nav-link px-0 text-white">
                            <i class="bi bi-list-ul me-2"></i>
                            <span class="d-none d-sm-inline">All Users</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

        </ul>

        <hr class="w-100">

        <!-- USER DROPDOWN -->
        <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://i.pravatar.cc/30" alt="user" width="30" height="30" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1">{{ session('admin_name') }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Sign out</a></li>
            </ul>
        </div>

    </div>
</div>

<!-- ===== Overlay ===== -->
<div id="sidebarOverlay" class="sidebar-overlay"></div>