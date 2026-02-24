    @extends('admin.layouts.app')

    @section('content')
    @php
    // Dynamic back link to dashboard
    $backUrl = route('admin.dashboard');
    $backTitle = 'Dashboard';
    @endphp

    <style>
        .creative-post-wrapper {
            max-width: 900px;
            margin: 50px auto 40px auto;
            background: linear-gradient(110deg, #fff 85%, #f1f4fb 100%);
            border-radius: 24px;
            box-shadow: 0 6px 32px rgba(56, 88, 233, 0.09), 0 1.5px 12px rgba(80, 80, 140, 0.07);
            padding: 64px 36px 48px 36px;
            transition: box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }


        .creative-back-link {
            display: inline-flex;
            align-items: center;
            background: #eef1fa;
            border-radius: 40px;
            color: #3b56c6;
            padding: 8px 18px 7px 14px;
            font-weight: 500;
            font-size: 16px;
            text-decoration: none;
            margin-bottom: 28px;
            margin-left: -6px;
            box-shadow: 0 2px 8px rgba(56, 88, 233, 0.07);
            transition: background 0.14s, color 0.12s;
            border: 1px solid #e4e8f3;
        }

        .creative-back-link:hover {
            background: #deebfc;
            color: #283798;
            text-decoration: none;
        }

        .creative-back-link svg {
            margin-right: 9px;
            width: 22px;
            height: 22px;
            vertical-align: middle;
            fill: #3b56c6;
            opacity: 0.88;
        }

        .wp-post-title {
            font-size: 44px;
            font-weight: 900;
            margin-bottom: 15px;
            line-height: 1.13;
            letter-spacing: -1.5px;
            color: #253169;
            text-shadow: 0 2.5px 18px #e5e9fb80;
            position: relative;
            z-index: 1;
        }

        .wp-post-meta {
            font-size: 14.5px;
            color: #7276b3;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            font-weight: 600;
            background: #f7f8fc;
            padding: 8px 20px 7px 12px;
            border-radius: 16px;
            display: inline-block;
        }

        .wp-post-content {
            position: relative;
            z-index: 1;
        }

        .wp-post-content p {
            font-size: 19.5px;
            margin: 23px 0;
            color: #22263d;
            line-height: 1.75;
        }

        .wp-post-content h2 {
            font-size: 30px;
            margin: 48px 0 16px;
            color: #325cd4;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .wp-post-content h3 {
            font-size: 23px;
            margin: 35px 0 13px;
            color: #495b91;
            font-weight: 600;
        }

        .wp-post-content ul,
        .wp-post-content ol {
            padding-left: 27px;
            margin: 21px 0;
        }

        .wp-post-content li {
            font-size: 18px;
            margin-bottom: 8px;
            color: #2c3051;
        }

        .wp-post-content blockquote {
            border-left: 4px solid #577afe;
            background: #f7f9ff;
            padding-left: 17px;
            margin: 34px 0;
            font-style: italic;
            color: #3d4785;
            position: relative;
            border-radius: 3px;
        }

        .wp-post-content hr {
            border: none;
            border-top: 1.5px dashed #e0e9ff;
            margin: 44px 0 44px 0;
        }

        .wp-post-content img {
            max-width: 100%;
            height: auto;
            margin: 33px 0;
            border-radius: 8px;
            box-shadow: 0 1.5px 18px #dae3fa70;
            border: 1.5px solid #f2f4fc;
        }

        /* Creative Anim Columns/Grid  */
        .wp-columns {
            display: grid;
            gap: 28px;
            margin: 37px 0;
            animation: fadeInUp 0.7s;
        }

        .wp-columns[data-cols="2"] {
            grid-template-columns: repeat(2, 1fr);
        }

        .wp-columns[data-cols="3"] {
            grid-template-columns: repeat(3, 1fr);
        }

        .wp-columns>div {
            background: #f8fbff;
            border-radius: 10px;
            padding: 19px 18px 12px 17px;
            box-shadow: 0 1px 12px #e8e9f5;
            transition: box-shadow .19s;
        }

        .wp-columns>div:hover {
            box-shadow: 0 2px 26px #7989e720;
        }

        /* Creative Accordion */
        .wp-accordion details {
            border: 1.8px solid #e4e8fa;
            border-radius: 5px;
            padding: 10px 14px 10px 17px;
            margin-bottom: 11px;
            background: #f6f8fd;
            transition: box-shadow .17s;
            box-shadow: 0 1px 10px #e0ecfb63;
        }

        .wp-accordion details[open] {
            box-shadow: 0 3px 16px #d4dafe2c;
            border-color: #a7bcfa;
        }

        .wp-accordion summary {
            cursor: pointer;
            font-weight: 700;
            color: #3858e9;
            letter-spacing: .8px;
        }

        /* Fade-in animation for content */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(24px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeUp {
            animation: fadeInUp .7s;
        }

        @media (max-width: 1020px) {
            .creative-post-wrapper {
                padding: 30px 6vw 20px 6vw;
            }
        }

        @media (max-width: 768px) {
            .creative-post-wrapper {
                padding: 15px 1.8vw 13px 1.8vw;
            }

            .wp-post-title {
                font-size: 28px;
            }
        }
    </style>

    <div class="creative-post-wrapper fadeUp">

        {{-- Dynamic creative back button --}}
        @if(session()->has('admin_name') && !empty(session('admin_name')))
        <a href="{{ $backUrl }}" class="creative-back-link" title="Go back to Dashboard">
            <svg viewBox="0 0 24 24">
                <path d="M11.67 3.87L9.9 5.63L15.26 11H4v2h11.25l-5.35 5.36l1.77 1.76L20.36 12z" />
            </svg>
            Back to {{ $backTitle }}
        </a>
        @endif

        {{-- Title --}}
        <h1 class="wp-post-title">{{ $blog->title }}</h1>

        {{-- Meta --}}
        <div class="wp-post-meta">
            <span>
                <i class="bi bi-calendar3-event" style="margin-right:5px"></i>
                Published on {{ $blog->created_at->format('F d, Y') }}
            </span>
            <span style="margin-left:18px;">
                <i class="bi bi-person-fill" style="margin-right:5px"></i>
                {{ $blog->author->name ?? 'Admin' }}
            </span>
        </div>

        {{-- Content --}}
        <div class="wp-post-content fadeUp">
            @php
            $blocks = json_decode($blog->content, true);
            @endphp

            @if($blocks)
            @foreach($blocks as $block)

            {{-- Simple HTML blocks --}}
            @if(isset($block['content']))
            {!! $block['content'] !!}
            @endif
            {{-- IMAGE BLOCK --}}
            @if(($block['type'] ?? '') === 'image' && !empty($block['url']))
            <img src="{{ asset(ltrim($block['url'], '/')) }}" alt="">
            @endif

            {{-- Separator --}}
            @if(($block['type'] ?? '') === 'separator')
            <hr>
            @endif

            {{-- Spacer --}}
            @if(($block['type'] ?? '') === 'spacer')
            <div style="height:32px"></div>
            @endif

            {{-- Columns / Grid --}}
            @if(in_array($block['type'] ?? '', ['columns','grid']) && isset($block['columns']))
            <div class="wp-columns" data-cols="{{ count($block['columns']) }}">
                @foreach($block['columns'] as $col)
                <div>{!! $col !!}</div>
                @endforeach
            </div>
            @endif

            {{-- Accordion --}}
            @if(($block['type'] ?? '') === 'accordion' && isset($block['items']))
            <div class="wp-accordion">
                @foreach($block['items'] as $item)
                <details>
                    <summary>{!! $item['title'] !!}</summary>
                    <div>{!! $item['body'] !!}</div>
                </details>
                @endforeach
            </div>
            @endif

            @endforeach
            @endif
        </div>
    </div>
    @endsection