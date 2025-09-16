<?php 
$current_page = 'minutes';
$title = 'Meeting Minutes - Baggao Legislative Information System';
ob_start(); 
?>


<!-- Search and Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="GET" action="<?= BASE_URL ?>minutes" class="row g-4">
            <div class="col-md-5">
                <label for="search" class="form-label fw-semibold">Search Minutes</label>
                <input type="text" class="form-control form-control-lg" id="search" name="search" 
                       placeholder="Search by agenda, summary, or session type..." 
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
                <button type="submit" class="btn btn-info btn-lg flex-grow-1">
                    <i class="bi bi-search me-2"></i>Search
                </button>
                <a href="<?= BASE_URL ?>minutes" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Results -->
<?php if (!empty($current_search) || !empty($current_year)): ?>
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
        <i class="bi bi-info-circle me-3 fs-5"></i>
        <div>
            <strong>Search Results:</strong>
            <?php if (!empty($current_search)): ?>
                Searching for "<strong class="text-info"><?= htmlspecialchars($current_search) ?></strong>"
            <?php endif; ?>
            <?php if (!empty($current_year)): ?>
                <?= !empty($current_search) ? ' in ' : '' ?>Year <strong class="text-info"><?= $current_year ?></strong>
            <?php endif; ?>
            <span class="text-muted">(<?= count($minutes) ?> results found)</span>
        </div>
    </div>
<?php endif; ?>

<!-- Minutes List -->
<?php if (!empty($minutes)): ?>
    <div class="row g-4">
        <?php foreach ($minutes as $minute): ?>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-header bg-white border-bottom border-light d-flex justify-content-between align-items-center p-4">
                        <h6 class="mb-0 text-info fw-bold">
                            <?= htmlspecialchars($minute['session_type']) ?>
                        </h6>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-calendar3 me-1"></i><?= date('M d, Y', strtotime($minute['meeting_date'])) ?>
                        </span>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <h6 class="card-title mb-3 text-dark">Meeting Summary</h6>
                        <p class="card-text text-muted mb-3" style="line-height: 1.5;">
                            <?= htmlspecialchars(substr($minute['summary'], 0, 150)) ?>...
                        </p>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-list-check me-2 text-info"></i>
                                <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">Agenda Highlights</h6>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">
                                <?= htmlspecialchars(substr($minute['agenda'], 0, 100)) ?>...
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people-fill me-2 text-info"></i>
                                <span class="fw-semibold text-dark" style="font-size: 0.9rem;">
                                    <?php 
                                    $attendees = explode(',', $minute['attendees']);
                                    echo count($attendees) . ' attendees';
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 p-4 pt-0">
                        <div class="d-flex gap-2">
                            <a href="<?= BASE_URL ?>minutes/view/<?= $minute['id'] ?>" class="btn btn-info btn-sm flex-grow-1">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                            <?php if (!empty($minute['file_path'])): ?>
                                <a href="<?= BASE_URL ?>minutes/download/<?= $minute['id'] ?>" class="btn btn-outline-success btn-sm">
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
            <i class="bi bi-journal-text-fill display-1 text-muted opacity-50"></i>
        </div>
        <h4 class="text-dark mb-3">No meeting minutes found</h4>
        <p class="text-muted mb-4">Try adjusting your search criteria or check back later for new meeting records.</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="<?= BASE_URL ?>minutes" class="btn btn-info btn-lg">
                <i class="bi bi-arrow-clockwise me-2"></i>View All Minutes
            </a>
            <a href="<?= BASE_URL ?>" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-house me-2"></i>Back to Home
            </a>
        </div>
    </div>
<?php endif; ?>
