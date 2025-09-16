<?php
$current_admin_page = 'publications';
$page_title = 'Edit Publication';
$page_description = 'Edit existing municipal publication or announcement';
$breadcrumbs = [
    ['title' => 'Publications', 'url' => BASE_URL . 'admin/publications'],
    ['title' => 'Edit', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold text-dark">Edit Publication</h1>
        <p class="text-muted mb-0">Update publication details</p>
    </div>
    <a href="<?= BASE_URL ?>admin/publications" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Publications
    </a>
</div>

<!-- Edit Publication Form -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-0 py-4">
        <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-megaphone text-warning fs-4"></i>
            </div>
            <div>
                <h5 class="card-title mb-0 fw-bold">Publication Details</h5>
                <p class="text-muted small mb-0">Update the publication information below</p>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>admin/edit_publication/<?= $publication['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Publication Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title"
                               value="<?= htmlspecialchars($publication['title']) ?>" required>
                        <div class="form-text">Choose a clear and descriptive title for your publication</div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="12" required><?= htmlspecialchars($publication['content']) ?></textarea>
                        <div class="form-text">Provide the complete text content of your publication</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="announcement" <?= ($publication['category'] == 'announcement') ? 'selected' : '' ?>>📢 Announcement</option>
                            <option value="memo" <?= ($publication['category'] == 'memo') ? 'selected' : '' ?>>📄 Memorandum</option>
                            <option value="notice" <?= ($publication['category'] == 'notice') ? 'selected' : '' ?>>📋 Public Notice</option>
                            <option value="legislative_update" <?= ($publication['category'] == 'legislative_update') ? 'selected' : '' ?>>🏛️ Legislative Update</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="draft" <?= ($publication['status'] == 'draft') ? 'selected' : '' ?>>📝 Draft</option>
                            <option value="published" <?= ($publication['status'] == 'published') ? 'selected' : '' ?>>🌐 Published</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="date_posted" class="form-label fw-semibold">Date Posted <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg" id="date_posted" name="date_posted"
                               value="<?= $publication['date_posted'] ?>" required>
                        <div class="form-text">When should this publication be posted?</div>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold">Attachment</label>
                        <input type="file" class="form-control form-control-lg" id="file" name="file"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">
                            Optional: Upload new supporting document or image (PDF, DOC, DOCX, JPG, PNG)
                            <?php if (!empty($publication['file_path'])): ?>
                                <br><small class="text-success">Current file: <?= basename($publication['file_path']) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="<?= BASE_URL ?>admin/publications" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-warning btn-lg px-4">
                            <i class="bi bi-check-lg me-2"></i>Update Publication
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
