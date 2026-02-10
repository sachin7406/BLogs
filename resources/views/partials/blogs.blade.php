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

<div class="hero-image" style="margin-bottom: 0;">
    <div class="hero-text">
        <h1 style="font-size:2.0rem; margin-bottom:0.5rem;">Blogs</h1>
        <ul class="page-list" style="padding-left: 0; list-style: none; margin-bottom: 0;">
            <li style="display:inline;"><a href="/" class="spa-link">Home</a></li>
            <li style="display:inline;"> &nbsp;> Blogs</li>
        </ul>
    </div>
</div>

<section class="blog_section ">
    <div class="container" style="max-width:1100px;">
        @if(isset($blogs) && $blogs->count())
        @foreach($blogs as $blog)
        <div class="row align-items-center my-4 px-2" style="background: #fafbfc; border-radius: 10px; box-shadow: 0 1px 8px #e8eaed; padding: 24px 12px;">
            <div class="col-md-4 col-12 mb-3 mb-md-0 d-flex justify-content-center align-items-center">
                <img src="{{ !empty($blog->reference_image) ? asset(ltrim($blog->reference_image, '/')) : asset('images/no-image-available.png') }}"
                    alt="{{ $blog->title }}" class="img-fluid rounded" style="width:100%;max-width:340px;object-fit:cover;box-shadow:0 2px 8px #dbe7fa;">
            </div>
            <div class="col-md-8 col-12" style="padding-top:10px;padding-bottom:10px;">
                <div style="font-size:0.99em;color:#a9aab0;margin-bottom:4px;">
                    {{ $blog->created_at ? $blog->created_at->format('d F, Y') : '' }}
                </div>
                <div style="margin-bottom:30px;">
                    <a href="{{ url('/blogs_view/' . $blog->id . '-' . \Illuminate\Support\Str::slug($blog->title)) }}"
                        style="font-size:1.35rem;font-weight:600;color:#253364;text-decoration:none;line-height:1.3;display:inline-block;margin-bottom:0.5em;transition:color 0.2s;"
                        target="_blank"
                        onmouseover="this.style.color='#e53935'"
                        onmouseout="this.style.color='#253364'">
                        {{ $blog->title }}
                    </a>
                </div>
                <p style="color:#42454b;font-size:1.05em;margin-bottom:20px;">
                    {{ $blog->description ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 175) }}
                </p>
                <a href="{{ url('/blogs_view/' . $blog->id . '-' . \Illuminate\Support\Str::slug($blog->title)) }}"
                    class="btn btn-light border"
                    style="font-weight:500;letter-spacing: 0.5px;padding:.45em 1.5em;font-size:1em;color:#2164ae !important;border:1.5px solid #e53935 !important;transition:color 0.2s,border-color 0.2s;"
                    target="_blank"
                    onmouseover="this.style.color='#e53935'"
                    onmouseout="this.style.color='#2164ae'">
                    Read More
                </a>
            </div>
        </div>
        @endforeach
        @else
        <p style="text-align:center;">No blog posts available at this time.</p>
        @endif
    </div>
</section>

