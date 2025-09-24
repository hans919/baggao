<?php
$current_admin_page = 'councilors';
$page_title = 'Councilors';
$page_description = 'Manage municipal councilors and their information';
$breadcrumbs = [
    ['title' => 'Councilors', 'url' => '#']
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
    
    .bg-muted {
        background-color: #f8f9fa !important;
    }
    
    /* Councilor cards white background */
    .councilor-card {
        background-color: #ffffff !important;
        border: 1px solid #e9ecef !important;
    }
    
    /* Search and filter section */
    .search-section {
        background-color: #ffffff !important;
    }
    
    body, .wrapper, .main-wrapper {
        background-color: #ffffff !important;
    }
</style>

<!-- Enhanced Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Municipal Councilors</h1>
        <p class="text-muted mb-0">Manage councilor profiles and information</p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                <i class="bi bi-people me-1"></i>
                <?= count($councilors ?? []) ?> Councilors
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Last updated: <?= date('M j, Y g:i A') ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="refreshCouncilors()">
            <i class="bi bi-arrow-clockwise me-1"></i>
            Refresh
        </button>
        <a href="<?= BASE_URL ?>admin/add_councilor" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Add New Councilor
        </a>
    </div>
</div>

<!-- Enhanced Filters and Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="GET" action="<?= BASE_URL ?>admin/councilors" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label fw-semibold">Search Councilors</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" id="search" name="search" 
                           value="<?= htmlspecialchars($current_search ?? '') ?>" 
                           placeholder="Search by name, position, or committees...">
                </div>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="active" <?= ($current_status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($current_status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <a href="<?= BASE_URL ?>admin/councilors" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Councilors Grid -->
<?php if (!empty($councilors)): ?>
<div class="row g-4">
    <?php foreach ($councilors as $councilor): ?>
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm position-relative">
            <!-- Status Badge -->
            <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                <span class="badge bg-<?= $councilor['status'] === 'active' ? 'success' : 'secondary' ?> px-2 py-1">
                    <i class="bi bi-<?= $councilor['status'] === 'active' ? 'check-circle' : 'dash-circle' ?> me-1"></i>
                    <?= ucfirst($councilor['status']) ?>
                </span>
            </div>
            
            <div class="card-body text-center p-4">
                <!-- Profile Photo -->
                <div class="mb-3">
                    <?php if (!empty($councilor['photo'])): ?>
                        <img src="<?= BASE_URL . UPLOAD_PATH . $councilor['photo'] ?>" 
                             alt="<?= htmlspecialchars($councilor['name']) ?>" 
                             class="rounded-circle border border-3 border-light shadow-sm" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center border border-3 border-light shadow-sm" 
                             style="width: 100px; height: 100px; font-size: 2rem; font-weight: 600;">
                            <?= strtoupper(substr($councilor['name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Name and Position -->
                <h5 class="card-title text-primary fw-bold mb-1"><?= htmlspecialchars($councilor['name']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted fw-medium"><?= htmlspecialchars($councilor['position']) ?></h6>
                
                <!-- Term -->
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="bi bi-calendar3 me-1"></i>
                        Term: <?= $councilor['term_start'] ?> - <?= $councilor['term_end'] ?>
                    </small>
                </div>
                
                <!-- Statistics -->
                <div class="row text-center mb-3">
                    <div class="col-6">
                        <div class="p-2 bg-primary bg-opacity-10 rounded">
                            <div class="fw-bold text-primary"><?= $councilor['ordinance_count'] ?? 0 ?></div>
                            <small class="text-muted">Ordinances</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 bg-success bg-opacity-10 rounded">
                            <div class="fw-bold text-success"><?= $councilor['resolution_count'] ?? 0 ?></div>
                            <small class="text-muted">Resolutions</small>
                        </div>
                    </div>
                </div>
                
                <!-- Committees (truncated) -->
                <?php if (!empty($councilor['committees'])): ?>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-people me-1"></i>
                            <?= htmlspecialchars(strlen($councilor['committees']) > 50 
                                ? substr($councilor['committees'], 0, 50) . '...' 
                                : $councilor['committees']) ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Action Buttons -->
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="d-flex gap-2">
                    <a href="<?= BASE_URL ?>councilors/view/<?= $councilor['id'] ?>" 
                       class="btn btn-outline-info btn-sm flex-grow-1">
                        <i class="bi bi-eye me-1"></i>View
                    </a>
                    <a href="<?= BASE_URL ?>admin/edit_councilor/<?= $councilor['id'] ?>" 
                       class="btn btn-outline-primary btn-sm flex-grow-1">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <button class="btn btn-outline-danger btn-sm" 
                            onclick="confirmDelete(<?= $councilor['id'] ?>, '<?= htmlspecialchars($councilor['name']) ?>')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination would go here if needed -->

<?php else: ?>
<!-- Empty State -->
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <div class="mb-4">
            <i class="bi bi-people display-1 text-muted opacity-25"></i>
        </div>
        <h4 class="fw-semibold text-muted mb-2">No councilors found</h4>
        <?php if (!empty($current_search) || !empty($current_status)): ?>
            <p class="text-muted mb-4">No councilors match your current filters. Try adjusting your search criteria.</p>
            <a href="<?= BASE_URL ?>admin/councilors" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
            </a>
        <?php else: ?>
            <p class="text-muted mb-4">Start by adding your first councilor to the system.</p>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>admin/add_councilor" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Add New Councilor
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle display-4 text-warning"></i>
                </div>
                <p class="text-center mb-0">Are you sure you want to delete <strong id="councilorName"></strong>?</p>
                <p class="text-center text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete Councilor</a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function refreshCouncilors() {
    window.location.reload();
}

function confirmDelete(councilorId, councilorName) {
    document.getElementById('councilorName').textContent = councilorName;
    document.getElementById('confirmDeleteBtn').href = '<?= BASE_URL ?>admin/delete_councilor/' + councilorId;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Auto-submit search form on input change with debounce
let searchTimeout;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        if (this.value.length >= 3 || this.value.length === 0) {
            this.form.submit();
        }
    }, 500);
});

// Auto-submit on status change
document.getElementById('status').addEventListener('change', function() {
    this.form.submit();
});

// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('success', '<?= $_SESSION['success'] ?>');
    });
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('danger', '<?= $_SESSION['error'] ?>');
    });
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>

<?php
$content = ob_get_clean();

// Include the admin layout
include __DIR__ . '/layout.php';
?>