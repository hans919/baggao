<?php 
$current_page = 'minutes';
$title = 'Meeting Minutes - ' . date('F d, Y', strtotime($minute['meeting_date'])) . ' - Baggao Legislative Information System';
ob_start(); 
?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>minutes">Meeting Minutes</a></li>
            <li class="breadcrumb-item active"><?= date('M d, Y', strtotime($minute['meeting_date'])) ?></li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-info fw-bold">
                    <i class="bi bi-journal-text me-2"></i>
                    <?= htmlspecialchars($minute['session_type']) ?>
                </h5>
                <span class="badge bg-info fs-6">
                    <?= date('F d, Y', strtotime($minute['meeting_date'])) ?>
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><i class="bi bi-calendar3 me-2"></i>Meeting Date</h6>
                        <p class="text-muted"><?= date('F d, Y', strtotime($minute['meeting_date'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-clock me-2"></i>Session Type</h6>
                        <p class="text-muted"><?= htmlspecialchars($minute['session_type']) ?></p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6><i class="bi bi-list-check me-2"></i>Agenda</h6>
                    <div class="bg-light p-3 rounded">
                        <?= nl2br(htmlspecialchars($minute['agenda'])) ?>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6><i class="bi bi-people me-2"></i>Attendees</h6>
                    <div class="bg-light p-3 rounded">
                        <?php 
                        $attendees = explode(',', $minute['attendees']);
                        foreach ($attendees as $attendee):
                        ?>
                            <span class="badge bg-primary me-2 mb-1"><?= htmlspecialchars(trim($attendee)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6><i class="bi bi-file-text me-2"></i>Meeting Summary</h6>
                    <div class="text-justify">
                        <?= nl2br(htmlspecialchars($minute['summary'])) ?>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6><i class="bi bi-info-circle me-2"></i>Additional Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Published: <?= date('M d, Y g:i A', strtotime($minute['created_at'])) ?></small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Last Updated: <?= date('M d, Y g:i A', strtotime($minute['updated_at'])) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= BASE_URL ?>minutes" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Minutes
                    </a>
                    
                    <div>
                        <?php if (!empty($minute['file_path'])): ?>
                            <a href="<?= BASE_URL ?>minutes/download/<?= $minute['id'] ?>" class="btn btn-success">
                                <i class="bi bi-download"></i> Download PDF
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
                    <a href="<?= BASE_URL ?>minutes" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-list"></i> View All Minutes
                    </a>
                    <a href="<?= BASE_URL ?>minutes?year=<?= date('Y', strtotime($minute['meeting_date'])) ?>" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-calendar3"></i> <?= date('Y', strtotime($minute['meeting_date'])) ?> Minutes
                    </a>
                    <a href="<?= BASE_URL ?>councilors" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-people"></i> View Councilors
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Related Documents -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-files me-2"></i>Related Documents</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>ordinances?year=<?= date('Y', strtotime($minute['meeting_date'])) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-file-text"></i> <?= date('Y', strtotime($minute['meeting_date'])) ?> Ordinances
                    </a>
                    <a href="<?= BASE_URL ?>resolutions?year=<?= date('Y', strtotime($minute['meeting_date'])) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-file-earmark-check"></i> <?= date('Y', strtotime($minute['meeting_date'])) ?> Resolutions
                    </a>
                    <a href="<?= BASE_URL ?>publications" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-megaphone"></i> Publications
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
