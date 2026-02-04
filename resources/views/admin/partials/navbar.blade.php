<div class="topbar d-flex justify-content-between align-items-center px-4">
    <div class="d-flex align-items-center">
        {{-- Back Button --}}
        @isset($backUrl)
        <a href="{{ $backUrl }}" class="btn btn-outline-primary me-2 d-flex align-items-center">
            <i class="bi bi-arrow-left"></i>
            <span class="ms-1">{{ $backTitle ?? 'Back' }}</span>
        </a>
        @endisset
        <button class="btn btn-outline-secondary d-md-none me-2" id="menuBtn">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="d-flex align-items-center gap-3">
        <i class="bi bi-bell"></i>
        <i class="bi bi-envelope"></i>

        <div class="d-flex align-items-center gap-2">
            <img src="https://i.pravatar.cc/32" class="rounded-circle">
            <span>{{ session('admin_name') }}</span>
        </div>
    </div>
</div>
{{--
    Usage in Blade: Pass $backUrl and optionally $backTitle to view. 
    Example:
    return view(..., ['backUrl' => route('admin.dashboard'), 'backTitle' => 'Dashboard']);
--}}