<?php 
$current_page = 'home';
$title = 'Home - Baggao Legislative Information System';
ob_start(); 
?>

<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 bg-primary text-white overflow-hidden">
            <div class="card-body text-center py-5 position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);"></div>
                <div class="position-relative">
                    <h1 class="display-5 fw-bold mb-3">Welcome to Baggao Legislative Information System</h1>
                    <p class="lead mb-4 opacity-90">Access ordinances, resolutions, meeting minutes, and legislative information for the Municipality of Baggao</p>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <form method="GET" action="<?= BASE_URL ?>home/search" class="d-flex gap-2">
                                <input type="text" name="q" class="form-control form-control-lg" 
                                       placeholder="Search ordinances, resolutions, minutes..." 
                                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                                <button type="submit" class="btn btn-light btn-lg px-4">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="card h-100 text-center border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-3">
                    <i class="bi bi-file-text display-4 text-primary"></i>
                </div>
                <h5 class="card-title fw-semibold">Ordinances</h5>
                <p class="card-text text-muted small mb-3">Municipal ordinances and local laws</p>
                <a href="<?= BASE_URL ?>ordinances" class="btn btn-primary btn-sm">View All</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100 text-center border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-3">
                    <i class="bi bi-file-earmark-check display-4 text-success"></i>
                </div>
                <h5 class="card-title fw-semibold">Resolutions</h5>
                <p class="card-text text-muted small mb-3">Council resolutions and decisions</p>
                <a href="<?= BASE_URL ?>resolutions" class="btn btn-success btn-sm">View All</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100 text-center border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-3">
                    <i class="bi bi-journal-text display-4 text-info"></i>
                </div>
                <h5 class="card-title fw-semibold">Meeting Minutes</h5>
                <p class="card-text text-muted small mb-3">Official records of council meetings</p>
                <a href="<?= BASE_URL ?>minutes" class="btn btn-info btn-sm">View All</a>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100 text-center border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="mb-3">
                    <i class="bi bi-people display-4 text-warning"></i>
                </div>
                <h5 class="card-title fw-semibold">Councilors</h5>
                <p class="card-text text-muted small mb-3">Council member profiles and portfolios</p>
                <a href="<?= BASE_URL ?>councilors" class="btn btn-warning btn-sm">View All</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Content -->
<div class="row g-4">
    <!-- Recent Ordinances -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-file-text me-2 text-primary"></i>Recent Ordinances
                </h5>
                <a href="<?= BASE_URL ?>ordinances" class="btn btn-outline-primary btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_ordinances)): ?>
                    <?php foreach ($recent_ordinances as $index => $ordinance): ?>
                        <div class="p-3 <?= $index < count($recent_ordinances) - 1 ? 'border-bottom' : '' ?>">
                            <h6 class="mb-2 fw-semibold">
                                <a href="<?= BASE_URL ?>ordinances/view/<?= $ordinance['id'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($ordinance['ordinance_number']) ?>
                                </a>
                            </h6>
                            <p class="text-muted small mb-2"><?= htmlspecialchars(substr($ordinance['title'], 0, 80)) ?>...</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span class="me-3"><?= date('M d, Y', strtotime($ordinance['date_passed'])) ?></span>
                                <i class="bi bi-person me-1"></i>
                                <span><?= htmlspecialchars($ordinance['author_name']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-file-text display-4 mb-3 opacity-25"></i>
                        <p class="mb-0">No ordinances found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Resolutions -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-file-earmark-check me-2 text-success"></i>Recent Resolutions
                </h5>
                <a href="<?= BASE_URL ?>resolutions" class="btn btn-outline-success btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_resolutions)): ?>
                    <?php foreach ($recent_resolutions as $index => $resolution): ?>
                        <div class="p-3 <?= $index < count($recent_resolutions) - 1 ? 'border-bottom' : '' ?>">
                            <h6 class="mb-2 fw-semibold">
                                <a href="<?= BASE_URL ?>resolutions/view/<?= $resolution['id'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($resolution['resolution_number']) ?>
                                </a>
                            </h6>
                            <p class="text-muted small mb-2"><?= htmlspecialchars(substr($resolution['subject'], 0, 80)) ?>...</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span class="me-3"><?= date('M d, Y', strtotime($resolution['date_approved'])) ?></span>
                                <i class="bi bi-person me-1"></i>
                                <span><?= htmlspecialchars($resolution['author_name']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-file-earmark-check display-4 mb-3 opacity-25"></i>
                        <p class="mb-0">No resolutions found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <!-- Recent Publications -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-megaphone me-2 text-info"></i>Recent Publications
                </h5>
                <a href="<?= BASE_URL ?>publications" class="btn btn-outline-info btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_publications)): ?>
                    <?php foreach ($recent_publications as $index => $publication): ?>
                        <div class="p-3 <?= $index < count($recent_publications) - 1 ? 'border-bottom' : '' ?>">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-semibold flex-grow-1">
                                    <a href="<?= BASE_URL ?>publications/view/<?= $publication['id'] ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($publication['title']) ?>
                                    </a>
                                </h6>
                                <span class="badge bg-<?= $publication['category'] === 'announcement' ? 'warning' : ($publication['category'] === 'memo' ? 'info' : 'secondary') ?> ms-2">
                                    <?= ucfirst(str_replace('_', ' ', $publication['category'])) ?>
                                </span>
                            </div>
                            <p class="text-muted small mb-2"><?= htmlspecialchars(substr($publication['content'], 0, 80)) ?>...</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span><?= date('M d, Y', strtotime($publication['date_posted'])) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-megaphone display-4 mb-3 opacity-25"></i>
                        <p class="mb-0">No publications found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Minutes -->
    <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-journal-text me-2 text-warning"></i>Recent Meeting Minutes
                </h5>
                <a href="<?= BASE_URL ?>minutes" class="btn btn-outline-warning btn-sm">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_minutes)): ?>
                    <?php foreach ($recent_minutes as $index => $minute): ?>
                        <div class="p-3 <?= $index < count($recent_minutes) - 1 ? 'border-bottom' : '' ?>">
                            <h6 class="mb-2 fw-semibold">
                                <a href="<?= BASE_URL ?>minutes/view/<?= $minute['id'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($minute['session_type']) ?>
                                </a>
                            </h6>
                            <p class="text-muted small mb-2"><?= htmlspecialchars(substr($minute['summary'], 0, 80)) ?>...</p>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span><?= date('M d, Y', strtotime($minute['meeting_date'])) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-journal-text display-4 mb-3 opacity-25"></i>
                        <p class="mb-0">No meeting minutes found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
