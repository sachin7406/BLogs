{{-- SEO & Meta Data --}}
@section('title', 'DDSPLM | Blogs')
@section('meta_description', 'Explore the latest mechanical engineering blogs, product news, and industry solutions from DDSPLM. Stay updated on innovations, best practices, and case studies.')
@section('meta_keywords', 'engineering blogs, mechanical design, DDSPLM blogs, product innovation, CAD, CAE, PLM, industry news, Siemens, Altair')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', 'DDSPLM | Mechanical Engineering & Industry Blogs')
@section('og_description', 'Read the latest blogs from DDSPLM: mechanical engineering expertise, product tips, and industry solutions for innovation and productivity.')
@section('og_image', asset('images/no-image-available.png'))
@section('og_url', url()->current())
@section('og_type', 'website')
@section('twitter_title', 'DDSPLM | Latest Engineering & Industrial Blogs')
@section('twitter_description', 'DDSPLM shares the latest blogs on mechanical engineering, CAD, CAE, PLM, and industry innovations. Stay ahead with news, case studies, and insights.')
@section('twitter_image', asset('images/no-image-available.png'))

<div class="hero-image">
    <div class="hero-text">
        <h1>Blogs</h1>
        <ul class="page-list">
            <li><a href="/" class="spa-link">Home</a></li>
            <li>Blogs</li>
        </ul>
    </div>
</div>
<!---banner- end--->
<!----blog-----start---->
<section class="blog_section">
    <div class="container">
        @if(isset($blogs) && $blogs->count())
        <div class="row">
            @foreach($blogs as $index => $blog)
            <div class="blog-hover mb-3 w-100 d-flex flex-wrap align-items-stretch">
                @if($index % 2 == 0)
                {{-- Image on Left --}}
                <div class="blog-column side" style="flex:1 1 250px; min-width:220px; max-width:400px;">
                    @if(!empty($blog->reference_image))
                    <img src="{{ asset(ltrim($blog->reference_image, '/')) }}" class="img-fluid" alt="{{ $blog->title }}">
                    @else
                    <img src="{{ asset('images/no-image-available.png') }}" class="img-fluid" alt="No image">
                    @endif
                </div>
                <div class="blog-column middle" style="flex:2 1 0;min-width:260px; padding-left:24px;">
                    <p>
                        {{ $blog->created_at ? $blog->created_at->format('d M, Y') : '' }}
                    </p>
                    <h2>
                        <a href="{{ url('/blogs_view/' . $blog->id . '-' . \Illuminate\Support\Str::slug($blog->title)) }}" target="_blank" class="text-uppercase">
                            {{ $blog->title }}
                        </a>
                    </h2>
                    <p>
                        {{ $blog->description ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 175) }}
                    </p>
                    <a href="{{ url('/blogs_view/' . $blog->id . '-' . \Illuminate\Support\Str::slug($blog->title)) }}" target="_blank" class="btn btn-primary">read more</a>
                </div>
                @else
                {{-- Image on Right --}}
                <div class="blog-column middle" style="flex:2 1 0;min-width:260px; padding-right:24px;">
                    <p>
                        {{ $blog->created_at ? $blog->created_at->format('d M, Y') : '' }}
                    </p>
                    <h2>
                        <a href="{{ url('/blogs_view/' . $blog->id . '-' . \Illuminate\Support\Str::slug($blog->title)) }}" target="_blank" class="text-uppercase">
                            {{ $blog->title }}
                        </a>
                    </h2>
                    <p>
                        {{ $blog->description ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 175) }}
                    </p>
                    <a href="{{ url('/blogs_view/' . $blog->id . '-' . \Illuminate\Support\Str::slug($blog->title)) }}" target="_blank" class="btn btn-primary">read more</a>
                </div>
                <div class="blog-column side" style="flex:1 1 250px; min-width:220px; max-width:400px;">
                    @if(!empty($blog->reference_image))
                    <img src="{{ asset(ltrim($blog->reference_image, '/')) }}" class="img-fluid" alt="{{ $blog->title }}">
                    @else
                    <img src="{{ asset('images/no-image-available.png') }}" class="img-fluid" alt="No image">
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p>No blog posts available at this time.</p>
        @endif
    </div>
</section>
<!----blog-----end------>