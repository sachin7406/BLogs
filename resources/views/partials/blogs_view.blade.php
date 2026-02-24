{{-- SEO & Meta Data --}}
@section('title', $blog->title ?? 'DDSPLM | Blog Details')
@section('meta_description', $blog->meta_description ?? Str::limit(strip_tags($blog->description ?? ''), 150))
@section('meta_keywords', $blog->meta_keywords ?? 'engineering blogs, mechanical design, DDSPLM blog, product innovation, CAD, CAE, PLM, industry news, Siemens, Altair')
@section('meta_robots', 'index, follow')
@section('canonical', url()->current())
@section('og_title', $blog->title ?? 'DDSPLM | Blog')
@section('og_description', $blog->meta_description ?? Str::limit(strip_tags($blog->description ?? ''), 150))
@section('og_image', $blog->image_url ?? asset('images/no-image-available.png'))
@section('og_url', url()->current())
@section('og_type', 'article')
@section('twitter_title', $blog->title ?? 'DDSPLM | Blog')
@section('twitter_description', $blog->meta_description ?? Str::limit(strip_tags($blog->description ?? ''), 150))
@section('twitter_image', $blog->image_url ?? asset('images/no-image-available.png'))


{{-- ================= BLOG ARTICLE CONTENT ================= --}}
<style>
    .blog-breadcrumb {
        font-size: 13px;
        color: #989898;
        margin-bottom: 16px;
        letter-spacing: 0.02em;
        word-break: break-word;
    }

    .blog-breadcrumb a {
        color: #989898;
        text-decoration: none;
        word-break: break-word;
    }

    .blog-breadcrumb a:hover {
        text-decoration: underline;
        color: #3171d7;
    }

    .article-title {
        font-size: 24px;
        font-weight: 400;
        color: #444;
        letter-spacing: 0.01em;
        margin-bottom: 12px;
        margin-top: 0;
        word-break: break-word;
    }

    .headline-main {
        font-size: 28px;
        font-weight: 700;
        color: #272d36;
        margin-bottom: 8px;
        line-height: 1.25;
        word-break: break-word;
    }

    .article-meta {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 18px;
        word-break: break-word;
    }

    .article-body {
        font-size: 17px;
        line-height: 1.8;
        color: #333;
        word-break: break-word;
    }

    .article-body h2 {
        font-size: 26px;
        margin-top: 30px;
        margin-bottom: 12px;
        word-break: break-word;
    }

    .article-body h3 {
        font-size: 20px;
        margin-top: 24px;
        word-break: break-word;
    }

    .article-body p {
        margin-bottom: 18px;
        word-break: break-word;
    }

    .article-body img {
        max-width: 100%;
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        object-fit: contain;
    }

    /* Responsive tweaks */
    @media (max-width: 767.98px) {
        .headline-main {
            font-size: 1.5rem;
        }
        .article-title {
            font-size: 1.1rem;
        }
        .article-body {
            font-size: 15px;
            padding: 0 3vw;
        }
        .article-body h2 {
            font-size: 1.1rem;
            margin-top: 18px;
        }
        .article-body h3 {
            font-size: 1rem;
            margin-top: 14px;
        }
        .blog-breadcrumb {
            font-size: 11px;
            padding: 0 2vw;
        }
        .article-meta {
            font-size: 11px;
        }
        /* Undo negative margin, use container padding instead */
        .responsive-article-container {
            margin: 0 !important;
            padding: 0 0.5rem !important;
        }
    }

    @media (max-width: 575.98px) {
        .headline-main {
            font-size: 1.1rem;
        }
        .article-title {
            font-size: 1rem;
        }
        .article-body {
            font-size: 14px;
            padding: 0 0.4rem;
        }
    }
</style>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- BREADCRUMB --}}
            <div class="blog-breadcrumb text-center">
                <a href="{{ url('/') }}">Home</a>
                <span> &raquo; </span>
                <a href="{{ url('/blogs') }}">Blog</a>
                <span> &raquo; </span>
                <span>{{ $blog->title }}</span>
            </div>

            {{-- HEADLINE --}}
            <div class="headline-main text-center" style="letter-spacing: 0.02em;">
                {{ $blog->title }}
            </div>

            {{-- Small subtitle under headline (for "newt content font" look) --}}
            <h1 class="article-title text-center" style="font-size:13px; color:#222; letter-spacing:0.01em; font-weight:400; margin-top:0; margin-bottom:10px;">
                {{ $blog->title }}
            </h1>

            {{-- META --}}
            <div class="article-meta text-center" style="font-size:11px; color:#444; margin-bottom:16px; letter-spacing:0.01em;">
                <span>
                    <i class="bi bi-calendar3"></i>
                    {{ optional($blog->created_at)->format('F d, Y') }}
                </span>
                <span class="mx-2">|</span>
                <span>
                    <i class="bi bi-person"></i>
                    {{ $blog->author->name ?? 'Admin' }}
                </span>
            </div>

            {{-- CONTENT --}}
            <div class="row responsive-article-container" style="background: white; margin: 0 -100px; padding: 10px 10%;">
                <div class="article-body">

                    @php
                    $blocks = json_decode($blog->content, true);
                    @endphp

                    @if($blocks)
                    @foreach($blocks as $block)
                        {{-- HTML --}}
                        @if(isset($block['content']))
                        {!! $block['content'] !!}
                        @endif

                        {{-- IMAGE BLOCK --}}
                        @if(($block['type'] ?? '') === 'image' && !empty($block['url']))
                        <div class="text-center my-4">
                            <img src="{{ asset(ltrim($block['url'],'/')) }}"
                                class="img-fluid rounded" alt="Blog image">
                        </div>
                        @endif

                        {{-- SEPARATOR --}}
                        @if(($block['type'] ?? '') === 'separator')
                        <hr class="my-4">
                        @endif

                        {{-- COLUMNS --}}
                        @if(in_array($block['type'] ?? '', ['columns','grid']) && isset($block['columns']))
                        <div class="row my-4">
                            @foreach($block['columns'] as $col)
                            <div class="col-12 col-md" style="margin-bottom: 1rem;">
                                {!! $col !!}
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- ACCORDION --}}
                        @if(($block['type'] ?? '') === 'accordion' && isset($block['items']))
                        <div class="accordion my-4" id="blogAccordion">
                            @foreach($block['items'] as $i => $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{$i}}">
                                    <button class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#acc{{ $i }}"
                                        aria-expanded="false"
                                        aria-controls="acc{{ $i }}">
                                        {{ $item['title'] }}
                                    </button>
                                </h2>
                                <div id="acc{{ $i }}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading{{$i}}"
                                    data-bs-parent="#blogAccordion">
                                    <div class="accordion-body">
                                        {!! $item['body'] !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                    @endforeach
                    @else
                    {!! $blog->content !!}
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>