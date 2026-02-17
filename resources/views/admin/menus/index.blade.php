@extends('admin.layouts.app')

@section('content')
@php
$backUrl = route('admin.dashboard');
$backTitle = 'Dashboard';
@endphp

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <span style="font-size:1.21em;vertical-align:-0.18em;">🍔</span> Menus
        </h2>
        <div>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary me-2">
                <span style="font-size: 1.15em; vertical-align: -0.14em;">+</span> Create Menu
            </a>
            <a href="{{ route('admin.menu-items.index') }}" class="btn btn-outline-secondary">
                Menu Items
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Icon</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $m)
                        <tr>
                            <td>{{ $m->id }}</td>
                            <td>{{ $m->title }}</td>
                            <td>
                                @if($m->description)
                                <span class="text-muted" style="font-size: 0.97em;">{{ $m->description }}</span>
                                @else
                                <span class="text-secondary" style="font-size: 0.95em;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($m->icon)
                                <span class="badge bg-light text-dark" style="font-size: 1.07em;">{{ $m->icon }}</span>
                                @else
                                <span class="text-secondary">—</span>
                                @endif
                            </td>
                            <td>{{ $m->sort_order }}</td>
                            <td>
                                @if($m->status == 'active')
                                <span class="badge rounded-pill bg-success px-3 py-2">Active</span>
                                @else
                                <span class="badge rounded-pill bg-danger bg-opacity-25 text-danger px-3 py-2">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.menus.edit', $m->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Edit {{ $m->title }}">
                                        Edit
                                    </a>
                                    <form method="POST"
                                        action="{{ route('admin.menus.destroy', $m->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this menu?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3 text-center">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
</div>

@endsection