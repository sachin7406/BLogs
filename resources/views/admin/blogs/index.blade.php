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
    @foreach($blogs as $blog)
    <div class="blog-row">

        <!-- LEFT -->
        <div class="blog-left">
            <img
                src="{{ $blog->reference_image && file_exists(public_path($blog->reference_image)) 
                    ? asset($blog->reference_image) 
                    : 'https://via.placeholder.com/72x72?text=Img' }}"
                class="blog-thumb">

            <div class="blog-text">
                <div class="blog-title text-clamp-2">
                    {{ $blog->title }}
                </div>
                <div class="blog-desc">
                    {{ Str::limit($blog->description, 90) }}
                </div>

                <div class="blog-meta">
                    <span class="badge bg-success">Active</span>

                    <span class="created-time">
                        Created {{ $blog->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="blog-actions dropdown">
            <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                ⋮
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
                        <button class="dropdown-item text-danger">
                            Delete
                        </button>
                    </form>
                </li>
                @endif
            </ul>
        </div>

    </div>
    @endforeach

</div>

@endsection