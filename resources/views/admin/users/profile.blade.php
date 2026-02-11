@extends('admin.layouts.app')

@section('content')
<div class="container py-4" style="max-width:600px;">
    <!-- Profile Header -->
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">
            <div>
                <img src="https://i.pravatar.cc/64?u={{ $user->id ?? '' }}" alt="User Avatar" class="rounded-circle me-3" width="64" height="64">
            </div>
            <div>
                <h4 class="mb-1">{{ $user->name ?? '-' }}</h4>
                <p class="mb-0 text-muted">{{ $user->email ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- User Blog Stats -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Blog Activity</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Blogs Created
                    <span class="badge bg-primary">{{ $user->blogs_count ?? 0 }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Account Active From
                    <span>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Active Days
                    @php
                        $activeDays = $user->created_at ? now()->diffInDays($user->created_at) + 1 : 0;
                    @endphp
                    <span>{{ $activeDays }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- User Settings (Edit Form) -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Settings</h5>
            <form action="{{ route('admin.users.updateProfile', $user->id ?? 0) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control" 
                        id="name" 
                        value="{{ old('name', $user->name ?? '') }}" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control" 
                        id="email" 
                        value="{{ old('email', $user->email ?? '') }}" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password <span class="text-muted">(leave blank to keep unchanged)</span></label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control" 
                        id="password" 
                        minlength="6">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>


@endsection