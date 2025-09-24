<?php
$current_admin_page = 'users';
$page_title = 'User Accounts';
$page_description = 'Manage user accounts and permissions';
$breadcrumbs = [
    ['title' => 'User Accounts', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<style>
    /* Ensure pure white background for users page */
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
    
    .card-body {
        background-color: #ffffff !important;
    }
    
    .card-header {
        background-color: #ffffff !important;
    }
    
    .card-footer {
        background-color: #ffffff !important;
    }
    
    /* Light background areas should be very light gray instead of off-white */
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .table-light {
        background-color: #f8f9fa !important;
    }
    
    /* Ensure table has white background */
    .table {
        background-color: #ffffff !important;
    }
    
    .table tbody tr {
        background-color: #ffffff !important;
    }
    
    /* Override any gradient or colored backgrounds */
    .admin-wrapper,
    .admin-content,
    body {
        background-color: #ffffff !important;
    }
    
    /* Form inputs - ensure proper styling and visibility */
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
    
    /* Select dropdowns specific styling */
    .form-select option {
        background-color: #ffffff !important;
        color: #212529 !important;
    }
    
    /* Filter controls container */
    .card-body .row .col-md-2 .form-select,
    .card-body .row .col-md-4 .form-control {
        min-height: 38px;
        background-color: #ffffff !important;
        border: 1px solid #dee2e6 !important;
        color: #495057 !important;
    }
    
    /* Button styling in filters */
    .btn-outline-secondary {
        color: #6c757d !important;
        border-color: #dee2e6 !important;
        background-color: #ffffff !important;
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
</style>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">User Account Management</h1>
        <p class="text-muted mb-0">Manage user accounts, permissions, and access control</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                <i class="bi bi-people me-1"></i>
                <?= count($users ?? []) ?> Total Users
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Last updated: <?= date('M j, Y g:i A') ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="refreshUsers()">
            <i class="bi bi-arrow-clockwise me-1"></i>
            Refresh
        </button>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-download me-1"></i>
                Export
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" onclick="exportData('pdf')">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Export as PDF
                </a></li>
                <li><a class="dropdown-item" href="#" onclick="exportData('excel')">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export as Excel
                </a></li>
                <li><a class="dropdown-item" href="#" onclick="exportData('csv')">
                    <i class="bi bi-file-earmark-text me-2"></i>Export as CSV
                </a></li>
            </ul>
        </div>
        <a href="<?= BASE_URL ?>admin/add_user" class="btn btn-primary d-flex align-items-center hover-shadow">
            <i class="bi bi-plus-lg me-2"></i>Add New User
        </a>
    </div>
</div>

<!-- Enhanced Search & Filter Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control ps-5" placeholder="Search users..." id="searchInput" onkeyup="filterTable()">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="roleFilter" onchange="filterTable()" title="Filter by Role">
                    <option value="">🔍 All Roles</option>
                    <option value="admin">👑 Admin</option>
                    <option value="councilor">🏛️ Councilor</option>
                    <option value="user">👤 User</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter" onchange="filterTable()" title="Filter by Status">
                    <option value="">📊 All Status</option>
                    <option value="active">✅ Active</option>
                    <option value="inactive">❌ Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy" onchange="sortTable()" title="Sort Options">
                    <option value="name_asc">📝 Name (A-Z)</option>
                    <option value="name_desc">📝 Name (Z-A)</option>
                    <option value="date_desc">📅 Date (Newest)</option>
                    <option value="date_asc">📅 Date (Oldest)</option>
                    <option value="role_asc">🎭 Role</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="btn-group w-100">
                    <button class="btn btn-outline-secondary btn-sm" onclick="selectAll()">
                        <i class="bi bi-check-all"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="bulkAction('activate')">
                        <i class="bi bi-check-circle"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="bulkAction('deactivate')">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>
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

<!-- Users Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-3 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-people text-primary"></i>
                    </div>
                    All User Accounts
                </h5>
                <p class="text-muted mb-0 mt-2">Manage user accounts and access permissions</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted" id="resultCount">Showing <?= count($users ?? []) ?> users</span>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($users)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 ps-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                                </div>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('name')">
                                User Details
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('role')">
                                Role & Permissions
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('councilor')">
                                Linked Councilor
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('created')">
                                Created Date
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('status')">
                                Status
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="user-row" data-role="<?= $user['role'] ?>" data-status="<?= $user['status'] ?? 'active' ?>">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox" value="<?= $user['id'] ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 mt-1" style="width: 48px; height: 48px;">
                                            <i class="bi bi-<?= $user['role'] === 'admin' ? 'shield-check' : ($user['role'] === 'councilor' ? 'person-badge' : 'person') ?> text-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?> fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold mb-1"><?= htmlspecialchars($user['full_name'] ?? '') ?></div>
                                            <div class="text-muted mb-1" style="font-size: 0.875rem;">
                                                <i class="bi bi-envelope me-1"></i>
                                                <?= htmlspecialchars($user['email'] ?? '') ?>
                                            </div>
                                            <div class="text-muted" style="font-size: 0.875rem;">
                                                <i class="bi bi-person me-1"></i>
                                                @<?= htmlspecialchars($user['username'] ?? 'N/A') ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?> bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-<?= $user['role'] === 'admin' ? 'shield-check' : ($user['role'] === 'councilor' ? 'people' : 'person-check') ?> text-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'councilor' ? 'success' : 'primary') ?>"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= ucfirst($user['role']) ?></div>
                                            <small class="text-muted">
                                                <?= $user['role'] === 'admin' ? 'Full Access' : ($user['role'] === 'councilor' ? 'Council Member' : 'Limited Access') ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($user['councilor_name'])): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                                <i class="bi bi-person-badge text-success"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium"><?= htmlspecialchars($user['councilor_name'] ?? '') ?></div>
                                                <small class="text-muted">Council Member</small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center">
                                            <div class="bg-secondary bg-opacity-10 rounded-2 p-2 d-inline-flex">
                                                <i class="bi bi-dash text-secondary"></i>
                                            </div>
                                            <div class="text-muted mt-1">
                                                <small>Not Linked</small>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-calendar-plus text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= date('M j, Y', strtotime($user['created_at'])) ?></div>
                                            <small class="text-muted"><?= date('g:i A', strtotime($user['created_at'])) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                    $status = $user['status'] ?? 'active';
                                    $statusColor = $status === 'active' ? 'success' : 'danger';
                                    $statusIcon = $status === 'active' ? 'check-circle' : 'x-circle';
                                    ?>
                                    <span class="badge bg-<?= $statusColor ?> bg-opacity-10 text-<?= $statusColor ?> px-3 py-2 fw-medium">
                                        <i class="bi bi-<?= $statusIcon ?> me-1"></i>
                                        <?= ucfirst($status) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>admin/view_user/<?= $user['id'] ?>" class="btn btn-outline-primary hover-shadow" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/edit_user/<?= $user['id'] ?>" class="btn btn-outline-secondary hover-shadow" title="Edit User">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/change_password/<?= $user['id'] ?>">
                                                    <i class="bi bi-key me-2"></i>Change Password
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="toggleUserStatus(<?= $user['id'] ?>, '<?= $status ?>')">
                                                    <i class="bi bi-<?= $status === 'active' ? 'x-circle' : 'check-circle' ?> me-2"></i><?= $status === 'active' ? 'Deactivate' : 'Activate' ?>
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['full_name'] ?? 'User') ?>')">
                                                    <i class="bi bi-trash me-2"></i>Delete User
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Enhanced Pagination -->
            <div class="card-footer bg-transparent border-0 pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <select class="form-select form-select-sm" style="width: auto;" onchange="changePageSize(this.value)">
                            <option value="10">10 per page</option>
                            <option value="25" selected>25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                        <span class="text-muted">Showing 1-<?= count($users ?? []) ?> of <?= count($users ?? []) ?> results</span>
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="bg-primary bg-opacity-5 rounded-3 d-inline-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
                    <i class="bi bi-people text-primary" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">No users found</h4>
                <p class="text-muted mb-4 px-5">Start managing your user accounts by creating the first user. You can create accounts for councilors and administrative staff.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="<?= BASE_URL ?>admin/add_user" class="btn btn-primary hover-shadow">
                        <i class="bi bi-plus-lg me-2"></i>Create First User
                    </a>
                    <button class="btn btn-outline-secondary" onclick="importUsers()">
                        <i class="bi bi-upload me-2"></i>Import Users
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Enhanced JavaScript functionality
let selectedRows = new Set();

