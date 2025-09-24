<?php
$current_admin_page = 'users';
$page_title = 'Change Password';
$page_description = 'Change user account password';
$breadcrumbs = [
    ['title' => 'User Accounts', 'url' => BASE_URL . 'admin/users'],
    ['title' => 'Change Password', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<style>
    /* Ensure pure white background */
    .main-content {
        background-color: #ffffff !important;
    }
    
    .page-content {
        background-color: #ffffff !important;
    }
    
    .content-container {
        background-color: #ffffff !important;
    }
    
    /* Ensure cards have white background */
    .card {
        background-color: #ffffff !important;
    }
    
    /* Light background areas should be very light gray instead of off-white */
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    body, .wrapper, .main-wrapper {
        background-color: #ffffff !important;
    }
    
    /* Form inputs - ensure proper styling and text visibility */
    .form-control, .form-select {
        background-color: #ffffff !important;
        border: 1px solid #dee2e6 !important;
        color: #212529 !important;
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: #ffffff !important;
        border-color: #86b7fe !important;
        color: #212529 !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .form-control::placeholder {
        color: #6c757d;
        opacity: 0.75;
    }
    
    /* Input group styling */
    .input-group-text {
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        color: #495057 !important;
    }
    
    /* Labels */
    .form-label {
        color: #212529 !important;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    /* Button styling fixes */
    .btn-outline-secondary {
        color: #6c757d !important;
        border-color: #dee2e6 !important;
    }
    
    .btn-outline-secondary:hover {
        color: #fff !important;
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }
    
    /* Modal backgrounds */
    .modal-content {
        background-color: #ffffff !important;
    }
    
    /* Ensure text is visible in all states */
    input, select, textarea {
        color: #212529 !important;
    }
    
    /* Fix for any potential text color inheritance issues */
    .card-body {
        color: #212529 !important;
    }
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Change User Password</h1>
        <p class="text-muted mb-0">Update the password for this user account</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                <i class="bi bi-shield-lock me-1"></i>
                Password Update: <?= htmlspecialchars($user['full_name'] ?? 'User') ?>
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">User ID: #<?= $user['id'] ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>admin/edit_user/<?= $user['id'] ?>" class="btn btn-outline-info">
            <i class="bi bi-pencil me-1"></i>
            Edit User
        </a>
        <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Users
        </a>
    </div>
</div>

<!-- Success Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success border-0 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Error Messages -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger border-0 d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <!-- User Info Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-person text-info"></i>
                    </div>
                    User Information
                </h6>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex align-items-center">
                    <div class="bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-<?= $user['role'] === 'admin' ? 'shield-check' : ($user['role'] === 'councilor' ? 'person-badge' : 'person') ?> text-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?> fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold mb-1"><?= htmlspecialchars($user['full_name'] ?? '') ?></div>
                        <div class="text-muted mb-1">
                            <i class="bi bi-envelope me-1"></i>
                            <?= htmlspecialchars($user['email'] ?? '') ?>
                        </div>
                        <div class="text-muted">
                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?> bg-opacity-10 text-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?>">
                                <?= ucfirst($user['role'] ?? 'user') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <form method="POST" action="<?= BASE_URL ?>admin/change_password/<?= $user['id'] ?>" id="changePasswordForm" novalidate>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-shield-lock text-warning"></i>
                        </div>
                        Security Settings
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold">
                            New Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   required minlength="6" placeholder="Enter new secure password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                <i class="bi bi-eye" id="newPasswordToggle"></i>
                            </button>
                            <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                        </div>
                        <small class="text-muted">Minimum 6 characters required</small>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-semibold">
                            Confirm New Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   required placeholder="Re-enter new password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                <i class="bi bi-eye" id="confirmPasswordToggle"></i>
                            </button>
                            <div class="invalid-feedback">Passwords must match.</div>
                        </div>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <small class="fw-medium text-muted">Password Strength:</small>
                            <div class="ms-auto">
                                <span id="passwordStrength" class="badge bg-secondary">Not Set</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-info border-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle me-2 mt-1"></i>
                            <div>
                                <div class="fw-semibold mb-1">Security Notice</div>
                                <small>The user will need to use this new password for their next login. Consider sending them a secure notification about the password change.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning" id="submitBtn">
                            <i class="bi bi-shield-check me-2"></i>Update Password
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="generateRandomPassword()">
                            <i class="bi bi-shuffle me-2"></i>Generate Secure Password
                        </button>
                        <a href="<?= BASE_URL ?>admin/edit_user/<?= $user['id'] ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = document.getElementById(fieldId + 'Toggle');
    
    if (field.type === 'password') {
        field.type = 'text';
        toggle.classList.remove('bi-eye');
        toggle.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        toggle.classList.remove('bi-eye-slash');
        toggle.classList.add('bi-eye');
    }
}

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = '';
    
    if (password.length >= 8) strength += 20;
    if (password.match(/[a-z]/)) strength += 20;
    if (password.match(/[A-Z]/)) strength += 20;
    if (password.match(/[0-9]/)) strength += 20;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 20;
    
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrength');
    
    if (strength === 0) {
        feedback = 'Not Set';
        strengthBar.className = 'progress-bar';
        strengthBar.style.width = '0%';
    } else if (strength <= 40) {
        feedback = 'Weak';
        strengthBar.className = 'progress-bar bg-danger';
        strengthBar.style.width = strength + '%';
    } else if (strength <= 60) {
        feedback = 'Fair';
        strengthBar.className = 'progress-bar bg-warning';
        strengthBar.style.width = strength + '%';
    } else if (strength <= 80) {
        feedback = 'Good';
        strengthBar.className = 'progress-bar bg-info';
        strengthBar.style.width = strength + '%';
    } else {
        feedback = 'Strong';
        strengthBar.className = 'progress-bar bg-success';
        strengthBar.style.width = strength + '%';
    }
    
    strengthText.textContent = feedback;
    strengthText.className = `badge bg-${strength <= 40 ? 'danger' : strength <= 60 ? 'warning' : strength <= 80 ? 'info' : 'success'}`;
}

// Generate random password
function generateRandomPassword() {
    const length = 12;
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    let password = "";
    
    for (let i = 0; i < length; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }
    
    document.getElementById('new_password').value = password;
    document.getElementById('confirm_password').value = password;
    checkPasswordStrength(password);
    
    // Show generated password notification
    showToast('Secure password generated successfully!', 'success');
}

// Form validation
function validateForm() {
    const form = document.getElementById('changePasswordForm');
    const password = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Check if passwords match
    if (password !== confirmPassword) {
        document.getElementById('confirm_password').setCustomValidity('Passwords do not match');
    } else {
        document.getElementById('confirm_password').setCustomValidity('');
    }
    
    return form.checkValidity();
}

// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Password strength checking
    document.getElementById('new_password').addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
    
    // Confirm password validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('new_password').value;
        if (this.value !== password) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Form submission
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.classList.add('was-validated');
    });
});

// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('<?= $_SESSION['success'] ?>', 'success');
    });
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('<?= addslashes($_SESSION['error']) ?>', 'danger');
    });
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
</script>

<?php
$content = ob_get_clean();

// Include the admin layout
include __DIR__ . '/layout.php';
?>