<?php 
$current_page = 'ordinances';
$title = 'Ordinances - Baggao Legislative Information System';
ob_start(); 
?>


<!-- Search and Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="GET" action="<?= BASE_URL ?>ordinances" class="row g-4">
            <div class="col-md-5">
                <label for="search" class="form-label fw-semibold">Search Ordinances</label>
                <input type="text" class="form-control form-control-lg" id="search" name="search" 
                       placeholder="Search by title, number, or keywords..." 
                       value="<?= htmlspecialchars($current_search) ?>">
            </div>
            <div class="col-md-3">
                <label for="year" class="form-label fw-semibold">Filter by Year</label>
                <select class="form-select form-select-lg" id="year" name="year">
                    <option value="">All Years</option>
                    <?php foreach ($years as $year): ?>
                        <option value="<?= $year ?>" <?= $current_year == $year ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                    <i class="bi bi-search me-2"></i>Search
                </button>
                <a href="<?= BASE_URL ?>ordinances" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Results -->
<?php if (!empty($current_search) || !empty($current_year)): ?>
    <div class="alert alert-primary border-0 shadow-sm d-flex align-items-center">
        <i class="bi bi-info-circle me-3 fs-5"></i>
        <div>
            <strong>Search Results:</strong>
            <?php if (!empty($current_search)): ?>
                Searching for "<strong class="text-primary"><?= htmlspecialchars($current_search) ?></strong>"
            <?php endif; ?>
            <?php if (!empty($current_year)): ?>
                <?= !empty($current_search) ? ' in ' : '' ?>Year <strong class="text-primary"><?= $current_year ?></strong>
            <?php endif; ?>
            <span class="text-muted">(<?= count($ordinances) ?> results found)</span>
        </div>
    </div>
<?php endif; ?>

<!-- Ordinances List -->
<?php if (!empty($ordinances)): ?>
    <div class="row g-4">
        <?php foreach ($ordinances as $ordinance): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-header bg-transparent border-bottom border-light d-flex justify-content-between align-items-center p-4">
                        <h6 class="mb-0 text-primary fw-bold">
                            <?= htmlspecialchars($ordinance['ordinance_number']) ?>
                        </h6>
                        <span class="badge bg-<?= $ordinance['status'] === 'passed' ? 'success' : ($ordinance['status'] === 'pending' ? 'warning' : 'danger') ?> px-3 py-2">
                            <?= ucfirst($ordinance['status']) ?>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h6 class="card-title mb-3">
                            <a href="<?= BASE_URL ?>ordinances/view/<?= $ordinance['id'] ?>" class="text-decoration-none text-dark hover-text-primary">
                                <?= htmlspecialchars($ordinance['title']) ?>
                            </a>
                        </h6>
                        
                        <?php if (!empty($ordinance['summary'])): ?>
                            <p class="card-text text-muted mb-3" style="font-size: 0.9rem; line-height: 1.5;">
                                <?= htmlspecialchars(substr($ordinance['summary'], 0, 120)) ?>...
                            </p>
                        <?php endif; ?>
                        
                        <div class="d-flex flex-column gap-2 text-muted mb-3" style="font-size: 0.85rem;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-fill me-2 text-primary"></i>
                                <span><?= htmlspecialchars($ordinance['author_name']) ?></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                <span><?= date('F d, Y', strtotime($ordinance['date_passed'])) ?></span>
                            </div>
                        </div>
                        
                        <?php if (!empty($ordinance['keywords'])): ?>
                            <div class="mb-3">
                                <?php 
                                $keywords = explode(',', $ordinance['keywords']);
                                $displayed_keywords = array_slice($keywords, 0, 3); // Show only first 3
                                foreach ($displayed_keywords as $keyword): 
                                ?>
                                    <span class="badge bg-light text-dark border me-1 mb-1"><?= htmlspecialchars(trim($keyword)) ?></span>
                                <?php endforeach; ?>
                                <?php if (count($keywords) > 3): ?>
                                    <span class="badge bg-muted text-white">+<?= count($keywords) - 3 ?> more</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 p-4 pt-0">
                        <div class="d-flex gap-2">
                            <a href="<?= BASE_URL ?>ordinances/view/<?= $ordinance['id'] ?>" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                            <?php if (!empty($ordinance['file_path'])): ?>
                                <a href="<?= BASE_URL ?>ordinances/download/<?= $ordinance['id'] ?>" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-download"></i>
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
        <div class="mb-4">
            <i class="bi bi-file-text-fill display-1 text-muted opacity-50"></i>
        </div>
        <h4 class="text-muted mb-3">No ordinances found</h4>
        <p class="text-muted mb-4">Try adjusting your search criteria or check back later for new ordinances.</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="<?= BASE_URL ?>ordinances" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-clockwise me-2"></i>View All Ordinances
            </a>
            <a href="<?= BASE_URL ?>" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-house me-2"></i>Back to Home
            </a>
        </div>
    </div>
<?php endif; ?>
