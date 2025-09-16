<?php 
$current_page = 'publications';
$title = 'Publications - Baggao Legislative Information System';
ob_start(); 
?>


<!-- Search and Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="GET" action="<?= BASE_URL ?>publications" class="row g-4">
            <div class="col-md-5">
                <label for="search" class="form-label fw-semibold">Search Publications</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Search by title or content..." 
                       value="<?= htmlspecialchars($current_search) ?>">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Filter by Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $key => $label): ?>
                        <option value="<?= $key ?>" <?= $current_category == $key ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-info me-2">
                    <i class="bi bi-search"></i> Search
                </button>
                <a href="<?= BASE_URL ?>publications" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Results -->
<?php if (!empty($current_search) || !empty($current_category)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        Showing results for: 
        <?php if (!empty($current_search)): ?>
            "<strong><?= htmlspecialchars($current_search) ?></strong>"
        <?php endif; ?>
        <?php if (!empty($current_category)): ?>
            Category: <strong><?= $categories[$current_category] ?></strong>
        <?php endif; ?>
        (<?= count($publications) ?> results found)
    </div>
<?php endif; ?>

<!-- Publications List -->
<?php if (!empty($publications)): ?>
    <div class="row">
        <?php foreach ($publications as $publication): ?>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="badge bg-<?= $publication['category'] === 'announcement' ? 'warning' : ($publication['category'] === 'memo' ? 'info' : ($publication['category'] === 'legislative_update' ? 'primary' : 'secondary')) ?> fs-6">
                            <?= ucfirst(str_replace('_', ' ', $publication['category'])) ?>
                        </span>
                        <small class="text-muted">
                            <i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($publication['date_posted'])) ?>
                        </small>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?= BASE_URL ?>publications/view/<?= $publication['id'] ?>" class="text-decoration-none">
                                <?= htmlspecialchars($publication['title']) ?>
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted">
                            <?= htmlspecialchars(substr($publication['content'], 0, 200)) ?>...
                        </p>
                        
                        <?php if (!empty($publication['created_by_name'])): ?>
                            <small class="text-muted">
                                <i class="bi bi-person"></i> Published by <?= htmlspecialchars($publication['created_by_name']) ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>publications/view/<?= $publication['id'] ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Read More
                            </a>
                            <?php if (!empty($publication['file_path'])): ?>
                                <a href="<?= BASE_URL ?>publications/download/<?= $publication['id'] ?>" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <i class="bi bi-megaphone display-1 text-muted"></i>
        <h4 class="mt-3 text-muted">No publications found</h4>
        <p class="text-muted">Try adjusting your search criteria or check back later.</p>
        <a href="<?= BASE_URL ?>publications" class="btn btn-info">View All Publications</a>
    </div>
<?php endif; ?>
