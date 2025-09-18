<?php
$current_admin_page = 'publications';
$page_title = 'Publications';
$page_description = 'Manage municipal publications and announcements';
$breadcrumbs = [
    ['title' => 'Publications', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<style>
    /* Ensure pure white background for publications page */
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
</style>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Municipal Publications</h1>
        <p class="text-muted mb-0">Manage announcements, memos, and public notices</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                <i class="bi bi-megaphone me-1"></i>
                <?= count($publications ?? []) ?> Publications
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Last updated: <?= date('M j, Y g:i A') ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="refreshPublications()">
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
        <a href="<?= BASE_URL ?>admin/add_publication" class="btn btn-warning d-flex align-items-center hover-shadow">
            <i class="bi bi-plus-lg me-2"></i>Add New Publication
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
                    <input type="text" class="form-control ps-5" placeholder="Search publications..." id="searchInput" onkeyup="filterTable()">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="categoryFilter" onchange="filterTable()">
                    <option value="">All Categories</option>
                    <option value="announcement">Announcements</option>
                    <option value="memo">Memos</option>
                    <option value="policy">Policies</option>
                    <option value="notice">Notices</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy" onchange="sortTable()">
                    <option value="date_desc">Date (Newest)</option>
                    <option value="date_asc">Date (Oldest)</option>
                    <option value="title_asc">Title (A-Z)</option>
                    <option value="title_desc">Title (Z-A)</option>
                    <option value="category_asc">Category</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="btn-group w-100">
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleView('table')" id="tableViewBtn">
                        <i class="bi bi-table"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleView('grid')" id="gridViewBtn">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="selectAll()">
                        <i class="bi bi-check-all"></i>
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

<!-- Publications Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-3 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-megaphone text-warning"></i>
                    </div>
                    All Publications
                </h5>
                <p class="text-muted mb-0 mt-2">Manage municipal announcements and public notices</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted" id="resultCount">Showing <?= count($publications ?? []) ?> publications</span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('publish')">
                            <i class="bi bi-check-circle me-2"></i>Bulk Publish
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('archive')">
                            <i class="bi bi-archive me-2"></i>Bulk Archive
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                            <i class="bi bi-trash me-2"></i>Bulk Delete
                        </a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($publications)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="publicationsTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 ps-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                                </div>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('title')">
                                Title & Content
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('category')">
                                Category
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('date_posted')">
                                Date Posted
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('status')">
                                Status
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0">Priority</th>
                            <th class="fw-semibold border-0 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($publications as $publication): ?>
                            <tr class="publication-row" data-status="<?= $publication['status'] ?>" data-category="<?= $publication['category'] ?>">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox" value="<?= $publication['id'] ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3 mt-1">
                                            <i class="bi bi-<?= $publication['category'] === 'announcement' ? 'megaphone' : ($publication['category'] === 'memo' ? 'file-text' : ($publication['category'] === 'policy' ? 'clipboard-check' : 'bell')) ?> text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold mb-1"><?= htmlspecialchars(substr($publication['title'] ?? '', 0, 60)) ?><?= strlen($publication['title'] ?? '') > 60 ? '...' : '' ?></div>
                                            <?php if (!empty($publication['content'])): ?>
                                                <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">
                                                    <?= htmlspecialchars(substr($publication['content'], 0, 120)) ?>...
                                                </p>
                                            <?php endif; ?>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    <?= date('Y', strtotime($publication['date_posted'] ?? 'now')) ?>
                                                </span>
                                                <?php if (!empty($publication['file_path'])): ?>
                                                    <span class="badge bg-info bg-opacity-10 text-info">
                                                        <i class="bi bi-paperclip me-1"></i>
                                                        Has Attachment
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($publication['category'] === 'announcement'): ?>
                                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                                        <i class="bi bi-star me-1"></i>
                                                        Featured
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-<?= $publication['category'] === 'announcement' ? 'warning' : ($publication['category'] === 'memo' ? 'info' : ($publication['category'] === 'policy' ? 'success' : 'secondary')) ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="bi bi-<?= $publication['category'] === 'announcement' ? 'megaphone' : ($publication['category'] === 'memo' ? 'file-text' : ($publication['category'] === 'policy' ? 'clipboard-check' : 'bell')) ?> text-<?= $publication['category'] === 'announcement' ? 'warning' : ($publication['category'] === 'memo' ? 'info' : ($publication['category'] === 'policy' ? 'success' : 'secondary')) ?>"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= ucfirst(str_replace('_', ' ', $publication['category'])) ?></div>
                                            <small class="text-muted">Public Notice</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-calendar-check text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= date('M j, Y', strtotime($publication['date_posted'] ?? 'now')) ?></div>
                                            <small class="text-muted"><?= date('g:i A', strtotime($publication['date_posted'] ?? 'now')) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $publication['status'] === 'published' ? 'success' : ($publication['status'] === 'draft' ? 'warning' : 'secondary') ?> bg-opacity-10 text-<?= $publication['status'] === 'published' ? 'success' : ($publication['status'] === 'draft' ? 'warning' : 'secondary') ?> px-3 py-2 fw-medium">
                                        <i class="bi bi-<?= $publication['status'] === 'published' ? 'check-circle' : ($publication['status'] === 'draft' ? 'clock' : 'archive') ?> me-1"></i>
                                        <?= ucfirst($publication['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php 
                                        $priority = $publication['category'] === 'announcement' ? 'high' : 'normal';
                                        $priorityColor = $priority === 'high' ? 'danger' : 'success';
                                        ?>
                                        <div class="bg-<?= $priorityColor ?> bg-opacity-10 rounded-2 p-2 me-2">
                                            <i class="bi bi-<?= $priority === 'high' ? 'arrow-up' : 'arrow-right' ?> text-<?= $priorityColor ?>"></i>
                                        </div>
                                        <span class="badge bg-<?= $priorityColor ?> bg-opacity-10 text-<?= $priorityColor ?>">
                                            <?= ucfirst($priority) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>publications/view/<?= $publication['id'] ?>" class="btn btn-outline-warning hover-shadow" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/edit_publication/<?= $publication['id'] ?>" class="btn btn-outline-secondary hover-shadow" title="Edit Publication">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#" onclick="duplicatePublication(<?= $publication['id'] ?>)">
                                                    <i class="bi bi-files me-2"></i>Duplicate
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="archivePublication(<?= $publication['id'] ?>)">
                                                    <i class="bi bi-archive me-2"></i>Archive
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="sharePublication(<?= $publication['id'] ?>)">
                                                    <i class="bi bi-share me-2"></i>Share
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteItem('publications', <?= $publication['id'] ?>)">
                                                    <i class="bi bi-trash me-2"></i>Delete
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
                        <span class="text-muted">Showing 1-<?= count($publications ?? []) ?> of <?= count($publications ?? []) ?> results</span>
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
                <div class="bg-warning bg-opacity-5 rounded-3 d-inline-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
                    <i class="bi bi-megaphone text-warning" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">No publications found</h4>
                <p class="text-muted mb-4 px-5">Start managing your municipal publications by creating your first announcement, memo, or policy document. Keep your community informed with timely updates.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="<?= BASE_URL ?>admin/add_publication" class="btn btn-warning hover-shadow">
                        <i class="bi bi-plus-lg me-2"></i>Create First Publication
                    </a>
                    <button class="btn btn-outline-secondary" onclick="importPublications()">
                        <i class="bi bi-upload me-2"></i>Import Publications
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Enhanced JavaScript functionality
let selectedRows = new Set();

function deleteItem(type, id) {
    if (confirm('Are you sure you want to delete this ' + type.slice(0, -1) + '? This action cannot be undone.')) {
        showLoading();
        
        // Create a form to submit the delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL ?>admin/delete/' + type + '/' + id;
        
        // Add CSRF token if available
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = csrfToken.getAttribute('content');
            form.appendChild(tokenInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}

function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const categoryFilter = document.getElementById('categoryFilter').value;
    const rows = document.querySelectorAll('.publication-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const status = row.getAttribute('data-status');
        const category = row.getAttribute('data-category');
        
        const matchesSearch = text.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesCategory = !categoryFilter || category === categoryFilter;
        
        if (matchesSearch && matchesStatus && matchesCategory) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.getElementById('resultCount').textContent = `Showing ${visibleCount} publications`;
}

function sortColumn(column) {
    const table = document.getElementById('publicationsTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Simple sorting logic - in real implementation, this would be more sophisticated
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
    
    updateSelectedRowsUI();
}

function updateSelectedRowsUI() {
    const selectedCount = selectedRows.size;
    if (selectedCount > 0) {
        showToast(`${selectedCount} publication(s) selected`, 'info');
    }
}

function bulkAction(action) {
    if (selectedRows.size === 0) {
        showToast('Please select publications first', 'warning');
        return;
    }
    
    const confirmMsg = `Are you sure you want to ${action} ${selectedRows.size} selected publication(s)?`;
    if (confirm(confirmMsg)) {
        showLoading();
        // Implement bulk action logic here
        setTimeout(() => {
            hideLoading();
            showToast(`Successfully ${action}ed ${selectedRows.size} publication(s)`, 'success');
            selectedRows.clear();
        }, 1500);
    }
}

function refreshPublications() {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    
    icon.style.animation = 'spin 1s linear infinite';
    btn.disabled = true;
    
    setTimeout(() => {
        icon.style.animation = '';
        btn.disabled = false;
        showToast('Publications refreshed successfully!', 'success');
        location.reload();
    }, 1500);
}

function exportData(format) {
    showLoading();
    // Simulate export process
    setTimeout(() => {
        hideLoading();
        showToast(`Publications exported as ${format.toUpperCase()} successfully!`, 'success');
    }, 2000);
}

function duplicatePublication(id) {
    if (confirm('Do you want to create a copy of this publication?')) {
        showLoading();
        // Implement duplication logic
        setTimeout(() => {
            hideLoading();
            showToast('Publication duplicated successfully!', 'success');
        }, 1000);
    }
}

function archivePublication(id) {
    if (confirm('Are you sure you want to archive this publication?')) {
        showLoading();
        // Implement archiving logic
        setTimeout(() => {
            hideLoading();
            showToast('Publication archived successfully!', 'success');
        }, 1000);
    }
}

function sharePublication(id) {
    // Create share modal or functionality
    const shareUrl = `${window.location.origin}/publications/view/${id}`;
    
    if (navigator.share) {
        navigator.share({
            title: 'Municipal Publication',
            url: shareUrl
        }).then(() => {
            showToast('Publication shared successfully!', 'success');
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(shareUrl).then(() => {
            showToast('Publication link copied to clipboard!', 'success');
        });
    }
}

function importPublications() {
    // Create file input for import
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.xlsx,.xls,.csv,.pdf';
    fileInput.onchange = function(e) {
        if (e.target.files.length > 0) {
            showLoading();
            setTimeout(() => {
                hideLoading();
                showToast('Publications imported successfully!', 'success');
            }, 2000);
        }
    };
    fileInput.click();
}

function toggleView(viewType) {
    const tableBtn = document.getElementById('tableViewBtn');
    const gridBtn = document.getElementById('gridViewBtn');
    
    if (viewType === 'table') {
        tableBtn.classList.add('active');
        gridBtn.classList.remove('active');
        showToast('Switched to table view', 'info');
    } else {
        gridBtn.classList.add('active');
        tableBtn.classList.remove('active');
        showToast('Grid view coming soon!', 'info');
    }
}

function selectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    selectAllCheckbox.checked = true;
    toggleSelectAll();
}

function changePageSize(size) {
    showToast(`Showing ${size} items per page`, 'info');
    // Implement pagination logic
}

function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
    overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    overlay.style.zIndex = '9999';
    overlay.innerHTML = '<div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div>';
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
            updateSelectedRowsUI();
        });
    });
    
    // Set initial table view button state
    document.getElementById('tableViewBtn').classList.add('active');
    
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
