<?php 
$current_page = 'publications';
$title = htmlspecialchars($publication['title']) . ' - Baggao Legislative Information System';
ob_start(); 
?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>publications">Publications</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars(substr($publication['title'], 0, 30)) ?>...</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="badge bg-<?= $publication['category'] === 'announcement' ? 'warning' : ($publication['category'] === 'memo' ? 'info' : ($publication['category'] === 'legislative_update' ? 'primary' : 'secondary')) ?> fs-6">
                    <i class="bi bi-megaphone me-1"></i>
                    <?= ucfirst(str_replace('_', ' ', $publication['category'])) ?>
                </span>
                <span class="text-muted">
                    <?= date('F d, Y', strtotime($publication['date_posted'])) ?>
                </span>
            </div>
            <div class="card-body">
                <h3 class="card-title mb-4"><?= htmlspecialchars($publication['title']) ?></h3>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="bi bi-calendar3 me-2"></i>Date Posted</h6>
                        <p class="text-muted"><?= date('F d, Y', strtotime($publication['date_posted'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-person-circle me-2"></i>Published By</h6>
                        <p class="text-muted"><?= htmlspecialchars($publication['created_by_name'] ?? 'System Administrator') ?></p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6><i class="bi bi-file-text me-2"></i>Content</h6>
                    <div class="text-justify">
                        <?= nl2br(htmlspecialchars($publication['content'])) ?>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6><i class="bi bi-info-circle me-2"></i>Publication Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Category: <?= ucfirst(str_replace('_', ' ', $publication['category'])) ?></small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Status: <?= ucfirst($publication['status']) ?></small>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <small class="text-muted">Created: <?= date('M d, Y g:i A', strtotime($publication['created_at'])) ?></small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Last Updated: <?= date('M d, Y g:i A', strtotime($publication['updated_at'])) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= BASE_URL ?>publications" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Publications
                    </a>
                    
                    <div>
                        <?php if (!empty($publication['file_path'])): ?>
                            <a href="<?= BASE_URL ?>publications/download/<?= $publication['id'] ?>" class="btn btn-success">
                                <i class="bi bi-download"></i> Download Attachment
                            </a>
                        <?php endif; ?>
                        <button class="btn btn-primary" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>publications" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-list"></i> View All Publications
                    </a>
                    <a href="<?= BASE_URL ?>publications?category=<?= $publication['category'] ?>" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-tag"></i> Same Category
                    </a>
                    <a href="<?= BASE_URL ?>home/search?q=<?= urlencode($publication['category']) ?>" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-search"></i> Related Content
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Publications -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Publications</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>publications?category=announcement" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-bullhorn"></i> Announcements
                    </a>
                    <a href="<?= BASE_URL ?>publications?category=memo" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-file-earmark-text"></i> Memos
                    </a>
                    <a href="<?= BASE_URL ?>publications?category=legislative_update" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-newspaper"></i> Legislative Updates
                    </a>
                    <a href="<?= BASE_URL ?>publications?category=notice" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-info-square"></i> Notices
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .card-footer, .btn, nav, .col-lg-4 {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
