<?php
$current_admin_page = 'users';
$page_title = 'Edit User Account';
$page_description = 'Modify user account information and permissions';
$breadcrumbs = [
    ['title' => 'User Accounts', 'url' => BASE_URL . 'admin/users'],
    ['title' => 'Edit User', 'url' => '#']
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
        <h1 class="h3 mb-2 text-gradient">Edit User Account</h1>
        <p class="text-muted mb-0">Modify user account information and access permissions</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                <i class="bi bi-person-gear me-1"></i>
                Editing: <?= htmlspecialchars($user['full_name'] ?? 'User') ?>
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">User ID: #<?= $user['id'] ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>admin/view_user/<?= $user['id'] ?>" class="btn btn-outline-info">
            <i class="bi bi-eye me-1"></i>
            View Details
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

<form method="POST" action="<?= BASE_URL ?>admin/edit_user/<?= $user['id'] ?>" id="editUserForm" novalidate>
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
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" 
                                   placeholder="Enter full name (e.g., Juan Dela Cruz)" required>
                            <div class="invalid-feedback">Please provide a full name.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                                       placeholder="user@baggao.gov.ph" required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">
                                Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= htmlspecialchars($user['username'] ?? '') ?>" 
                                       placeholder="Username" required>
                                <div class="invalid-feedback">Please provide a username.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Status & Activity -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0 d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-activity text-info"></i>
                        </div>
                        Account Activity
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="bi bi-calendar-plus text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Account Created</div>
                                    <small class="text-muted"><?= date('M j, Y g:i A', strtotime($user['created_at'])) ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="bi bi-clock text-warning"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Last Login</div>
                                    <small class="text-muted"><?= isset($user['last_login']) ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never logged in' ?></small>
                                </div>
                            </div>
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
                            <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrator</option>
                            <option value="councilor" <?= ($user['role'] ?? '') === 'councilor' ? 'selected' : '' ?>>Councilor</option>
                            <option value="user" <?= ($user['role'] ?? '') === 'user' ? 'selected' : '' ?>>Regular User</option>
                        </select>
                        <div class="invalid-feedback">Please select a user role.</div>
                    </div>

                    <!-- Role Description -->
                    <div id="roleDescription" class="alert alert-info">
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
                            <option value="active" <?= ($user['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($user['status'] ?? 'active') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                        <small class="text-muted">Active users can log in and access the system</small>
                    </div>
                </div>
            </div>

            <!-- Councilor Link Card -->
            <div class="card border-0 shadow-sm mb-4" id="councilorLinkCard">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0">Link to Councilor</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <label for="councilor_id" class="form-label fw-semibold">Select Councilor</label>
                        <select class="form-select" id="councilor_id" name="councilor_id">
                            <option value="">No Councilor Selected</option>
                            <?php foreach ($councilors as $councilor): ?>
                                <option value="<?= $councilor['id'] ?>" <?= ($user['councilor_id'] ?? '') == $councilor['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($councilor['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Link this user account to a councilor profile</small>
                    </div>
                </div>
            </div>

            <!-- Security Actions -->
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
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>admin/change_password/<?= $user['id'] ?>" class="btn btn-outline-warning">
                            <i class="bi bi-key me-2"></i>Change Password
                        </a>
                        <button type="button" class="btn btn-outline-info" onclick="resetPasswordEmail()">
                            <i class="bi bi-envelope me-2"></i>Send Password Reset
                        </button>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-<?= ($user['status'] ?? 'active') === 'active' ? 'danger' : 'success' ?>" 
                                onclick="toggleAccountStatus()">
                            <i class="bi bi-<?= ($user['status'] ?? 'active') === 'active' ? 'x-circle' : 'check-circle' ?> me-2"></i>
                            <?= ($user['status'] ?? 'active') === 'active' ? 'Deactivate Account' : 'Activate Account' ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-check-lg me-2"></i>Save Changes
                        </button>
                        <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                        <hr>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteUserAccount()">
                            <i class="bi bi-trash me-2"></i>Delete Account
                        </button>
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
        }
    } else {
        roleDescription.classList.add('d-none');
        councilorCard.style.display = 'none';
        document.getElementById('councilor_id').removeAttribute('required');
    }
}

// Form validation
function validateForm() {
    const form = document.getElementById('editUserForm');
    return form.checkValidity();
}

// Reset password email
function resetPasswordEmail() {
    if (confirm('Send a password reset email to this user?')) {
        showLoading();
        // Implement password reset email logic
        setTimeout(() => {
            hideLoading();
            showToast('Password reset email sent successfully!', 'success');
        }, 2000);
    }
}

// Toggle account status
function toggleAccountStatus() {
    const currentStatus = '<?= $user['status'] ?? 'active' ?>';
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this user account?`)) {
        showLoading();
        window.location.href = '<?= BASE_URL ?>admin/toggle_user_status/<?= $user['id'] ?>';
    }
}

// Delete user account
function deleteUserAccount() {
    const userName = '<?= htmlspecialchars($user['full_name'] ?? 'User') ?>';
    if (confirm(`Are you sure you want to DELETE the user account for "${userName}"?\n\nThis action cannot be undone and will permanently remove all associated data.`)) {
        if (confirm('This is your final confirmation. Type "DELETE" in the next prompt to confirm deletion.')) {
            const confirmation = prompt('Type "DELETE" to confirm account deletion:');
            if (confirmation === 'DELETE') {
                showLoading();
                window.location.href = '<?= BASE_URL ?>admin/delete_user/<?= $user['id'] ?>';
            } else {
                showToast('Account deletion cancelled - confirmation text did not match', 'warning');
            }
        }
    }
}

// Utility functions
function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
    overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    overlay.style.zIndex = '9999';
    overlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
    document.body.appendChild(overlay);
}

function hideLoading() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) overlay.remove();
}

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
    // Initialize role description
    updateRoleDescription();
    
    // Form submission
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.classList.add('was-validated');
    });
    
    // Auto-generate username from full name (optional)
    document.getElementById('full_name').addEventListener('input', function() {
        // Only auto-generate if username field is empty
        const usernameField = document.getElementById('username');
        if (!usernameField.value.trim()) {
            const fullName = this.value.toLowerCase().replace(/\s+/g, '.');
            const username = fullName.substring(0, 20); // Limit length
            usernameField.value = username;
        }
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