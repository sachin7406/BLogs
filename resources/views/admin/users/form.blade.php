<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Password {{ isset($user) ? '(leave blank to keep)' : '' }}</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label>Role</label>
    <select name="role" class="form-control">
        <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
        <option value="user"  {{ (old('role', $user->role ?? '') == 'user') ? 'selected' : '' }}>User</option>
    </select>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="active" {{ (old('status', $user->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ (old('status', $user->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
