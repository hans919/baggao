<?php 
$current_page = 'ordinances';
$title = htmlspecialchars($ordinance['ordinance_number']) . ' - Baggao Legislative Information System';
ob_start(); 
?>

<!-- Breadcrumb Section -->
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-muted text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>ordinances" class="text-muted text-decoration-none">Ordinances</a></li>
            <li class="breadcrumb-item active text-primary fw-semibold"><?= htmlspecialchars($ordinance['ordinance_number']) ?></li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-to-r from-primary to-secondary text-white d-flex justify-content-between align-items-center p-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-file-text-fill me-3 fs-4"></i>
                    <?= htmlspecialchars($ordinance['ordinance_number']) ?>
                </h5>
                <span class="badge bg-<?= $ordinance['status'] === 'passed' ? 'success' : ($ordinance['status'] === 'pending' ? 'warning text-dark' : 'danger') ?> px-3 py-2 fs-6">
                    <?= ucfirst($ordinance['status']) ?>
                </span>
            </div>
            <div class="card-body p-4">
                <h3 class="card-title mb-4 text-dark fw-bold lh-base"><?= htmlspecialchars($ordinance['title']) ?></h3>
                
                <!-- Key Information Grid -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-person-circle text-primary fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Author</h6>
                                <p class="text-muted mb-0"><?= htmlspecialchars($ordinance['author_name']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-calendar-check text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">Date Passed</h6>
                                <p class="text-muted mb-0"><?= date('F d, Y', strtotime($ordinance['date_passed'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($ordinance['summary'])): ?>
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-card-text text-info fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Summary</h6>
                        </div>
                        <div class="bg-light rounded-3 p-4">
                            <p class="mb-0 lh-lg" style="text-align: justify;"><?= nl2br(htmlspecialchars($ordinance['summary'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($ordinance['keywords'])): ?>
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-tags text-warning fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Keywords</h6>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <?php 
                            $keywords = explode(',', $ordinance['keywords']);
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
                                <strong class="text-dark"><?= date('M d, Y g:i A', strtotime($ordinance['created_at'])) ?></strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-2 p-3">
                                <small class="text-muted d-block">Last Updated</small>
                                <strong class="text-dark"><?= date('M d, Y g:i A', strtotime($ordinance['updated_at'])) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comments Section -->
            <div class="border-top pt-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-chat-dots text-info fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold">Comments</h6>
                </div>
                
                <!-- Comment Form -->
                <div class="bg-light rounded-3 p-4 mb-4">
                    <h6 class="fw-semibold mb-3">Leave a Comment</h6>
                    <form action="<?= BASE_URL ?>ordinances/comment/<?= $ordinance['id'] ?>" method="POST">
                        <div class="mb-3">
                            <textarea class="form-control" name="comment_text" rows="3" placeholder="Share your thoughts about this ordinance..." required></textarea>
                            <div class="form-text">Comments are posted anonymously.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Post Comment
                        </button>
                    </form>
                </div>

                <!-- Display Comments -->
                <?php if (!empty($comments)): ?>
                    <div class="comments-list">
                        <?php foreach ($comments as $comment): ?>
                            <div class="bg-light rounded-3 p-3 mb-3">
                                <p class="mb-2"><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>
                                <small class="text-muted">Posted on <?= date('M d, Y g:i A', strtotime($comment['created_at'])) ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <p>No comments yet. Be the first to comment!</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="card-footer bg-light border-0 p-4">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center">
                    <a href="<?= BASE_URL ?>ordinances" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i> Back to Ordinances
                    </a>
                    
                    <div class="d-flex gap-2">
                        <?php if (!empty($ordinance['file_path'])): ?>
                            <?php 
                                $fileName = basename($ordinance['file_path']);
                                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                $fileIcon = 'bi-file-earmark';
                                if ($fileExt === 'pdf') $fileIcon = 'bi-file-pdf';
                                elseif ($fileExt === 'doc' || $fileExt === 'docx') $fileIcon = 'bi-file-word';
                            ?>
                            <a href="<?= BASE_URL ?>ordinances/download/<?= $ordinance['id'] ?>" class="btn btn-success d-flex align-items-center" download>
                                <i class="bi <?= $fileIcon ?> me-2"></i> Download <?= strtoupper($fileExt) ?>: <?= htmlspecialchars($fileName) ?>
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
            <div class="card-header bg-primary bg-opacity-10 border-0 p-4">
                <h6 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="bi bi-lightning-fill me-2 text-primary"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="<?= BASE_URL ?>ordinances" class="btn btn-outline-primary d-flex align-items-center">
                        <i class="bi bi-list me-2"></i> View All Ordinances
                    </a>
                    <a href="<?= BASE_URL ?>ordinances?year=<?= date('Y', strtotime($ordinance['date_passed'])) ?>" class="btn btn-outline-info d-flex align-items-center">
                        <i class="bi bi-calendar3 me-2"></i> <?= date('Y', strtotime($ordinance['date_passed'])) ?> Ordinances
                    </a>
                    <a href="<?= BASE_URL ?>councilors/view/<?= $ordinance['author_id'] ?>" class="btn btn-outline-success d-flex align-items-center">
                        <i class="bi bi-person me-2"></i> Author's Profile
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Related Documents -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success bg-opacity-10 border-0 p-4">
                <h6 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="bi bi-files me-2 text-success"></i>Related Documents
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="<?= BASE_URL ?>resolutions?search=<?= urlencode(explode(',', $ordinance['keywords'])[0] ?? '') ?>" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-file-earmark-check me-2"></i> Related Resolutions
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
