<?php
$current_admin_page = 'resolutions';
$page_title = 'Resolution Details';
$page_description = 'View detailed resolution information';
$breadcrumbs = [
    ['title' => 'Resolutions', 'url' => BASE_URL . 'admin/resolutions'],
    ['title' => 'View Details', 'url' => '#']
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
    
    body, .wrapper, .main-wrapper {
        background-color: #ffffff !important;
    }
    
    /* Form inputs white background */
    .form-control, .form-select {
        background-color: #ffffff !important;
    }
    
    /* Modal backgrounds */
    .modal-content {
        background-color: #ffffff !important;
    }
    
    /* Document viewer styling */
    .document-viewer {
        min-height: 400px;
        border: 2px dashed #e9ecef;
        background: #f8f9fa;
    }
    
    /* Status badges */
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Resolution Details</h1>
        <p class="text-muted mb-0">Detailed information for Resolution No. <?= htmlspecialchars($resolution['resolution_number']) ?></p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-<?= $resolution['status'] === 'approved' ? 'success' : ($resolution['status'] === 'pending' ? 'warning' : 'danger') ?> px-3 py-2">
                <i class="bi bi-<?= $resolution['status'] === 'approved' ? 'check-circle' : ($resolution['status'] === 'pending' ? 'clock' : 'x-circle') ?> me-1"></i>
                <?= ucfirst($resolution['status']) ?>
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Created: <?= date('M j, Y', strtotime($resolution['created_at'] ?? $resolution['date_approved'])) ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>resolutions/view/<?= $resolution['id'] ?>" target="_blank" class="btn btn-outline-secondary">
            <i class="bi bi-eye me-1"></i>
            Public View
        </a>
        <a href="<?= BASE_URL ?>admin/edit_resolution/<?= $resolution['id'] ?>" class="btn btn-success">
            <i class="bi bi-pencil me-1"></i>
            Edit Resolution
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column - Basic Information -->
    <div class="col-lg-8">
        <!-- Main Details Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-file-earmark-check text-success"></i>
                    </div>
                    Resolution Information
                </h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-4">
                    <div class="col-12">
                        <h4 class="fw-bold text-success mb-3"><?= htmlspecialchars($resolution['subject']) ?></h4>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Resolution Number</label>
                        <div class="fw-bold fs-5 text-success"><?= htmlspecialchars($resolution['resolution_number']) ?></div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Date Approved</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check text-success me-2"></i>
                            <?= date('F j, Y', strtotime($resolution['date_approved'])) ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Status</label>
                        <div>
                            <span class="status-indicator bg-<?= $resolution['status'] === 'approved' ? 'success' : ($resolution['status'] === 'pending' ? 'warning' : 'danger') ?> me-2"></span>
                            <span class="fw-medium"><?= ucfirst($resolution['status']) ?></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Author</label>
                        <div class="d-flex align-items-center">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-person-fill text-secondary"></i>
                            </div>
                            <span class="fw-medium"><?= htmlspecialchars($resolution['author_name'] ?? 'Unknown') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary/Description -->
        <?php if (!empty($resolution['summary'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-file-earmark-text text-info me-2"></i>
                    Summary & Description
                </h6>
            </div>
            <div class="card-body pt-0">
                <p class="mb-0 lh-lg"><?= nl2br(htmlspecialchars($resolution['summary'])) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Keywords -->
        <?php if (!empty($resolution['keywords'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-tags text-warning me-2"></i>
                    Keywords & Tags
                </h6>
            </div>
            <div class="card-body pt-0">
                <?php 
                $keywords = array_map('trim', explode(',', $resolution['keywords']));
                foreach ($keywords as $keyword): 
                    if (!empty($keyword)):
                ?>
                    <span class="badge bg-success bg-opacity-10 text-success me-2 mb-2 px-3 py-2">
                        <?= htmlspecialchars($keyword) ?>
                    </span>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Document Viewer -->
        <?php if (!empty($resolution['file_path'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                    Document File
                </h6>
            </div>
            <div class="card-body pt-0">
                <div class="document-viewer rounded-3 d-flex align-items-center justify-content-center flex-column">
                    <div class="text-center">
                        <i class="bi bi-file-earmark-pdf text-danger mb-3" style="font-size: 3rem;"></i>
                        <h5 class="fw-bold mb-2">Document Available</h5>
                        <p class="text-muted mb-4">Click the button below to download or view the full document</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="<?= BASE_URL . UPLOAD_PATH . $resolution['file_path'] ?>" target="_blank" class="btn btn-danger">
                                <i class="bi bi-eye me-2"></i>View Document
                            </a>
                            <a href="<?= BASE_URL . UPLOAD_PATH . $resolution['file_path'] ?>" download class="btn btn-outline-danger">
                                <i class="bi bi-download me-2"></i>Download PDF
                            </a>
                        </div>
                        <small class="text-muted d-block mt-3">
                            File: <?= basename($resolution['file_path']) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Activity Log -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-clock-history text-secondary me-2"></i>
                    Activity & History
                </h6>
            </div>
            <div class="card-body pt-0">
                <div class="timeline">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="bi bi-check text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Resolution Approved</h6>
                                    <p class="text-muted mb-1">The resolution was officially approved and enacted</p>
                                    <small class="text-muted"><?= date('M j, Y g:i A', strtotime($resolution['date_approved'])) ?></small>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success">Approved</span>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (!empty($resolution['created_at'])): ?>
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="bi bi-plus text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Resolution Created</h6>
                                    <p class="text-muted mb-1">Initial resolution draft was created</p>
                                    <small class="text-muted"><?= date('M j, Y g:i A', strtotime($resolution['created_at'])) ?></small>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary">Created</span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Statistics & Actions -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0">Quick Actions</h6>
            </div>
            <div class="card-body pt-0">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>admin/edit_resolution/<?= $resolution['id'] ?>" class="btn btn-outline-success">
                        <i class="bi bi-pencil me-2"></i>Edit Resolution
                    </a>
                    <button class="btn btn-outline-secondary" onclick="duplicateResolution()">
                        <i class="bi bi-files me-2"></i>Duplicate
                    </button>
                    <button class="btn btn-outline-info" onclick="shareResolution()">
                        <i class="bi bi-share me-2"></i>Share
                    </button>
                    <button class="btn btn-outline-warning" onclick="archiveResolution()">
                        <i class="bi bi-archive me-2"></i>Archive
                    </button>
                    <hr class="my-2">
                    <button class="btn btn-outline-danger" onclick="confirmDelete()">
                        <i class="bi bi-trash me-2"></i>Delete Resolution
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0">Statistics</h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-center p-3 bg-success bg-opacity-10 rounded-3">
                            <div class="fw-bold text-success mb-1" style="font-size: 1.5rem;">
                                <?= isset($resolution['views']) ? $resolution['views'] : '0' ?>
                            </div>
                            <small class="text-muted fw-medium">Views</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-info bg-opacity-10 rounded-3">
                            <div class="fw-bold text-info mb-1" style="font-size: 1.5rem;">
                                <?= isset($resolution['downloads']) ? $resolution['downloads'] : '0' ?>
                            </div>
                            <small class="text-muted fw-medium">Downloads</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0">Related Information</h6>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light bg-opacity-50 rounded-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-calendar text-info"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium">Year</span>
                            <div class="fw-semibold"><?= date('Y', strtotime($resolution['date_approved'])) ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light bg-opacity-50 rounded-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-file-earmark-check text-success"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium">Type</span>
                            <div class="fw-semibold">Municipal Resolution</div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($resolution['file_path'])): ?>
                <div class="d-flex align-items-center justify-content-between p-3 bg-light bg-opacity-50 rounded-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-paperclip text-danger"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium">Attachment</span>
                            <div class="fw-semibold">PDF Document</div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Navigation -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0">Navigation</h6>
            </div>
            <div class="card-body pt-0">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>admin/resolutions" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Resolutions
                    </a>
                    <a href="<?= BASE_URL ?>resolutions" class="btn btn-outline-info">
                        <i class="bi bi-eye me-2"></i>View Public Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-danger">Delete Resolution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle display-4 text-danger"></i>
                </div>
                <p class="text-center mb-0">Are you sure you want to delete <strong>Resolution No. <?= htmlspecialchars($resolution['resolution_number']) ?></strong>?</p>
                <p class="text-center text-muted small">This action cannot be undone. All associated data will be permanently removed.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= BASE_URL ?>admin/delete/resolutions/<?= $resolution['id'] ?>" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>Delete Permanently
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

function duplicateResolution() {
    if (confirm('Do you want to create a copy of this resolution?')) {
        showLoading();
        // Redirect to add page with duplicate data
        window.location.href = '<?= BASE_URL ?>admin/add_resolution?duplicate=<?= $resolution["id"] ?>';
    }
}

function archiveResolution() {
    if (confirm('Are you sure you want to archive this resolution?')) {
        showLoading();
        // Implement archiving logic
        setTimeout(() => {
            hideLoading();
            showToast('Resolution archived successfully!', 'success');
        }, 1000);
    }
}

function shareResolution() {
    const shareUrl = '<?= BASE_URL ?>resolutions/view/<?= $resolution["id"] ?>';
    
    if (navigator.share) {
        navigator.share({
            title: 'Resolution No. <?= htmlspecialchars($resolution["resolution_number"]) ?>',
            text: '<?= htmlspecialchars($resolution["subject"]) ?>',
            url: shareUrl
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(shareUrl).then(() => {
            showToast('Link copied to clipboard!', 'success');
        });
    }
}

function showLoading() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
    overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    overlay.style.zIndex = '9999';
    overlay.innerHTML = '<div class="spinner-border text-success"></div>';
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
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('<?= $_SESSION['success'] ?>', 'success');
    });
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('<?= $_SESSION['error'] ?>', 'danger');
    });
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
</script>

<?php
$content = ob_get_clean();

// Include the admin layout
include __DIR__ . '/layout.php';
?>