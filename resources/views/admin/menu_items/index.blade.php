@extends('admin.layouts.app')

@section('content')

@php
$backUrl = route('admin.dashboard');
$backTitle = 'Dashboard';
@endphp

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>
            <span style="font-size:1.21em;vertical-align:-0.18em;">🍔</span> Menu Items
        </h2>
        <div>
            <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary me-2">
                <span style="font-size: 1.15em; vertical-align: -0.14em;">+</span> Add New Item
            </a>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">
                Go to Menus
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width:180px;">Menu</th>
                        <th>Title</th>
                        <th style="width:160px;">Parent</th>
                        <th style="width:80px;">Order</th>
                        <th style="width:90px;">Status</th>
                        <th class="text-center" style="width:160px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i)
                    <tr>
                        <td>
                            @if($i->parent_type === 'menu' && $i->menuParent)
                            {{ $i->menuParent->title }}
                            @elseif($i->parent_type === 'menu_item' && $i->itemParent && $i->itemParent->menuParent)
                            {{ $i->itemParent->menuParent->title }}
                            @else
                            <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            {{ $i->title }}
                            @if($i->icon)
                            <span class="ms-1" style="font-size:1.15em;" title="Icon">
                                {{ $i->icon }}
                            </span>
                            @endif
                            @if($i->url)
                            <span title="Has URL" style="color:#888; margin-left:7px;">🔗</span>
                            @endif
                        </td>
                        <td>
                            @if($i->parent_type === 'menu' && $i->menuParent)
                            <span class="text-muted">—</span>
                            @elseif($i->parent_type === 'menu_item' && $i->itemParent)
                            {{ $i->itemParent->title }}
                            @else
                            <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>{{ $i->sort_order }}</td>
                        <td>
                            @if($i->status === 'active')
                            <span class="badge rounded-pill bg-success px-3 py-2">Active</span>
                            @else
                            <span class="badge rounded-pill bg-danger bg-opacity-25 text-danger px-3 py-2">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.menu-items.edit', $i->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.menu-items.destroy', $i->id) }}" class="d-inline ms-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this menu item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            No menu items found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Add pagination controls --}}
        @if(method_exists($items, 'links'))
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $items->links() }}
            </div>
        </div>
        @endif

    </div>
</div>

@endsection