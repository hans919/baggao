<?php
$current_admin_page = 'ordinances';
$page_title = 'Add New Ordinance';
$page_description = 'Create a new municipal ordinance';
$breadcrumbs = [
    ['title' => 'Ordinances', 'url' => BASE_URL . 'admin/ordinances'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Form Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-0">
        <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
            <i class="bi bi-file-text me-2 text-primary"></i>Ordinance Details
        </h5>
    </div>
    <div class="card-body">
        <form action="<?= BASE_URL ?>admin/add_ordinance" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ordinance_number" class="form-label fw-semibold">Ordinance Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="ordinance_number" name="ordinance_number" required 
                           placeholder="e.g., 2024-001">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="date_passed" class="form-label fw-semibold">Date Passed <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date_passed" name="date_passed" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" required 
                       placeholder="Enter ordinance title">
            </div>
            
            <div class="mb-3">
                <label for="summary" class="form-label fw-semibold">Summary</label>
                <textarea class="form-control" id="summary" name="summary" rows="3" 
                          placeholder="Provide a brief summary of the ordinance"></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="author_id" class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                    <select class="form-select" id="author_id" name="author_id" required>
                        <option value="">Select Author</option>
                        <?php if (!empty($councilors)): ?>
                            <?php foreach ($councilors as $councilor): ?>
                                <option value="<?= $councilor['id'] ?>"><?= htmlspecialchars($councilor['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="passed">Passed</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="keywords" class="form-label fw-semibold">Keywords</label>
                <input type="text" class="form-control" id="keywords" name="keywords" 
                       placeholder="Enter keywords separated by commas">
            </div>
            
            <div class="mb-3">
                <label for="file" class="form-label fw-semibold">File Attachment</label>
                <input type="file" class="form-control" id="file" name="file" 
                       accept=".pdf,.doc,.docx">
                <small class="form-text text-muted">Accepted formats: PDF, DOC, DOCX (Max: 10MB)</small>
            </div>
            
            <div class="d-flex gap-2 justify-content-end">
                <a href="<?= BASE_URL ?>admin/ordinances" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-2"></i>Save Ordinance
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
