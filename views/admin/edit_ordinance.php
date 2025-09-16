<?php
$current_admin_page = 'ordinances';
$page_title = 'Edit Ordinance';
$page_description = 'Edit existing municipal ordinance';
$breadcrumbs = [
    ['title' => 'Ordinances', 'url' => BASE_URL . 'admin/ordinances'],
    ['title' => 'Edit', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold text-dark">Edit Ordinance</h1>
        <p class="text-muted mb-0">Update ordinance details</p>
    </div>
    <a href="<?= BASE_URL ?>admin/ordinances" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Ordinances
    </a>
</div>

<!-- Form Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-0 py-4">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-file-text text-primary fs-4"></i>
            </div>
            <div>
                <h5 class="card-title mb-0 fw-bold">Ordinance Details</h5>
                <p class="text-muted small mb-0">Update the ordinance information below</p>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>admin/edit_ordinance/<?= $ordinance['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="ordinance_number" class="form-label fw-semibold">Ordinance Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="ordinance_number" name="ordinance_number"
                               value="<?= htmlspecialchars($ordinance['ordinance_number']) ?>" required
                               placeholder="e.g., 2024-001">
                        <div class="form-text">Official ordinance number</div>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title"
                               value="<?= htmlspecialchars($ordinance['title']) ?>" required
                               placeholder="Enter ordinance title">
                        <div class="form-text">Clear and descriptive title for the ordinance</div>
                    </div>

                    <div class="mb-4">
                        <label for="summary" class="form-label fw-semibold">Summary</label>
                        <textarea class="form-control" id="summary" name="summary" rows="6"
                                  placeholder="Provide a brief summary of the ordinance"><?= htmlspecialchars($ordinance['summary'] ?? '') ?></textarea>
                        <div class="form-text">Optional: Brief summary of the ordinance content</div>
                    </div>

                    <div class="mb-4">
                        <label for="keywords" class="form-label fw-semibold">Keywords</label>
                        <input type="text" class="form-control form-control-lg" id="keywords" name="keywords"
                               value="<?= htmlspecialchars($ordinance['keywords'] ?? '') ?>"
                               placeholder="Enter keywords separated by commas">
                        <div class="form-text">Optional: Keywords to help with searching</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-4">
                        <label for="author_id" class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="author_id" name="author_id" required>
                            <option value="">Select Author</option>
                            <?php if (!empty($councilors)): ?>
                                <?php foreach ($councilors as $councilor): ?>
                                    <option value="<?= $councilor['id'] ?>" <?= ($councilor['id'] == $ordinance['author_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($councilor['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="date_passed" class="form-label fw-semibold">Date Passed <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg" id="date_passed" name="date_passed"
                               value="<?= $ordinance['date_passed'] ?>" required>
                        <div class="form-text">When was this ordinance passed?</div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select form-select-lg" id="status" name="status">
                            <option value="passed" <?= ($ordinance['status'] == 'passed') ? 'selected' : '' ?>>✅ Passed</option>
                            <option value="pending" <?= ($ordinance['status'] == 'pending') ? 'selected' : '' ?>>⏳ Pending</option>
                            <option value="rejected" <?= ($ordinance['status'] == 'rejected') ? 'selected' : '' ?>>❌ Rejected</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold">File Attachment</label>
                        <input type="file" class="form-control form-control-lg" id="file" name="file"
                               accept=".pdf,.doc,.docx">
                        <div class="form-text">
                            Optional: Upload new PDF/DOC file (Max: 10MB)
                            <?php if (!empty($ordinance['file_path'])): ?>
                                <br><small class="text-success">Current file: <?= basename($ordinance['file_path']) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="<?= BASE_URL ?>admin/ordinances" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-check-lg me-2"></i>Update Ordinance
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
