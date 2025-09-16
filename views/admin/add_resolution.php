<?php
$current_admin_page = 'resolutions';
$page_title = 'Add New Resolution';
$page_description = 'Create a new municipal resolution';
$breadcrumbs = [
    ['title' => 'Resolutions', 'url' => BASE_URL . 'admin/resolutions'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold text-dark">Add New Resolution</h1>
        <p class="text-muted mb-0">Create a new municipal resolution</p>
    </div>
    <a href="<?= BASE_URL ?>admin/resolutions" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Resolutions
    </a>
</div>

<!-- Add Resolution Form -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-0 py-4">
        <div class="d-flex align-items-center">
            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-file-earmark-check text-success fs-4"></i>
            </div>
            <div>
                <h5 class="card-title mb-0 fw-bold">Resolution Details</h5>
                <p class="text-muted small mb-0">Fill in the information below to create a new resolution</p>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>admin/add_resolution" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="subject" class="form-label fw-semibold">Resolution Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="subject" name="subject"
                               placeholder="Enter resolution subject" required>
                        <div class="form-text">Choose a clear and descriptive subject for your resolution</div>
                    </div>

                    <div class="mb-4">
                        <label for="summary" class="form-label fw-semibold">Summary <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="summary" name="summary" rows="8"
                                  placeholder="Enter resolution summary" required></textarea>
                        <div class="form-text">Provide a detailed summary of the resolution</div>
                    </div>

                    <div class="mb-4">
                        <label for="keywords" class="form-label fw-semibold">Keywords</label>
                        <input type="text" class="form-control form-control-lg" id="keywords" name="keywords"
                               placeholder="Enter keywords separated by commas">
                        <div class="form-text">Optional: Keywords to help with searching (e.g., budget, infrastructure, policy)</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-4">
                        <label for="resolution_number" class="form-label fw-semibold">Resolution Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="resolution_number" name="resolution_number"
                               placeholder="e.g., RES-2024-001" required>
                        <div class="form-text">Official resolution number</div>
                    </div>

                    <div class="mb-4">
                        <label for="author_id" class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="author_id" name="author_id" required>
                            <option value="">Select Author</option>
                            <?php if (!empty($councilors)): ?>
                                <?php foreach ($councilors as $councilor): ?>
                                    <option value="<?= $councilor['id'] ?>"><?= htmlspecialchars($councilor['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="date_approved" class="form-label fw-semibold">Date Approved <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg" id="date_approved" name="date_approved" required>
                        <div class="form-text">When was this resolution approved?</div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="active">✅ Active</option>
                            <option value="draft">📝 Draft</option>
                            <option value="archived">📁 Archived</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold">Document</label>
                        <input type="file" class="form-control form-control-lg" id="file" name="file" accept=".pdf">
                        <div class="form-text">Optional: Upload PDF document for this resolution</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="<?= BASE_URL ?>admin/resolutions" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success btn-lg px-4">
                            <i class="bi bi-plus-lg me-2"></i>Create Resolution
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
