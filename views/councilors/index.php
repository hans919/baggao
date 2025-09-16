<?php 
$current_page = 'councilors';
$title = 'Councilor Portfolio - Baggao Legislative Information System';
ob_start(); 
?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="page-title"><i class="bi bi-people me-2"></i>Councilor Portfolio</h2>
</div>

<!-- Councilors Grid -->
<?php if (!empty($councilors)): ?>
    <div class="row g-4">
        <?php foreach ($councilors as $councilor): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <!-- Profile Photo -->
                        <div class="mb-4">
                            <?php if (!empty($councilor['photo'])): ?>
                                <img src="<?= BASE_URL . UPLOAD_PATH . $councilor['photo'] ?>" 
                                     alt="<?= htmlspecialchars($councilor['name']) ?>" 
                                     class="rounded-circle border border-3 border-light shadow-sm" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center border border-3 border-light shadow-sm" 
                                     style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: 600;">
                                    <?= strtoupper(substr($councilor['name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Name and Position -->
                        <h5 class="card-title text-primary fw-semibold mb-1"><?= htmlspecialchars($councilor['name']) ?></h5>
                        <h6 class="card-subtitle mb-3 text-muted fw-medium"><?= htmlspecialchars($councilor['position']) ?></h6>
                        
                        <!-- Term -->
                        <div class="mb-3">
                            <small class="text-muted d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar3 me-2"></i>
                                Term: <?= $councilor['term_start'] ?> - <?= $councilor['term_end'] ?>
                            </small>
                        </div>
                        
                        <!-- Committees -->
                        <?php if (!empty($councilor['committees'])): ?>
                            <div class="mb-3">
                                <h6 class="text-muted fw-semibold mb-2">Committees:</h6>
                                <p class="small text-muted"><?= htmlspecialchars($councilor['committees']) ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Contact Info -->
                        <?php if (!empty($councilor['contact_info'])): ?>
                            <div class="mb-4">
                                <h6 class="text-muted fw-semibold mb-2">Contact:</h6>
                                <p class="small text-muted"><?= nl2br(htmlspecialchars($councilor['contact_info'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <div class="d-grid">
                            <a href="<?= BASE_URL ?>councilors/view/<?= $councilor['id'] ?>" class="btn btn-primary">
                                <i class="bi bi-eye me-2"></i>View Portfolio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-people display-1 text-muted opacity-25"></i>
        </div>
        <h4 class="fw-semibold text-muted mb-2">No councilors found</h4>
        <p class="text-muted mb-4">Councilor information will be available soon.</p>
        <a href="<?= BASE_URL ?>" class="btn btn-primary">
            <i class="bi bi-house-door me-2"></i>Back to Home
        </a>
    </div>
<?php endif; ?>
