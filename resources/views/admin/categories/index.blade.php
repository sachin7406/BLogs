@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-semibold mb-0">Categories</h4>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Add Category</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Category name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Category List</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($category->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="d-inline-flex align-items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control form-control-sm" style="max-width:180px;">
                                    <select name="status" class="form-control form-control-sm" style="max-width:120px;">
                                        <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                                <form method="POST" action="{{ route('admin.categories.delete', $category->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No categories available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
