@extends('admin.layouts.app')

@section('content')

<!-- BLOG STAT CARDS -->
<div class="row g-4 align-items-stretch">

    <div class="col-md-3">
        <div class="card card-gradient bg-purple p-3">
            <small>Total Blogs</small>
            <h3>{{ $totalBlogs }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-gradient bg-blue p-3">
            <small>Active Blogs</small>
            <h3>{{ $activeBlogs }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-gradient bg-yellow p-3">
            <small>Inactive Blogs</small>
            <h3>{{ $inactiveBlogs }}</h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-gradient bg-red p-3">
            <small>New Blogs (7 days)</small>
            <h3>{{ $newBlogs }}</h3>
        </div>
    </div>

</div>
<div class="blog-grid mt-4">

    @foreach($blogs as $blog)
    <a href="{{ route('admin.blogs.view', $blog->id) }}" class="text-decoration-none">
        <div class="blog-card">

            <img
                src="{{ $blog->reference_image ?: 'https://via.placeholder.com/400x220?text=Blog+Image' }}"
                alt="{{ $blog->title }}"
                class="blog-img">

            <div class="blog-body">
                <h6 class="blog-title">{{ $blog->title }}</h6>

                <p class="blog-desc">
                    {{ Str::limit($blog->description, 70) }}
                </p>

                <div class="blog-meta">
                    <span class="badge bg-{{ $blog->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($blog->status) }}</span>
                    <small>{{ $blog->created_at->diffForHumans() }}</small>
                </div>
            </div>

            <div class="blog-footer">
                <img src="https://i.pravatar.cc/24" class="avatar">
                <small>{{ session('admin_name') }}</small>
            </div>

        </div>
    </a>
    @endforeach

</div>

<div class="mt-4">
    {{ $blogs->links() }}
</div>



<!-- LATEST BLOG POSTS -->
<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold">
        Latest Blog Posts
    </div>

    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created On</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestBlogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>
                        <span class="badge bg-{{ $blog->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($blog->status) }}
                        </span>
                    </td>
                    <td>{{ $blog->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No blogs available
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
