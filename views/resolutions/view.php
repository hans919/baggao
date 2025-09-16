<?php 
$current_page = 'resolutions';
$title = htmlspecialchars($resolution['resolution_number']) . ' - Baggao Legislative Information System';
ob_start(); 
?>

<!-- Breadcrumb Section -->
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-muted text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>resolutions" class="text-muted text-decoration-none">Resolutions</a></li>
            <li class="breadcrumb-item active text-success fw-semibold"><?= htmlspecialchars($resolution['resolution_number']) ?></li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-to-r from-success to-primary text-white d-flex justify-content-between align-items-center p-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-file-earmark-check-fill me-3 fs-4"></i>
                    <?= htmlspecialchars($resolution['resolution_number']) ?>
                </h5>
                <span class="badge bg-<?= $resolution['status'] === 'approved' ? 'light text-success' : ($resolution['status'] === 'pending' ? 'warning text-dark' : 'danger') ?> px-3 py-2 fs-6">
                    <?= ucfirst($resolution['status']) ?>
                </span>
            </div>
            <div class="card-body p-4">
                <h3 class="card-title mb-4 text-dark fw-bold lh-base"><?= htmlspecialchars($resolution['subject']) ?></h3>
                
                <!-- Key Information Grid -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-person-circle text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Author</h6>
                                <p class="text-muted mb-0"><?= htmlspecialchars($resolution['author_name']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-calendar-check text-primary fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Date Approved</h6>
                                <p class="text-muted mb-0"><?= date('F d, Y', strtotime($resolution['date_approved'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($resolution['summary'])): ?>
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-card-text text-info fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Summary</h6>
                        </div>
                        <div class="bg-light rounded-3 p-4">
                            <p class="mb-0 lh-lg" style="text-align: justify;"><?= nl2br(htmlspecialchars($resolution['summary'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($resolution['keywords'])): ?>
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-tags text-warning fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Keywords</h6>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <?php 
                            $keywords = explode(',', $resolution['keywords']);
                            foreach ($keywords as $keyword): 
                            ?>
                                <span class="badge bg-light text-dark border px-3 py-2 fw-normal"><?= htmlspecialchars(trim($keyword)) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Document Metadata -->
                <div class="border-top pt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-info-circle text-secondary fs-5"></i>
                        </div>
                        <h6 class="mb-0 fw-semibold text-muted">Document Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-light rounded-2 p-3">
                                <small class="text-muted d-block">Created</small>
                                <strong class="text-dark"><?= date('M d, Y g:i A', strtotime($resolution['created_at'])) ?></strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-2 p-3">
                                <small class="text-muted d-block">Last Updated</small>
                                <strong class="text-dark"><?= date('M d, Y g:i A', strtotime($resolution['updated_at'])) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-0 p-4">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center">
                    <a href="<?= BASE_URL ?>resolutions" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i> Back to Resolutions
                    </a>
                    
                    <div class="d-flex gap-2">
                        <?php if (!empty($resolution['file_path'])): ?>
                            <a href="<?= BASE_URL ?>resolutions/download/<?= $resolution['id'] ?>" class="btn btn-success d-flex align-items-center">
                                <i class="bi bi-download me-2"></i> Download PDF
                            </a>
                        <?php endif; ?>
                        <button class="btn btn-primary d-flex align-items-center" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-success bg-opacity-10 border-0 p-4">
                <h6 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="bi bi-lightning-fill me-2 text-success"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="<?= BASE_URL ?>resolutions" class="btn btn-outline-success d-flex align-items-center">
                        <i class="bi bi-list me-2"></i> View All Resolutions
                    </a>
                    <a href="<?= BASE_URL ?>resolutions?year=<?= date('Y', strtotime($resolution['date_approved'])) ?>" class="btn btn-outline-info d-flex align-items-center">
                        <i class="bi bi-calendar3 me-2"></i> <?= date('Y', strtotime($resolution['date_approved'])) ?> Resolutions
                    </a>
                    <a href="<?= BASE_URL ?>councilors/view/<?= $resolution['author_id'] ?>" class="btn btn-outline-primary d-flex align-items-center">
                        <i class="bi bi-person me-2"></i> Author's Profile
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Related Documents -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary bg-opacity-10 border-0 p-4">
                <h6 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="bi bi-files me-2 text-primary"></i>Related Documents
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="<?= BASE_URL ?>ordinances?search=<?= urlencode(explode(',', $resolution['keywords'])[0] ?? '') ?>" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-file-text me-2"></i> Related Ordinances
                    </a>
                    <a href="<?= BASE_URL ?>minutes" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-journal-text me-2"></i> Meeting Minutes
                    </a>
                    <a href="<?= BASE_URL ?>publications" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-megaphone me-2"></i> Publications
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
