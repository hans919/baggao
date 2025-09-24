<?php
$current_admin_page = 'minutes';
$page_title = 'Meeting Minutes';
$page_description = 'Manage municipal meeting records and proceedings';
$breadcrumbs = [
    ['title' => 'Meeting Minutes', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<style>
/* Ensure white background for minutes page */
body {
    background-color: #ffffff !important;
}

.main-content {
    background-color: #ffffff !important;
}

.card {
    background-color: #ffffff !important;
}

.table {
    background-color: #ffffff !important;
}

.dropdown-menu {
    background-color: #ffffff !important;
}
</style>

<!-- Page Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-2">
        <!-- Search -->
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search minutes..." 
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="width: 250px;">
            <button type="submit" class="btn btn-outline-info btn-sm">
                <i class="bi bi-search"></i>
            </button>
            <?php if (!empty($_GET['search'])): ?>
                <a href="<?= BASE_URL ?>admin/minutes" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
    <a href="<?= BASE_URL ?>admin/add_minute" class="btn btn-info d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i>Add New Minutes
    </a>
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

<!-- Minutes Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-20 rounded-circle p-3 me-3">
                        <i class="bi bi-journal-text text-info fs-5"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">Total Minutes</h6>
                        <h4 class="card-title mb-0"><?= count($minutes) ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-20 rounded-circle p-3 me-3">
                        <i class="bi bi-check-circle text-success fs-5"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">Published</h6>
                        <h4 class="card-title mb-0">
                            <?= count(array_filter($minutes, function($m) { return $m['status'] === 'published'; })) ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-20 rounded-circle p-3 me-3">
                        <i class="bi bi-pencil-square text-warning fs-5"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">Draft</h6>
                        <h4 class="card-title mb-0">
                            <?= count(array_filter($minutes, function($m) { return $m['status'] === 'draft'; })) ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-20 rounded-circle p-3 me-3">
                        <i class="bi bi-calendar-event text-primary fs-5"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted mb-1">This Month</h6>
                        <h4 class="card-title mb-0">
                            <?= count(array_filter($minutes, function($m) { 
                                return date('Y-m', strtotime($m['meeting_date'])) === date('Y-m'); 
                            })) ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Minutes Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                <i class="bi bi-journal-text me-2 text-info"></i>All Meeting Minutes
            </h5>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?status=published">Published</a></li>
                        <li><a class="dropdown-item" href="?status=draft">Draft</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?">All Status</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="exportToCSV()">
                    <i class="bi bi-download me-1"></i>Export
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($minutes)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="minutesTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Meeting Date</th>
                            <th class="fw-semibold">Session Type</th>
                            <th class="fw-semibold">Meeting Type</th>
                            <th class="fw-semibold">Chairperson</th>
                            <th class="fw-semibold">Attendees</th>
                            <th class="fw-semibold">Summary</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($minutes as $minute): ?>
                            <tr>
                                <td class="fw-medium text-info">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar3 text-info me-2"></i>
                                        <?= date('M j, Y', strtotime($minute['meeting_date'])) ?>
                                    </div>
                                    <?php if (!empty($minute['meeting_start_time'])): ?>
                                        <small class="text-muted d-block">
                                            <?= date('g:i A', strtotime($minute['meeting_start_time'])) ?>
                                            <?php if (!empty($minute['meeting_end_time'])): ?>
                                                - <?= date('g:i A', strtotime($minute['meeting_end_time'])) ?>
                                            <?php endif; ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-1 me-2">
                                            <i class="bi bi-people text-info"></i>
                                        </div>
                                        <span><?= htmlspecialchars($minute['session_type']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $minute['meeting_type'] === 'regular' ? 'primary' : 
                                        ($minute['meeting_type'] === 'special' ? 'warning' : 
                                        ($minute['meeting_type'] === 'emergency' ? 'danger' : 'dark')) ?> px-2 py-1">
                                        <?= ucfirst($minute['meeting_type'] ?? 'regular') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($minute['chairperson_name'])): ?>
                                        <small class="text-muted"><?= htmlspecialchars($minute['chairperson_name']) ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">Not specified</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-people-fill text-success me-1"></i>
                                        <span class="fw-medium"><?= $minute['total_attendees'] ?? 0 ?></span>
                                        <?php if (!empty($minute['quorum_met'])): ?>
                                            <i class="bi bi-check-circle-fill text-success ms-1" title="Quorum met"></i>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium"><?= htmlspecialchars(substr($minute['summary'], 0, 60)) ?><?= strlen($minute['summary']) > 60 ? '...' : '' ?></div>
                                    <?php if (!empty($minute['meeting_location']) && $minute['meeting_location'] !== 'Municipal Council Chamber'): ?>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($minute['meeting_location']) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $minute['status'] === 'published' ? 'success' : 'secondary' ?> px-2 py-1">
                                        <?= ucfirst($minute['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>minutes/view/<?= $minute['id'] ?>" class="btn btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>admin/edit_minute/<?= $minute['id'] ?>" class="btn btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if (!empty($minute['file_path'])): ?>
                                            <a href="<?= BASE_URL ?>minutes/download/<?= $minute['id'] ?>" class="btn btn-outline-primary" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        <?php endif; ?>
                                        <button class="btn btn-outline-danger" onclick="deleteMinute(<?= $minute['id'] ?>)" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-journal-text display-4 text-muted opacity-50"></i>
                <h5 class="mt-3 text-muted">No meeting minutes found</h5>
                <p class="text-muted mb-4">Start by recording your first meeting minutes.</p>
                <a href="<?= BASE_URL ?>admin/add_minute" class="btn btn-info">
                    <i class="bi bi-plus-lg me-2"></i>Add New Minutes
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteMinute(id) {
    if (confirm('Are you sure you want to delete this meeting minute? This action cannot be undone and will also remove all associated attendees, agenda items, and action items.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL ?>admin/delete_minute/' + id;
        
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

function exportToCSV() {
    const table = document.getElementById('minutesTable');
    let csv = '';
    
    // Get headers
    const headers = table.querySelectorAll('thead th');
    headers.forEach((header, index) => {
        if (index < headers.length - 1) { // Skip the Actions column
            csv += '"' + header.textContent.trim() + '"';
            if (index < headers.length - 2) csv += ',';
        }
    });
    csv += '\n';
    
    // Get rows
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, index) => {
            if (index < cells.length - 1) { // Skip the Actions column
                csv += '"' + cell.textContent.trim().replace(/"/g, '""') + '"';
                if (index < cells.length - 2) csv += ',';
            }
        });
        csv += '\n';
    });
    
    // Download CSV
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'meeting_minutes_' + new Date().toISOString().split('T')[0] + '.csv';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
}

// Enhanced table functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add search highlighting
    const searchTerm = '<?= htmlspecialchars($_GET['search'] ?? '') ?>';
    if (searchTerm) {
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        const cells = document.querySelectorAll('#minutesTable tbody td');
        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(searchTerm.toLowerCase())) {
                cell.innerHTML = cell.innerHTML.replace(regex, '<mark>$1</mark>');
            }
        });
    }
    
    // Add sorting functionality
    const headers = document.querySelectorAll('#minutesTable thead th');
    headers.forEach((header, index) => {
        if (index < headers.length - 1) { // Skip Actions column
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => sortTable(index));
        }
    });
});

function sortTable(columnIndex) {
    const table = document.getElementById('minutesTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Try to parse as date for date columns
        if (columnIndex === 0) {
            const aDate = new Date(aText);
            const bDate = new Date(bText);
            return isAscending ? aDate - bDate : bDate - aDate;
        }
        
        // Default string comparison
        return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
    
    // Update header indicators
    document.querySelectorAll('#minutesTable thead th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
    });
    
    const currentHeader = document.querySelectorAll('#minutesTable thead th')[columnIndex];
    currentHeader.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
}
</script>

<style>
/* Sort indicators */
.sort-asc::after {
    content: ' ↑';
    color: #0d6efd;
}

.sort-desc::after {
    content: ' ↓';
    color: #0d6efd;
}

/* Highlighting for search results */
mark {
    background-color: #fff3cd;
    padding: 0.1em 0.2em;
    border-radius: 0.2em;
}

/* Enhanced hover effects */
#minutesTable tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s ease;
}

/* Better button spacing */
.btn-group-sm .btn {
    padding: 0.25rem 0.4rem;
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
