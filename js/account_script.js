// account_script.js

document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const accountsTable = $('#accountsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "order": [[0, 'desc']],
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search accounts...",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });

    // Custom search functionality
    $('#searchInput').on('keyup', function() {
        accountsTable.search(this.value).draw();
    });

    // Filter by status
    $('#statusFilter').on('change', function() {
        const value = this.value;
        accountsTable.column(3).search(value).draw();
    });

    // Password toggle functionality
    function setupPasswordToggle(buttonId, inputId) {
        const toggleButton = document.getElementById(buttonId);
        const passwordInput = document.getElementById(inputId);
        
        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    }

    // Setup password toggles
    setupPasswordToggle('togglePassword', 'password');
    setupPasswordToggle('toggleEditPassword', 'edit_password');
    setupPasswordToggle('toggleNewPassword', 'new_password');

    // Password strength meter
    function checkPasswordStrength(password, strengthBarId, feedbackId) {
        const strengthBar = document.getElementById(strengthBarId);
        const feedback = document.getElementById(feedbackId);
        
        if (!password) {
            strengthBar.className = 'strength-fill';
            strengthBar.style.width = '0%';
            feedback.textContent = '';
            return;
        }

        let strength = 0;
        let feedbackText = '';

        // Check password length
        if (password.length >= 8) strength += 25;
        if (password.length >= 12) strength += 25;

        // Check for character variety
        if (/[a-z]/.test(password)) strength += 10;
        if (/[A-Z]/.test(password)) strength += 10;
        if (/[0-9]/.test(password)) strength += 15;
        if (/[^A-Za-z0-9]/.test(password)) strength += 15;

        // Update strength bar
        strengthBar.className = 'strength-fill';
        strengthBar.style.width = strength + '%';

        if (strength < 25) {
            strengthBar.classList.add('strength-weak');
            feedbackText = 'Weak password';
        } else if (strength < 50) {
            strengthBar.classList.add('strength-fair');
            feedbackText = 'Fair password';
        } else if (strength < 75) {
            strengthBar.classList.add('strength-good');
            feedbackText = 'Good password';
        } else {
            strengthBar.classList.add('strength-strong');
            feedbackText = 'Strong password';
        }

        feedback.textContent = feedbackText;
    }

    // Password confirmation check
    function checkPasswordMatch(passwordId, confirmId, feedbackId) {
        const password = document.getElementById(passwordId).value;
        const confirmPassword = document.getElementById(confirmId).value;
        const feedback = document.getElementById(feedbackId);

        if (!confirmPassword) {
            feedback.textContent = '';
            feedback.className = 'form-text';
            return;
        }

        if (password === confirmPassword) {
            feedback.textContent = 'Passwords match';
            feedback.className = 'form-text text-success';
        } else {
            feedback.textContent = 'Passwords do not match';
            feedback.className = 'form-text text-danger';
        }
    }

    // Setup password strength and match checking
    document.getElementById('password').addEventListener('input', function() {
        checkPasswordStrength(this.value, 'passwordStrength', 'passwordFeedback');
        checkPasswordMatch('password', 'confirm_password', 'passwordMatch');
    });

    document.getElementById('confirm_password').addEventListener('input', function() {
        checkPasswordMatch('password', 'confirm_password', 'passwordMatch');
    });

    document.getElementById('edit_password').addEventListener('input', function() {
        checkPasswordStrength(this.value, 'editPasswordStrength', 'editPasswordFeedback');
    });

    document.getElementById('new_password').addEventListener('input', function() {
        checkPasswordStrength(this.value, 'newPasswordStrength', 'newPasswordFeedback');
        checkPasswordMatch('new_password', 'confirm_new_password', 'newPasswordMatch');
    });

    document.getElementById('confirm_new_password').addEventListener('input', function() {
        checkPasswordMatch('new_password', 'confirm_new_password', 'newPasswordMatch');
    });

    // Edit Account Modal Handler
    const editAccountModal = document.getElementById('editAccountModal');
    if (editAccountModal) {
        editAccountModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const adminId = button.getAttribute('data-id');
            const adminName = button.getAttribute('data-name');
            const adminUsername = button.getAttribute('data-username');

            document.getElementById('edit_admin_id').value = adminId;
            document.getElementById('edit_name').value = adminName;
            document.getElementById('edit_username').value = adminUsername;
        });
    }

    // Reset Password Modal Handler
    const resetPasswordModal = document.getElementById('resetPasswordModal');
    if (resetPasswordModal) {
        resetPasswordModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const adminId = button.getAttribute('data-id');
            const adminName = button.getAttribute('data-name');

            document.getElementById('reset_admin_id').value = adminId;
            document.getElementById('reset_admin_name').textContent = adminName;
        });
    }

    // ===== Delete Account Handler =====
        $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();

        const adminId = $(this).data('id');
        const adminName = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            text: `Delete account of ${adminName}? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_account.php',
                    type: 'POST',
                    data: { id: adminId },
                    success: function (response) {
                        if (response.trim() === 'success') {
                            Swal.fire(
                                'Deleted!',
                                `Account of ${adminName} has been deleted.`,
                                'success'
                            ).then(() => {
                                // 🔄 reload the whole page after the alert is closed
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Failed to delete account.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server error occurred.', 'error');
                    }
                });
            }
        });
    });


})