function deleteUser(id, name) {
    if (confirm(`Are you sure you want to delete the user account for "${name}"? This action cannot be undone.`)) {
        showLoading();
        window.location.href = '<?= BASE_URL ?>admin/delete_user/' + id;
    }
}

function toggleUserStatus(id, currentStatus) {
    const action = currentStatus === 'active' ? 'deactivate' : 'activate';
    if (confirm(`Are you sure you want to ${action} this user account?`)) {
        showLoading();
        window.location.href = '<?= BASE_URL ?>admin/toggle_user_status/' + id;
    }
}

function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.user-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const role = row.getAttribute('data-role');
        const status = row.getAttribute('data-status');
        
        const matchesSearch = text.includes(searchTerm);
        const matchesRole = !roleFilter || role === roleFilter;
        const matchesStatus = !statusFilter || status === statusFilter;
        
        if (matchesSearch && matchesRole && matchesStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.getElementById('resultCount').textContent = `Showing ${visibleCount} users`;
}

function sortColumn(column) {
    showToast('Table sorted by ' + column, 'info');
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    rowCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
        if (selectAllCheckbox.checked) {
            selectedRows.add(checkbox.value);
        } else {
            selectedRows.delete(checkbox.value);
        }
    });
}

function selectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    selectAllCheckbox.checked = true;
    toggleSelectAll();
}

