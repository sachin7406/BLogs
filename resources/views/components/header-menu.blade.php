@php
use Illuminate\Support\Str;

$menus = \App\Models\Menu::with([
'items.childrenRecursive'
])
->where('status','active')
->orderBy('sort_order')
->get();
@endphp

<header class="main-header">

    {{-- TOP BAR --}}
    <div class="top-header d-none d-md-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-envelope-fill"></i> info@ddsplm.com
                    <span class="ms-3">
                        <i class="bi bi-telephone-fill"></i> +91-9350633147
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/images/img/logo/DDS Logo Original.png') }}"
                    alt="Logo" height="40">
            </a>

            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">

                <ul class="navbar-nav ms-auto">

                    @foreach($menus as $menu)

                    @php
                    $hasChildren = $menu->items->count() > 0;
                    $slug = Str::slug($menu->title);
                    @endphp

                    @if(!$hasChildren)

                    <li class="nav-item">
                        <a class="nav-link spa-link"
                            href="{{ $menu->url ?? '#' }}">
                            {{ $menu->title }}
                        </a>
                    </li>

                    @else

                    <li class="nav-item dropdown position-static">

                        <a class="nav-link dropdown-toggles"
                            href="#"
                            id="{{ $slug }}Dropdown">
                            {{ $menu->title }}
                        </a>

                        <div class="dropdown-menu mega-menu level-1 {{ $slug }}-menu w-100 mt-0 border-0 rounded-0">

                            <div class="close-x">&times;</div>

                            <div class="row">

                                {{-- LEFT PANEL --}}
                                <div class="col-lg-3 menu-left">
                                    <h5 class="mega-title">{{ $menu->title }}</h5>

                                    @foreach($menu->items as $item)
                                    <a class="sol-left {{ $loop->first ? 'active' : '' }}"
                                        data-target="box-{{ $item->id }}">
                                        {{ $item->title }}
                                        <span style="float:right;">&gt;</span>
                                    </a>
                                    @endforeach
                                </div>

                                {{-- CENTER CONTENT --}}
                                <div class="col-md-7 mega-links">

                                    <div class="mobile-back d-block d-lg-none"
                                        style="color:#fff; padding:10px;">
                                        ← Back
                                    </div>

                                    @foreach($menu->items as $item)

                                    <div class="sol-box {{ $loop->first ? '' : 'd-none' }}"
                                        id="box-{{ $item->id }}">

                                        <h5 class="mega-title">{{ $item->title }}</h5>

                                        @php
                                        $children = $item->childrenRecursive;
                                        $childCount = $children->count();
                                        $hasGrandchildren = $children->contains(function($child) {
                                        return $child->childrenRecursive->count() > 0;
                                        });
                                        @endphp

                                        {{-- =========================
                                        SIMPLE LIST (No Grandchildren)
                                    ========================== --}}
                                        @if(!$hasGrandchildren)

                                        <div class="row">
                                            <div class="col-12">

                                                @foreach($children as $child)
                                                <a href="{{ $child->url ?? '#' }}"
                                                    class="spa-link nav-link p-0">
                                                    <div style="margin-bottom:10px;">
                                                        <span class="sub-title">
                                                            {{ $child->title }}
                                                        </span>
                                                        <br>
                                                        <span class="sub-caption">
                                                            {{ $child->description ?? $child->title }}
                                                        </span>
                                                    </div>
                                                </a>
                                                @endforeach

                                            </div>
                                        </div>

                                        {{-- =========================
                                            SIMULATION STYLE (>=3 children + grandchildren)
                                        ========================== --}}
                                        @elseif($childCount >= 3)

                                        <div class="row">

                                            {{-- LEFT SELECTOR --}}
                                            <div class="col-md-5">

                                                @foreach($children as $child)
                                                <div class="sim-toggle {{ $loop->first ? 'active' : '' }}"
                                                    data-target="tab-{{ $child->id }}">

                                                    <span class="sub-title">
                                                        {{ $child->title }}
                                                    </span>

                                                    @if($child->description)
                                                    <br>
                                                    <span class="sub-caption">
                                                        {{ $child->description }}
                                                    </span>
                                                    @endif

                                                </div>
                                                @endforeach

                                            </div>

                                            {{-- RIGHT PANEL --}}
                                            <div class="col-md-7">

                                                @foreach($children as $child)

                                                <div class="sim-panel tab-{{ $child->id }} {{ $loop->first ? 'show' : '' }}">

                                                    @foreach($child->childrenRecursive as $sub)
                                                    <a href="{{ $sub->url ?? '#' }}"
                                                        class="spa-link">
                                                        {{ $sub->title }}
                                                    </a>
                                                    @endforeach

                                                </div>

                                                @endforeach

                                            </div>

                                        </div>

                                        {{-- =========================
                                            COLUMN GROUP (2 children)
                                        ========================== --}}
                                        @else

                                        <div class="row">
                                            @foreach($children as $child)
                                            <div class="col-md-6">
                                                <a href="#" class="spa-link nav-link p-0">
                                                    <div style="margin-bottom: 18px;">
                                                        <span class="sub-title">{{ $child->title }}</span><br>
                                                        <span class="sub-caption">
                                                            {{ $child->description }}
                                                        </span>
                                                    </div>
                                                </a>
                                                @foreach($child->childrenRecursive as $sub)
                                                <a href="{{ $sub->url ?? '#' }}" class="spa-link nav-link p-0">
                                                    <div style="margin-bottom: 10px;">
                                                        <span class="sub-title">
                                                            {{ $sub->title }}
                                                            @if(Str::contains(strtolower($sub->title), 'solid edge'))
                                                            <span style="font-size: 15px; font-weight:400; vertical-align: super; margin-left: 2px;">&#8599;</span>
                                                            @endif
                                                        </span><br>
                                                        <span class="sub-caption">
                                                            {{ $sub->description }}
                                                        </span>
                                                    </div>
                                                </a>
                                                @endforeach
                                            </div>
                                            @endforeach
                                        </div>

                                        @endif

                                    </div>

                                    @endforeach

                                </div>

                                {{-- RIGHT COLUMN --}}
                                <div class="col-md-2 mega-right">
                                    <div class="right-title">QUICK LINKS</div>
                                    <a href="/blogs">Blogs</a>
                                    <a href="/casestudy">Case studies</a>
                                </div>

                            </div>

                        </div>

                    </li>

                    @endif

                    @endforeach

                </ul>

            </div>
        </div>
    </nav>
</header>