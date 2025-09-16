<?php
$current_admin_page = 'publications';
$page_title = 'Add New Publication';
$page_description = 'Create a new municipal publication or announcement';
$breadcrumbs = [
    ['title' => 'Publications', 'url' => BASE_URL . 'admin/publications'],
    ['title' => 'Add New', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold text-dark">Add New Publication</h1>
        <p class="text-muted mb-0">Create a new municipal publication or announcement</p>
    </div>
    <a href="<?= BASE_URL ?>admin/publications" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Publications
    </a>
</div>

<!-- Add Publication Form -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-0 py-4">
        <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-megaphone text-warning fs-4"></i>
            </div>
            <div>
                <h5 class="card-title mb-0 fw-bold">Publication Details</h5>
                <p class="text-muted small mb-0">Fill in the information below to create a new publication</p>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="<?= BASE_URL ?>admin/add_publication" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Publication Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title"
                               placeholder="Enter publication title" required>
                        <div class="form-text">Choose a clear and descriptive title for your publication</div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="12"
                                  placeholder="Enter the full content of the publication" required></textarea>
                        <div class="form-text">Provide the complete text content of your publication</div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="announcement">📢 Announcement</option>
                            <option value="memo">📄 Memorandum</option>
                            <option value="notice">📋 Public Notice</option>
                            <option value="legislative_update">🏛️ Legislative Update</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="draft">📝 Draft</option>
                            <option value="published">🌐 Published</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="date_posted" class="form-label fw-semibold">Date Posted <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-lg" id="date_posted" name="date_posted" required>
                        <div class="form-text">When should this publication be posted?</div>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold">Attachment</label>
                        <input type="file" class="form-control form-control-lg" id="file" name="file"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">Optional: Upload supporting document or image (PDF, DOC, DOCX, JPG, PNG)</div>
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
                            <i class="bi bi-plus-lg me-2"></i>Create Publication
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