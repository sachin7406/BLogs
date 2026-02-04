@section('title', 'DDSPLM | blogs')
@section('meta_description', 'Desigen center NX CAD')
@section('meta_keywords', 'mechanical, engineering, solutions')

<div class="container py-4">
    <h2 class="mb-4">Latest Blogs</h2>

    @if(isset($blogs) && $blogs->count())
        <div class="row">
            @foreach($blogs as $blog)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if(!empty($blog->reference_image))
                            <img src="{{ asset(ltrim($blog->reference_image, '/')) }}" class="card-img-top" alt="{{ $blog->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $blog->title }}</h5>
                            <p class="card-text" style="min-height:60px;">
                                {{ $blog->description ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 100) }}
                            </p>
                            <a href="{{ url('/blog/' . $blog->id) }}" class="btn btn-primary mt-auto">Read More</a>
                        </div>
                        <div class="card-footer text-muted small">
                            Published: {{ $blog->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No blog posts available at this time.</p>
    @endif
</div>