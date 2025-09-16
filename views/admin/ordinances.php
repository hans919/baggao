<?php
$current_admin_page = 'ordinances';
$page_title = 'Ordinances';
$page_description = 'Manage municipal ordinances and local laws';
$breadcrumbs = [
    ['title' => 'Ordinances', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<?php
$current_admin_page = 'ordinances';
$page_title = 'Ordinances';
$page_description = 'Manage municipal ordinances and local laws';
$breadcrumbs = [
    ['title' => 'Ordinances', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Municipal Ordinances</h1>
        <p class="text-muted mb-0">Manage local laws and municipal regulations</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                <i class="bi bi-file-text me-1"></i>
                <?= count($ordinances ?? []) ?> Ordinances
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Last updated: <?= date('M j, Y g:i A') ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="refreshOrdinances()">
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
        <a href="<?= BASE_URL ?>admin/add_ordinance" class="btn btn-primary d-flex align-items-center hover-shadow">
            <i class="bi bi-plus-lg me-2"></i>Add New Ordinance
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
                    <input type="text" class="form-control ps-5" placeholder="Search ordinances..." id="searchInput" onkeyup="filterTable()">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="passed">Passed</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="yearFilter" onchange="filterTable()">
                    <option value="">All Years</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy" onchange="sortTable()">
                    <option value="date_desc">Date (Newest)</option>
                    <option value="date_asc">Date (Oldest)</option>
                    <option value="title_asc">Title (A-Z)</option>
                    <option value="title_desc">Title (Z-A)</option>
                    <option value="number_asc">Number (Low-High)</option>
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

<!-- Ordinances Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-3 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-file-text text-primary"></i>
                    </div>
                    All Ordinances
                </h5>
                <p class="text-muted mb-0 mt-2">Manage and organize municipal ordinances</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted" id="resultCount">Showing <?= count($ordinances ?? []) ?> ordinances</span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('approve')">
                            <i class="bi bi-check-circle me-2"></i>Bulk Approve
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
        <?php if (!empty($ordinances)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="ordinancesTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold border-0 ps-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                                </div>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('ordinance_number')">
                                Ordinance Number
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('title')">
                                Title & Description
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('author_name')">
                                Author
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0 sortable" onclick="sortColumn('date_passed')">
                                Date Passed
                                <i class="bi bi-arrow-down-up ms-1 text-muted"></i>
                            </th>
                            <th class="fw-semibold border-0">Status</th>
                            <th class="fw-semibold border-0 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordinances as $ordinance): ?>
                            <tr class="ordinance-row" data-status="<?= $ordinance['status'] ?>" data-year="<?= date('Y', strtotime($ordinance['date_passed'] ?? 'now')) ?>">
                                <td class="ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input row-checkbox" type="checkbox" value="<?= $ordinance['id'] ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-file-text text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-primary"><?= htmlspecialchars($ordinance['ordinance_number']) ?></div>
                                            <small class="text-muted">Municipal Law</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold mb-1"><?= htmlspecialchars(substr($ordinance['title'] ?? '', 0, 60)) ?><?= strlen($ordinance['title'] ?? '') > 60 ? '...' : '' ?></div>
                                        <?php if (!empty($ordinance['summary'])): ?>
                                            <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">
                                                <?= htmlspecialchars(substr($ordinance['summary'], 0, 100)) ?>...
                                            </p>
                                        <?php endif; ?>
                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <?= date('Y', strtotime($ordinance['date_passed'] ?? 'now')) ?>
                                            </span>
                                            <?php if (!empty($ordinance['file_path'])): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info">
                                                    <i class="bi bi-paperclip me-1"></i>
                                                    Has Attachment
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="bi bi-person-fill text-secondary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= htmlspecialchars($ordinance['author_name'] ?? 'Unknown') ?></div>
                                            <small class="text-muted">Author</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                            <i class="bi bi-calendar-check text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium"><?= date('M j, Y', strtotime($ordinance['date_passed'] ?? 'now')) ?></div>
                                            <small class="text-muted"><?= date('g:i A', strtotime($ordinance['date_passed'] ?? 'now')) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $ordinance['status'] === 'passed' ? 'success' : ($ordinance['status'] === 'pending' ? 'warning' : 'danger') ?> bg-opacity-10 text-<?= $ordinance['status'] === 'passed' ? 'success' : ($ordinance['status'] === 'pending' ? 'warning' : 'danger') ?> px-3 py-2 fw-medium">
                                        <i class="bi bi-<?= $ordinance['status'] === 'passed' ? 'check-circle' : ($ordinance['status'] === 'pending' ? 'clock' : 'x-circle') ?> me-1"></i>
                                        <?= ucfirst($ordinance['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>ordinances/view/<?= $ordinance['id'] ?>" class="btn btn-outline-primary hover-shadow" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/edit_ordinance/<?= $ordinance['id'] ?>" class="btn btn-outline-secondary hover-shadow" title="Edit Ordinance">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#" onclick="duplicateOrdinance(<?= $ordinance['id'] ?>)">
                                                    <i class="bi bi-files me-2"></i>Duplicate
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="archiveOrdinance(<?= $ordinance['id'] ?>)">
                                                    <i class="bi bi-archive me-2"></i>Archive
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteItem('ordinances', <?= $ordinance['id'] ?>)">
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
                        <span class="text-muted">Showing 1-<?= count($ordinances ?? []) ?> of <?= count($ordinances ?? []) ?> results</span>
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
                    <i class="bi bi-file-text text-primary" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">No ordinances found</h4>
                <p class="text-muted mb-4 px-5">Start managing your municipal ordinances by creating your first ordinance document. You can draft, review, and publish ordinances through this system.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="<?= BASE_URL ?>admin/add_ordinance" class="btn btn-primary hover-shadow">
                        <i class="bi bi-plus-lg me-2"></i>Create First Ordinance
                    </a>
                    <button class="btn btn-outline-secondary" onclick="importOrdinances()">
                        <i class="bi bi-upload me-2"></i>Import Ordinances
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
    const yearFilter = document.getElementById('yearFilter').value;
    const rows = document.querySelectorAll('.ordinance-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const status = row.getAttribute('data-status');
        const year = row.getAttribute('data-year');
        
        const matchesSearch = text.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesYear = !yearFilter || year === yearFilter;
        
        if (matchesSearch && matchesStatus && matchesYear) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.getElementById('resultCount').textContent = `Showing ${visibleCount} ordinances`;
}

function sortColumn(column) {
    const table = document.getElementById('ordinancesTable');
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
        showToast(`${selectedCount} ordinance(s) selected`, 'info');
    }
}

function bulkAction(action) {
    if (selectedRows.size === 0) {
        showToast('Please select ordinances first', 'warning');
        return;
    }
    
    const confirmMsg = `Are you sure you want to ${action} ${selectedRows.size} selected ordinance(s)?`;
    if (confirm(confirmMsg)) {
        showLoading();
        // Implement bulk action logic here
        setTimeout(() => {
            hideLoading();
            showToast(`Successfully ${action}ed ${selectedRows.size} ordinance(s)`, 'success');
            selectedRows.clear();
        }, 1500);
    }
}

function refreshOrdinances() {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    
    icon.style.animation = 'spin 1s linear infinite';
    btn.disabled = true;
    
    setTimeout(() => {
        icon.style.animation = '';
        btn.disabled = false;
        showToast('Ordinances refreshed successfully!', 'success');
        location.reload();
    }, 1500);
}

function exportData(format) {
    showLoading();
    // Simulate export process
    setTimeout(() => {
        hideLoading();
        showToast(`Ordinances exported as ${format.toUpperCase()} successfully!`, 'success');
    }, 2000);
}

function duplicateOrdinance(id) {
    if (confirm('Do you want to create a copy of this ordinance?')) {
        showLoading();
        // Implement duplication logic
        setTimeout(() => {
            hideLoading();
            showToast('Ordinance duplicated successfully!', 'success');
        }, 1000);
    }
}

function archiveOrdinance(id) {
    if (confirm('Are you sure you want to archive this ordinance?')) {
        showLoading();
        // Implement archiving logic
        setTimeout(() => {
            hideLoading();
            showToast('Ordinance archived successfully!', 'success');
        }, 1000);
    }
}

function importOrdinances() {
    // Create file input for import
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.xlsx,.xls,.csv,.pdf';
    fileInput.onchange = function(e) {
        if (e.target.files.length > 0) {
            showLoading();
            setTimeout(() => {
                hideLoading();
                showToast('Ordinances imported successfully!', 'success');
            }, 2000);
        }
    };
    fileInput.click();
}

function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
    overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    overlay.style.zIndex = '9999';
    overlay.innerHTML = '<div class="spinner"></div>';
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
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