function bulkAction(action) {
    if (selectedRows.size === 0) {
        showToast('Please select users first', 'warning');
        return;
    }
    
    const confirmMsg = `Are you sure you want to ${action} ${selectedRows.size} selected user(s)?`;
    if (confirm(confirmMsg)) {
        showLoading();
        // Implement bulk action logic here
        setTimeout(() => {
            hideLoading();
            showToast(`Successfully ${action}d ${selectedRows.size} user(s)`, 'success');
            selectedRows.clear();
        }, 1500);
    }
}

function refreshUsers() {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    
    icon.style.animation = 'spin 1s linear infinite';
    btn.disabled = true;
    
    setTimeout(() => {
        icon.style.animation = '';
        btn.disabled = false;
        showToast('Users refreshed successfully!', 'success');
        location.reload();
    }, 1500);
}

function exportData(format) {
    showLoading();
    setTimeout(() => {
        hideLoading();
        showToast(`Users exported as ${format.toUpperCase()} successfully!`, 'success');
    }, 2000);
}

function importUsers() {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.xlsx,.xls,.csv';
    fileInput.onchange = function(e) {
        if (e.target.files.length > 0) {
            showLoading();
            setTimeout(() => {
                hideLoading();
                showToast('Users imported successfully!', 'success');
            }, 2000);
        }
    };
    fileInput.click();
}

function changePageSize(size) {
    showToast(`Showing ${size} items per page`, 'info');
}

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
    toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'warning' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
        ${message}
        <button type="button" class="btn-close ms-2" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 3000);
}

// Add event listeners for row selection
document.addEventListener('DOMContentLoaded', function() {
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedRows.add(this.value);
            } else {
                selectedRows.delete(this.value);
            }
        });
    });
    
    // Add CSS for spin animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .sortable { cursor: pointer; }
        .sortable:hover { background-color: rgba(0,0,0,0.05); }
        .hover-shadow:hover { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075) !important; }
    `;
    document.head.appendChild(style);
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>