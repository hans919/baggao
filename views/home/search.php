<?php 
$current_page = 'home';
$title = 'Search Results - Baggao Legislative Information System';
ob_start(); 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title"><i class="bi bi-search me-2"></i>Search Results</h2>
</div>

<?php if (!empty($query)): ?>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= BASE_URL ?>home/search" class="row g-3">
                <div class="col-md-9">
                    <input type="text" class="form-control form-control-lg" name="q" 
                           placeholder="Search ordinances, resolutions, minutes, publications..." 
                           value="<?= htmlspecialchars($query) ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        Search results for: "<strong><?= htmlspecialchars($query) ?></strong>"
    </div>

    <!-- Search Results Tabs -->
    <ul class="nav nav-tabs" id="searchTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ordinances-tab" data-bs-toggle="tab" data-bs-target="#ordinances" type="button" role="tab">
                <i class="bi bi-file-text me-2"></i>Ordinances (<?= count($results['ordinances'] ?? []) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="resolutions-tab" data-bs-toggle="tab" data-bs-target="#resolutions" type="button" role="tab">
                <i class="bi bi-file-earmark-check me-2"></i>Resolutions (<?= count($results['resolutions'] ?? []) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="minutes-tab" data-bs-toggle="tab" data-bs-target="#minutes" type="button" role="tab">
                <i class="bi bi-journal-text me-2"></i>Minutes (<?= count($results['minutes'] ?? []) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="publications-tab" data-bs-toggle="tab" data-bs-target="#publications" type="button" role="tab">
                <i class="bi bi-megaphone me-2"></i>Publications (<?= count($results['publications'] ?? []) ?>)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="searchTabsContent">
        <!-- Ordinances Results -->
        <div class="tab-pane fade show active" id="ordinances" role="tabpanel">
            <div class="mt-4">
                <?php if (!empty($results['ordinances'])): ?>
                    <div class="row">
                        <?php foreach ($results['ordinances'] as $ordinance): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            <a href="<?= BASE_URL ?>ordinances/view/<?= $ordinance['id'] ?>" class="text-decoration-none">
                                                <?= htmlspecialchars($ordinance['ordinance_number']) ?>
                                            </a>
                                        </h6>
                                        <p class="card-text"><?= htmlspecialchars(substr($ordinance['title'], 0, 100)) ?>...</p>
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> <?= htmlspecialchars($ordinance['author_name']) ?> • 
                                            <i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($ordinance['date_passed'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-file-text display-4 text-muted"></i>
                        <p class="text-muted mt-2">No ordinances found matching your search.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Resolutions Results -->
        <div class="tab-pane fade" id="resolutions" role="tabpanel">
            <div class="mt-4">
                <?php if (!empty($results['resolutions'])): ?>
                    <div class="row">
                        <?php foreach ($results['resolutions'] as $resolution): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <a href="<?= BASE_URL ?>resolutions/view/<?= $resolution['id'] ?>" class="text-decoration-none">
                                                <?= htmlspecialchars($resolution['resolution_number']) ?>
                                            </a>
                                        </h6>
                                        <p class="card-text"><?= htmlspecialchars(substr($resolution['subject'], 0, 100)) ?>...</p>
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> <?= htmlspecialchars($resolution['author_name']) ?> • 
                                            <i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($resolution['date_approved'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-file-earmark-check display-4 text-muted"></i>
                        <p class="text-muted mt-2">No resolutions found matching your search.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Minutes Results -->
        <div class="tab-pane fade" id="minutes" role="tabpanel">
            <div class="mt-4">
                <?php if (!empty($results['minutes'])): ?>
                    <div class="row">
                        <?php foreach ($results['minutes'] as $minute): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <a href="<?= BASE_URL ?>minutes/view/<?= $minute['id'] ?>" class="text-decoration-none">
                                                <?= htmlspecialchars($minute['session_type']) ?>
                                            </a>
                                        </h6>
                                        <p class="card-text"><?= htmlspecialchars(substr($minute['summary'], 0, 100)) ?>...</p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($minute['meeting_date'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-journal-text display-4 text-muted"></i>
                        <p class="text-muted mt-2">No meeting minutes found matching your search.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Publications Results -->
        <div class="tab-pane fade" id="publications" role="tabpanel">
            <div class="mt-4">
                <?php if (!empty($results['publications'])): ?>
                    <div class="row">
                        <?php foreach ($results['publications'] as $publication): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning">
                                            <a href="<?= BASE_URL ?>publications/view/<?= $publication['id'] ?>" class="text-decoration-none">
                                                <?= htmlspecialchars($publication['title']) ?>
                                            </a>
                                        </h6>
                                        <span class="badge bg-secondary mb-2"><?= ucfirst(str_replace('_', ' ', $publication['category'])) ?></span>
                                        <p class="card-text"><?= htmlspecialchars(substr($publication['content'], 0, 100)) ?>...</p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($publication['date_posted'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-megaphone display-4 text-muted"></i>
                        <p class="text-muted mt-2">No publications found matching your search.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php 
    $total_results = count($results['ordinances'] ?? []) + count($results['resolutions'] ?? []) + count($results['minutes'] ?? []) + count($results['publications'] ?? []);
    ?>
    
    <?php if ($total_results === 0): ?>
        <div class="text-center py-5">
            <i class="bi bi-search display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">No results found</h4>
            <p class="text-muted">Try adjusting your search terms or browse by category.</p>
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="<?= BASE_URL ?>ordinances" class="btn btn-outline-primary w-100">
                                <i class="bi bi-file-text"></i><br>Ordinances
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?= BASE_URL ?>resolutions" class="btn btn-outline-success w-100">
                                <i class="bi bi-file-earmark-check"></i><br>Resolutions
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?= BASE_URL ?>minutes" class="btn btn-outline-info w-100">
                                <i class="bi bi-journal-text"></i><br>Minutes
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?= BASE_URL ?>publications" class="btn btn-outline-warning w-100">
                                <i class="bi bi-megaphone"></i><br>Publications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="text-center py-5">
        <i class="bi bi-search display-1 text-muted"></i>
        <h4 class="mt-3 text-muted">Enter a search term</h4>
        <p class="text-muted">Use the search box above to find ordinances, resolutions, meeting minutes, and publications.</p>
    </div>
<?php endif; ?>
