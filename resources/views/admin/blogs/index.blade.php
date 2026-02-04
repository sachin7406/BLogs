@extends('admin.layouts.app')
@include('admin.blogs.modal')

@section('content')

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Blogs</h4>
    <a href="{{ route('admin.blogs.create') }}">
        <button class="btn btn-primary btn-sm addBlog">
            + New Blog
        </button>
    </a>
</div>

<!-- BLOG LIST -->
<div class="blog-list">
    @forelse($blogs as $blog)
    <div class="blog-row align-items-center d-flex">

        <!-- LEFT -->
        <div class="blog-left d-flex align-items-center">
            <div class="blog-thumb-wrap me-3">
                <img
                    src="{{ $blog->reference_image ? asset($blog->reference_image) : 'https://via.placeholder.com/72x72?text=No+Image' }}"
                    class="blog-thumb"
                    alt="{{ $blog->title }}"
                    onerror="this.onerror=null;this.src='https://via.placeholder.com/72x72?text=No+Image';">
            </div>
            <div class="blog-text">
                <div class="blog-title fw-semibold mb-1 text-clamp-2">
                    {{ $blog->title ?: '-' }}
                </div>
                <div class="blog-desc mb-1 small text-muted">
                    {{ $blog->description ? Str::limit(strip_tags($blog->description), 60) : '-' }}
                </div>
                <div class="blog-meta d-flex flex-wrap gap-2 align-items-center">
                    <span class="badge bg-{{ $blog->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($blog->status) }}
                    </span>
                    @if($blog->category)
                    <span class="badge bg-light text-dark">{{ $blog->category->name }}</span>
                    @endif
                    @if(!empty($blog->tags))
                    <span class="badge bg-light text-dark">{{ $blog->tags }}</span>
                    @endif
                    <span class="created-time small text-muted">
                        • {{ $blog->created_at ? $blog->created_at->diffForHumans() : '' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="ms-auto blog-actions dropdown">
            <button class="btn btn-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Blog Actions">
                <span style="font-size: 1.3rem; line-height: 1;">&#8942;</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item viewBlog" href="javascript:void(0)" data-id="{{ $blog->id }}">
                        View
                    </a>
                </li>

                @if(session('admin_role') === 'admin' || session('admin_role') === 'editor')
                <li>
                    <a class="dropdown-item" href="{{ route('admin.blogs.edit', $blog->id) }}">
                        Edit
                    </a>
                </li>
                @endif

                @if(session('admin_role') === 'admin')
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('admin.blogs.delete', $blog->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this blog?')">
                            Delete
                        </button>
                    </form>
                </li>
                @endif
            </ul>
        </div>

    </div>
    @empty
    <div class="text-center text-muted py-5">
        <img src="https://via.placeholder.com/110x110?text=No+Blogs" alt="No Blogs" class="mb-3" style="opacity:.5;">
        <div>No blogs found.</div>
    </div>
    @endforelse

</div>

@endsection