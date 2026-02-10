<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <input type="hidden" name="user_id" id="user_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small class="text-muted" id="passwordHelp">Required for new user</small>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('userForm').addEventListener('submit', function(e) {
        // Allow normal form submission for now, since prior JavaScript AJAX submission isn't working
        // If you want AJAX, use the below, but include error/success handling:
        // 
        // e.preventDefault();
        // const formData = new FormData(this);
        // let id = formData.get('user_id');
        // let url = id ? `/admin/users/${id}` : `/admin/users`;
        // let method = id ? 'PUT' : 'POST';
        // fetch(url, {
        //     method: method,
        //     headers: {
        //         'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
        //         'Accept': 'application/json',
        //     },
        //     body: formData
        // })
        // .then(res => res.json())
        // .then(data => {
        //     if (data.message) {
        //         location.reload();
        //     } else {
        //         alert('Error');
        //     }
        // })
        // .catch(err => alert('Error: ' + err));
        // 
        // For fallback, remove e.preventDefault() (as above) for classic POST request

        // For edit: Remove password requirement and password help if editing (better UX)
        let id = document.getElementById('user_id').value;
        let passwordInput = document.getElementById('password');
        let helpText = document.getElementById('passwordHelp');
        if (id) {
            passwordInput.removeAttribute('required');
            helpText.innerText = 'Leave blank to keep existing password';
        } else {
            passwordInput.setAttribute('required', 'required');
            helpText.innerText = 'Required for new user';
        }
    });
</script>