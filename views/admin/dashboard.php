<?php
$current_admin_page = 'dashboard';
$page_title = 'Dashboard';
$page_description = 'Overview of your legislative system';
$breadcrumbs = [];

// Start output buffering for content
ob_start();
?>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-file-text text-primary fs-3"></i>
                </div>
                <h3 class="fw-bold text-primary mb-2"><?= $stats['total_ordinances'] ?></h3>
                <p class="text-muted mb-3">Total Ordinances</p>
                <a href="<?= BASE_URL ?>admin/ordinances" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Manage
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow">
            <div class="card-body text-center p-4">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-file-earmark-check text-success fs-3"></i>
                </div>
                <h3 class="fw-bold text-success mb-2"><?= $stats['total_resolutions'] ?></h3>
                <p class="text-muted mb-3">Total Resolutions</p>
                <a href="<?= BASE_URL ?>admin/resolutions" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Manage
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow">
            <div class="card-body text-center p-4">
                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-journal-text text-info fs-3"></i>
                </div>
                <h3 class="fw-bold text-info mb-2"><?= $stats['total_minutes'] ?></h3>
                <p class="text-muted mb-3">Meeting Minutes</p>
                <a href="<?= BASE_URL ?>admin/minutes" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Manage
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow">
            <div class="card-body text-center p-4">
                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-megaphone text-warning fs-3"></i>
                </div>
                <h3 class="fw-bold text-warning mb-2"><?= $stats['total_publications'] ?></h3>
                <p class="text-muted mb-3">Publications</p>
                <a href="<?= BASE_URL ?>admin/publications" class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Manage
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-lightning-fill me-2 text-primary"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="<?= BASE_URL ?>admin/add_ordinance" class="btn btn-outline-primary d-flex align-items-center justify-content-start p-3">
                        <i class="bi bi-plus-circle me-3"></i>
                        <div class="text-start">
                            <div class="fw-semibold">Add New Ordinance</div>
                            <small class="text-muted">Create a new municipal ordinance</small>
                        </div>
                    </a>
                    
                    <a href="<?= BASE_URL ?>admin/add_resolution" class="btn btn-outline-success d-flex align-items-center justify-content-start p-3">
                        <i class="bi bi-plus-circle me-3"></i>
                        <div class="text-start">
                            <div class="fw-semibold">Add New Resolution</div>
                            <small class="text-muted">Create a new resolution</small>
                        </div>
                    </a>
                    
                    <a href="<?= BASE_URL ?>admin/add_minute" class="btn btn-outline-info d-flex align-items-center justify-content-start p-3">
                        <i class="bi bi-plus-circle me-3"></i>
                        <div class="text-start">
                            <div class="fw-semibold">Add Meeting Minutes</div>
                            <small class="text-muted">Record new meeting minutes</small>
                        </div>
                    </a>
                    
                    <a href="<?= BASE_URL ?>admin/reports" class="btn btn-outline-secondary d-flex align-items-center justify-content-start p-3">
                        <i class="bi bi-bar-chart me-3"></i>
                        <div class="text-start">
                            <div class="fw-semibold">View Reports</div>
                            <small class="text-muted">Generate system reports</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                        <i class="bi bi-clock-history me-2 text-info"></i>Recent Activity
                    </h5>
                    <a href="<?= BASE_URL ?>admin/activity" class="btn btn-outline-secondary btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_activity)): ?>
                    <div class="timeline">
                        <?php foreach (array_slice($recent_activity, 0, 5) as $activity): ?>
                            <div class="timeline-item d-flex align-items-start mb-3">
                                <div class="timeline-marker bg-<?= $activity['type'] === 'ordinance' ? 'primary' : ($activity['type'] === 'resolution' ? 'success' : 'info') ?> rounded-circle p-2 me-3">
                                    <i class="bi bi-<?= $activity['type'] === 'ordinance' ? 'file-text' : ($activity['type'] === 'resolution' ? 'file-earmark-check' : 'journal-text') ?> text-white"></i>
                                </div>
                                <div class="timeline-content flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($activity['title']) ?></h6>
                                            <p class="text-muted mb-1" style="font-size: 0.9rem;"><?= htmlspecialchars($activity['description']) ?></p>
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i><?= htmlspecialchars($activity['user_name']) ?> • 
                                                <i class="bi bi-clock me-1"></i><?= date('M j, Y g:i A', strtotime($activity['created_at'])) ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-<?= $activity['type'] === 'ordinance' ? 'primary' : ($activity['type'] === 'resolution' ? 'success' : 'info') ?> ms-2">
                                            <?= ucfirst($activity['type']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-clock-history display-4 text-muted opacity-50"></i>
                        <h6 class="mt-3 text-muted">No recent activity</h6>
                        <p class="text-muted mb-0">Start by creating your first document.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Overview -->
<div class="row g-4 mt-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-graph-up me-2 text-success"></i>Monthly Overview
                </h5>
            </div>
            <div class="card-body">
                <!-- This would contain a chart in a real implementation -->
                <div class="row text-center">
                    <div class="col-3">
                        <div class="p-3">
                            <h4 class="text-primary fw-bold"><?= isset($stats['this_month_ordinances']) ? $stats['this_month_ordinances'] : '0' ?></h4>
                            <small class="text-muted">Ordinances<br>This Month</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-3">
                            <h4 class="text-success fw-bold"><?= isset($stats['this_month_resolutions']) ? $stats['this_month_resolutions'] : '0' ?></h4>
                            <small class="text-muted">Resolutions<br>This Month</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-3">
                            <h4 class="text-info fw-bold"><?= isset($stats['this_month_minutes']) ? $stats['this_month_minutes'] : '0' ?></h4>
                            <small class="text-muted">Minutes<br>This Month</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-3">
                            <h4 class="text-warning fw-bold"><?= isset($stats['this_month_publications']) ? $stats['this_month_publications'] : '0' ?></h4>
                            <small class="text-muted">Publications<br>This Month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-info-circle me-2 text-secondary"></i>System Information
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Storage Used</span>
                    <span class="fw-semibold">2.4 GB / 10 GB</span>
                </div>
                <div class="progress mb-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: 24%"></div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Last Backup</span>
                    <span class="fw-semibold"><?= date('M j, Y') ?></span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">System Status</span>
                    <span class="badge bg-success">Online</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Version</span>
                    <span class="fw-semibold">2.0.0</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
            

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
