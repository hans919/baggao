<?php
$current_admin_page = 'users';
$page_title = 'Add New User';
$page_description = 'Create a new user account with appropriate permissions';
$breadcrumbs = [
    ['title' => 'User Accounts', 'url' => BASE_URL . 'admin/users'],
    ['title' => 'Add New User', 'url' => '#']
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
        <h1 class="h3 mb-2 text-gradient">Add New User Account</h1>
        <p class="text-muted mb-0">Create a new user account with appropriate access permissions</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Users
        </a>
    </div>
</div>

<form method="POST" action="<?= BASE_URL ?>admin/add_user" id="addUserForm" novalidate>
    <div class="row g-4">
        <!-- Left Column - Basic Information -->
        <div class="col-lg-8">
            <!-- Basic Information Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-person text-primary"></i>
                        </div>
                        Basic Information
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="full_name" class="form-label fw-semibold">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required 
                                   placeholder="Enter full name (e.g., Juan Dela Cruz)">
                            <div class="invalid-feedback">Please provide a full name.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       placeholder="user@baggao.gov.ph">
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">
                                Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="username" name="username" required 
                                       placeholder="Username (auto-generated from name)">
                                <div class="invalid-feedback">Please provide a username.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-shield-lock text-warning"></i>
                        </div>
                        Security Settings
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required minlength="6" 
                                       placeholder="Enter secure password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="bi bi-eye" id="passwordToggle"></i>
                                </button>
                                <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                            </div>
                            <small class="text-muted">Minimum 6 characters required</small>
                        </div>

                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label fw-semibold">
                                Confirm Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
                                       placeholder="Re-enter password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                    <i class="bi bi-eye" id="confirmPasswordToggle"></i>
                                </button>
                                <div class="invalid-feedback">Passwords must match.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="mt-3">
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
                </div>
            </div>
        </div>

        <!-- Right Column - Role & Settings -->
        <div class="col-lg-4">
            <!-- Role & Permissions Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0">Role & Permissions</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">
                            User Role <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="role" name="role" required onchange="updateRoleDescription()">
                            <option value="">Select Role</option>
                            <option value="admin">Administrator</option>
                            <option value="councilor">Councilor</option>
                            <option value="user">Regular User</option>
                        </select>
                        <div class="invalid-feedback">Please select a user role.</div>
                    </div>

                    <!-- Role Description -->
                    <div id="roleDescription" class="alert alert-info d-none">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle me-2 mt-1"></i>
                            <div>
                                <div class="fw-semibold mb-1" id="roleTitle"></div>
                                <small id="roleDetails"></small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Account Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <small class="text-muted">Active users can log in and access the system</small>
                    </div>
                </div>
            </div>

            <!-- Councilor Link Card -->
            <div class="card border-0 shadow-sm mb-4" id="councilorLinkCard" style="display: none;">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0">Link to Councilor</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <label for="councilor_id" class="form-label fw-semibold">Select Councilor</label>
                        <select class="form-select" id="councilor_id" name="councilor_id">
                            <option value="">No Councilor Selected</option>
                            <?php foreach ($councilors as $councilor): ?>
                                <option value="<?= $councilor['id'] ?>"><?= htmlspecialchars($councilor['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Link this user account to a councilor profile</small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-plus-lg me-2"></i>Create User Account
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="generateRandomPassword()">
                            <i class="bi bi-shuffle me-2"></i>Generate Password
                        </button>
                        <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Role descriptions
const roleDescriptions = {
    'admin': {
        title: 'Administrator',
        details: 'Full system access. Can manage all content, users, and system settings.'
    },
    'councilor': {
        title: 'Councilor',
        details: 'Council member access. Can manage legislative documents and view reports.'
    },
    'user': {
        title: 'Regular User',
        details: 'Limited access. Can view public content and basic functionality.'
    }
};

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

// Update role description
function updateRoleDescription() {
    const roleSelect = document.getElementById('role');
    const roleDescription = document.getElementById('roleDescription');
    const roleTitle = document.getElementById('roleTitle');
    const roleDetails = document.getElementById('roleDetails');
    const councilorCard = document.getElementById('councilorLinkCard');
    
    const selectedRole = roleSelect.value;
    
    if (selectedRole && roleDescriptions[selectedRole]) {
        const desc = roleDescriptions[selectedRole];
        roleTitle.textContent = desc.title;
        roleDetails.textContent = desc.details;
        roleDescription.classList.remove('d-none');
        
        // Show councilor link card only for councilor role
        if (selectedRole === 'councilor') {
            councilorCard.style.display = 'block';
            document.getElementById('councilor_id').setAttribute('required', 'required');
        } else {
            councilorCard.style.display = 'none';
            document.getElementById('councilor_id').removeAttribute('required');
            document.getElementById('councilor_id').value = '';
        }
    } else {
        roleDescription.classList.add('d-none');
        councilorCard.style.display = 'none';
        document.getElementById('councilor_id').removeAttribute('required');
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
    
    document.getElementById('password').value = password;
    document.getElementById('confirm_password').value = password;
    checkPasswordStrength(password);
    
    // Show generated password notification
    showToast('Password generated successfully!', 'success');
}

// Form validation
function validateForm() {
    const form = document.getElementById('addUserForm');
    const password = document.getElementById('password').value;
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
    document.getElementById('password').addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
    
    // Confirm password validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        if (this.value !== password) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Form submission
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.classList.add('was-validated');
    });
    
    // Auto-generate username from full name
    document.getElementById('full_name').addEventListener('input', function() {
        const fullName = this.value.toLowerCase().replace(/\s+/g, '.');
        const username = fullName.substring(0, 20); // Limit length
        document.getElementById('username').value = username;
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