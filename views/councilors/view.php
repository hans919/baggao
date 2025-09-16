<?php 
$current_page = 'councilors';
$title = htmlspecialchars($councilor['name']) . ' - Councilor Portfolio - Baggao Legislative Information System';
ob_start(); 
?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>councilors" class="text-decoration-none">Councilors</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($councilor['name']) ?></li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card border-0 shadow-sm text-center mb-4">
            <div class="card-body p-4">
                <!-- Profile Photo -->
                <div class="mb-4">
                    <?php if (!empty($councilor['photo'])): ?>
                        <img src="<?= BASE_URL . UPLOAD_PATH . $councilor['photo'] ?>" 
                             alt="<?= htmlspecialchars($councilor['name']) ?>" 
                             class="rounded-circle border border-3 border-light shadow-sm" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center border border-3 border-light shadow-sm" 
                             style="width: 150px; height: 150px; font-size: 3rem; font-weight: 600;">
                            <?= strtoupper(substr($councilor['name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Name and Position -->
                <h3 class="card-title text-primary fw-bold mb-2"><?= htmlspecialchars($councilor['name']) ?></h3>
                <h5 class="card-subtitle mb-3 text-muted fw-medium"><?= htmlspecialchars($councilor['position']) ?></h5>
                
                <!-- Term -->
                <div class="mb-3">
                    <h6 class="text-muted fw-semibold mb-2">Term of Office</h6>
                    <small class="text-muted d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar3 me-2"></i>
                        <?= $councilor['term_start'] ?> - <?= $councilor['term_end'] ?>
                    </small>
                </div>
                
                <!-- Status -->
                <span class="badge bg-<?= $councilor['status'] === 'active' ? 'success' : 'secondary' ?> fs-6 px-3 py-2">
                    <i class="bi bi-<?= $councilor['status'] === 'active' ? 'check-circle' : 'dash-circle' ?> me-1"></i>
                    <?= ucfirst($councilor['status']) ?>
                </span>
            </div>
        </div>
        
        <!-- Contact Info -->
        <?php if (!empty($councilor['contact_info'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-telephone me-2"></i>Contact Information</h6>
            </div>
            <div class="card-body">
                <p class="mb-0"><?= nl2br(htmlspecialchars($councilor['contact_info'])) ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="col-lg-8">
        <!-- Committees -->
        <?php if (!empty($councilor['committees'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-people me-2"></i>Committee Memberships</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <?php 
                    $committees = explode(',', $councilor['committees']);
                    foreach ($committees as $committee):
                    ?>
                        <span class="badge bg-info fs-6 px-3 py-2"><?= htmlspecialchars(trim($committee)) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Contributions Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-bar-chart me-2"></i>Legislative Contributions</h5>
            </div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-primary bg-opacity-10 rounded">
                            <h3 class="text-primary mb-1"><?= $councilor['ordinance_count'] ?></h3>
                            <small class="text-muted fw-medium">Ordinances Authored</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-success bg-opacity-10 rounded">
                            <h3 class="text-success mb-1"><?= $councilor['resolution_count'] ?></h3>
                            <small class="text-muted fw-medium">Resolutions Authored</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Authored Ordinances -->
        <?php if (!empty($ordinances)): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-file-text me-2"></i>Authored Ordinances</h5>
                <span class="badge bg-primary"><?= count($ordinances) ?></span>
            </div>
            <div class="card-body p-0">
                <?php foreach ($ordinances as $index => $ordinance): ?>
                    <div class="p-3 <?= $index < count($ordinances) - 1 ? 'border-bottom' : '' ?>">
                        <h6 class="mb-2 fw-semibold">
                            <a href="<?= BASE_URL ?>ordinances/view/<?= $ordinance['id'] ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($ordinance['ordinance_number']) ?>
                            </a>
                        </h6>
                        <p class="text-muted small mb-2"><?= htmlspecialchars(substr($ordinance['title'], 0, 100)) ?>...</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?= date('M d, Y', strtotime($ordinance['date_passed'])) ?>
                            </small>
                            <span class="badge bg-<?= $ordinance['status'] === 'passed' ? 'success' : 'warning' ?> small">
                                <?= ucfirst($ordinance['status']) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Authored Resolutions -->
        <?php if (!empty($resolutions)): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold"><i class="bi bi-file-earmark-check me-2"></i>Authored Resolutions</h5>
                <span class="badge bg-success"><?= count($resolutions) ?></span>
            </div>
            <div class="card-body p-0">
                <?php foreach ($resolutions as $index => $resolution): ?>
                    <div class="p-3 <?= $index < count($resolutions) - 1 ? 'border-bottom' : '' ?>">
                        <h6 class="mb-2 fw-semibold">
                            <a href="<?= BASE_URL ?>resolutions/view/<?= $resolution['id'] ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($resolution['resolution_number']) ?>
                            </a>
                        </h6>
                        <p class="text-muted small mb-2"><?= htmlspecialchars(substr($resolution['subject'], 0, 100)) ?>...</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?= date('M d, Y', strtotime($resolution['date_approved'])) ?>
                            </small>
                            <span class="badge bg-<?= $resolution['status'] === 'approved' ? 'success' : 'warning' ?> small">
                                <?= ucfirst($resolution['status']) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- No Contributions Message -->
        <?php if (empty($ordinances) && empty($resolutions)): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-file-text display-4 text-muted opacity-25 mb-3"></i>
                <h5 class="text-muted mb-2">No legislative contributions found</h5>
                <p class="text-muted">This councilor has not authored any ordinances or resolutions yet.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Back Button -->
<div class="text-center mt-5">
    <a href="<?= BASE_URL ?>councilors" class="btn btn-primary">
        <i class="bi bi-arrow-left me-2"></i>Back to All Councilors
    </a>
</div>
