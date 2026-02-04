@extends('admin.layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User Management</h5>
            <button class="btn btn-primary" onclick="openCreateModal()">+ Add User</button>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"
                                onclick="openEditModal({{ $user }})">
                                Edit
                            </button>

                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                class="d-inline"
                                onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>
</div>

@include('admin.users.modal')

<script>
    let modal = new bootstrap.Modal(document.getElementById('userModal'));

    function openCreateModal() {
        document.getElementById('userForm').reset();
        document.getElementById('user_id').value = '';
        document.getElementById('modalTitle').innerText = 'Add User';
        modal.show();
    }

    function openEditModal(user) {
        document.getElementById('user_id').value = user.id;
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
        document.getElementById('status').value = user.status;
        document.getElementById('password').value = '';
        document.getElementById('modalTitle').innerText = 'Edit User';
        modal.show();
    }

    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let id = document.getElementById('user_id').value;
        let url = id ? `/admin/users/${id}` : `/admin/users`;
        let method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: name.value,
                email: email.value,
                password: password.value,
                role: role.value,
                status: status.value
            })
        }).then(() => location.reload());
    });
</script>

@endsection