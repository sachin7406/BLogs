@props(['item'])

@php
use Illuminate\Support\Facades\Route;

$link = '#';

if ($item->route_name && Route::has($item->route_name)) {
$link = route($item->route_name);
} elseif ($item->url) {
$link = url($item->url);
}
@endphp

<a href="{{ $link }}" class="spa-link nav-link p-0">
    <div style="margin-bottom: 10px;">
        <span class="sub-title">{{ $item->title }}</span><br>
        @if($item->description)
        <span class="sub-caption">{{ $item->description }}</span>
        @endif
    </div>
</a>

{{-- level 3 children --}}
@if($item->childrenRecursive->count())
@foreach($item->childrenRecursive as $sub)
<a href="{{ $sub->url ?? '#' }}"
    class="spa-link nav-link p-0 ms-3">
    └ {{ $sub->title }}
</a>
@endforeach
@endif