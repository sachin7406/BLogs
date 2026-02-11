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
                        <small class="text-muted" id="emailHelp">
                            Only <strong>@gmail.com and @ddsplm.com</strong> email addresses are accepted.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="6">
                        <small class="text-muted" id="passwordHelp">
                            Required for new user
                            <ul class="mb-0 mt-1 ps-3" style="font-size:0.92em;">
                                <li>Password should be at least 6 characters long.</li>
                                <li>Choose a secure password.</li>
                            </ul>
                        </small>
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
    // Validation functions for email and password
    function validateEmailField(emailInput, emailHelp) {
        const emailValue = emailInput.value.trim().toLowerCase();
        let isValid = emailValue.endsWith('@gmail.com') || emailValue.endsWith('@ddsplm.com');
        if (!isValid) {
            emailInput.classList.add('is-invalid');
            emailHelp.innerHTML = '<span class="text-danger">Only <strong>@gmail.com</strong> or <strong>@ddsplm.com</strong> email addresses are allowed.</span>';
        } else {
            emailInput.classList.remove('is-invalid');
            emailHelp.innerHTML = 'Only <strong>@gmail.com and @ddsplm.com</strong> email addresses are accepted.';
        }
        return isValid;
    }

    function validatePasswordField(passwordInput, helpText, isNewUser) {
        const passwordVal = passwordInput.value;
        if (!isNewUser && passwordVal === '') {
            // Editing, blank password is fine
            passwordInput.classList.remove('is-invalid');
            helpText.innerHTML = 'Leave blank to keep existing password ' +
                '<ul class="mb-0 mt-1 ps-3" style="font-size:0.92em;"><li>Password should be at least 6 characters long.</li><li>Choose a secure password.</li></ul>';
            return true;
        }
        if (passwordVal.length < 6) {
            passwordInput.classList.add('is-invalid');
            helpText.innerHTML = '<span class="text-danger">Password must be at least 6 characters long.</span>' +
                '<ul class="mb-0 mt-1 ps-3" style="font-size:0.92em;"><li>Password should be at least 6 characters long.</li><li>Choose a secure password.</li></ul>';
            return false;
        } else {
            passwordInput.classList.remove('is-invalid');
            helpText.innerHTML = (isNewUser ? 'Required for new user ' : 'Leave blank to keep existing password ') +
                '<ul class="mb-0 mt-1 ps-3" style="font-size:0.92em;"><li>Password should be at least 6 characters long.</li><li>Choose a secure password.</li></ul>';
            return true;
        }
    }

    // Add event listeners for real-time validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('userForm');
        const userId = document.getElementById('user_id');
        const passwordInput = document.getElementById('password');
        const helpText = document.getElementById('passwordHelp');
        const emailInput = document.getElementById('email');
        const emailHelp = document.getElementById('emailHelp');

        // Switch password requirement notes depending on new/edit
        function updatePasswordHelp() {
            const id = userId.value;
            if (id) {
                passwordInput.removeAttribute('required');
                helpText.childNodes[0].nodeValue = 'Leave blank to keep existing password ';
            } else {
                passwordInput.setAttribute('required', 'required');
                helpText.childNodes[0].nodeValue = 'Required for new user ';
            }
        }
        updatePasswordHelp();

        userId.addEventListener('change', updatePasswordHelp);

        passwordInput.addEventListener('input', function() {
            const isNewUser = !userId.value;
            validatePasswordField(passwordInput, helpText, isNewUser);
        });
        passwordInput.addEventListener('change', function() {
            const isNewUser = !userId.value;
            validatePasswordField(passwordInput, helpText, isNewUser);
        });
        emailInput.addEventListener('input', function() {
            validateEmailField(emailInput, emailHelp);
        });
        emailInput.addEventListener('change', function() {
            validateEmailField(emailInput, emailHelp);
        });

        form.addEventListener('submit', function(e) {
            // Get user id for context (new/edit)
            const isNewUser = !userId.value;

            // Password help/requirement update for new/edit
            updatePasswordHelp();

            // Validate email
            const emailValid = validateEmailField(emailInput, emailHelp);
            if (!emailValid) {
                e.preventDefault();
                emailInput.focus();
                return false;
            }

            // Validate password min length (only if field is not empty or always for new user)
            const passwordValid = validatePasswordField(passwordInput, helpText, isNewUser);
            if (!passwordValid) {
                e.preventDefault();
                passwordInput.focus();
                return false;
            }
        });
    });
</script>