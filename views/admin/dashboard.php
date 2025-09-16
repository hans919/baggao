<?php
$current_admin_page = 'dashboard';
$page_title = 'Dashboard';
$page_description = 'Overview of your legislative system';
$breadcrumbs = [];

// Start output buffering for content
ob_start();
?>

<!-- Dashboard Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gradient">Dashboard Overview</h1>
        <p class="text-muted mb-0">Welcome back! Here's what's happening with your legislative system.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary" onclick="refreshDashboard()">
            <i class="bi bi-arrow-clockwise me-1"></i>
            Refresh
        </button>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-plus-lg me-1"></i>
                Quick Add
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/add_ordinance">
                    <i class="bi bi-file-text me-2"></i>New Ordinance
                </a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/add_resolution">
                    <i class="bi bi-file-earmark-check me-2"></i>New Resolution
                </a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/add_minute">
                    <i class="bi bi-journal-text me-2"></i>Meeting Minutes
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/add_publication">
                    <i class="bi bi-megaphone me-2"></i>New Publication
                </a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow position-relative overflow-hidden">
            <div class="card-body text-center p-4">
                <div class="position-absolute top-0 end-0 p-2">
                    <div class="badge bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </div>
                <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="bi bi-file-text text-primary" style="font-size: 1.75rem;"></i>
                </div>
                <h2 class="fw-bold text-primary mb-2" style="font-size: 2rem;"><?= $stats['total_ordinances'] ?></h2>
                <p class="text-muted mb-3 fw-medium">Total Ordinances</p>
                <a href="<?= BASE_URL ?>admin/ordinances" class="btn btn-outline-primary btn-sm px-3">
                    <i class="bi bi-arrow-right me-1"></i>Manage All
                </a>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, hsl(var(--primary)) 0%, hsl(var(--primary) / 0.7) 100%);"></div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow position-relative overflow-hidden">
            <div class="card-body text-center p-4">
                <div class="position-absolute top-0 end-0 p-2">
                    <div class="badge bg-success bg-opacity-10 text-success">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </div>
                <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="bi bi-file-earmark-check text-success" style="font-size: 1.75rem;"></i>
                </div>
                <h2 class="fw-bold text-success mb-2" style="font-size: 2rem;"><?= $stats['total_resolutions'] ?></h2>
                <p class="text-muted mb-3 fw-medium">Total Resolutions</p>
                <a href="<?= BASE_URL ?>admin/resolutions" class="btn btn-outline-success btn-sm px-3">
                    <i class="bi bi-arrow-right me-1"></i>Manage All
                </a>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, hsl(142.1 76.2% 36.3%) 0%, hsl(142.1 76.2% 36.3% / 0.7) 100%);"></div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow position-relative overflow-hidden">
            <div class="card-body text-center p-4">
                <div class="position-absolute top-0 end-0 p-2">
                    <div class="badge bg-info bg-opacity-10 text-info">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </div>
                <div class="bg-info bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="bi bi-journal-text text-info" style="font-size: 1.75rem;"></i>
                </div>
                <h2 class="fw-bold text-info mb-2" style="font-size: 2rem;"><?= $stats['total_minutes'] ?></h2>
                <p class="text-muted mb-3 fw-medium">Meeting Minutes</p>
                <a href="<?= BASE_URL ?>admin/minutes" class="btn btn-outline-info btn-sm px-3">
                    <i class="bi bi-arrow-right me-1"></i>Manage All
                </a>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, hsl(204 100% 40%) 0%, hsl(204 100% 40% / 0.7) 100%);"></div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm hover-shadow position-relative overflow-hidden">
            <div class="card-body text-center p-4">
                <div class="position-absolute top-0 end-0 p-2">
                    <div class="badge bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px;">
                    <i class="bi bi-megaphone text-warning" style="font-size: 1.75rem;"></i>
                </div>
                <h2 class="fw-bold text-warning mb-2" style="font-size: 2rem;"><?= $stats['total_publications'] ?></h2>
                <p class="text-muted mb-3 fw-medium">Publications</p>
                <a href="<?= BASE_URL ?>admin/publications" class="btn btn-outline-warning btn-sm px-3">
                    <i class="bi bi-arrow-right me-1"></i>Manage All
                </a>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, hsl(48 96% 53%) 0%, hsl(48 96% 53% / 0.7) 100%);"></div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-3 pt-4">
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-lightning-fill text-primary"></i>
                    </div>
                    Quick Actions
                </h5>
                <p class="text-muted mb-0 mt-2">Create new documents quickly</p>
            </div>
            <div class="card-body pt-0">
                <div class="d-grid gap-3">
                    <a href="<?= BASE_URL ?>admin/add_ordinance" class="btn btn-outline-primary d-flex align-items-center justify-content-start p-3 text-start border-2 hover-shadow">
                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-file-text text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">Add New Ordinance</div>
                            <small class="text-muted">Create a new municipal ordinance</small>
                        </div>
                        <i class="bi bi-arrow-right text-muted"></i>
                    </a>
                    
                    <a href="<?= BASE_URL ?>admin/add_resolution" class="btn btn-outline-success d-flex align-items-center justify-content-start p-3 text-start border-2 hover-shadow">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-file-earmark-check text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">Add New Resolution</div>
                            <small class="text-muted">Create a new resolution</small>
                        </div>
                        <i class="bi bi-arrow-right text-muted"></i>
                    </a>
                    
                    <a href="<?= BASE_URL ?>admin/add_minute" class="btn btn-outline-info d-flex align-items-center justify-content-start p-3 text-start border-2 hover-shadow">
                        <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-journal-text text-info"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">Add Meeting Minutes</div>
                            <small class="text-muted">Record new meeting minutes</small>
                        </div>
                        <i class="bi bi-arrow-right text-muted"></i>
                    </a>
                    
                    <a href="<?= BASE_URL ?>admin/reports" class="btn btn-outline-secondary d-flex align-items-center justify-content-start p-3 text-start border-2 hover-shadow">
                        <div class="bg-secondary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-bar-chart text-secondary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">View Reports</div>
                            <small class="text-muted">Generate system reports</small>
                        </div>
                        <i class="bi bi-arrow-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-3 pt-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="bi bi-clock-history text-info"></i>
                            </div>
                            Recent Activity
                        </h5>
                        <p class="text-muted mb-0 mt-2">Latest updates and changes</p>
                    </div>
                    <a href="<?= BASE_URL ?>admin/activity" class="btn btn-outline-secondary btn-sm px-3">
                        <i class="bi bi-list me-1"></i>View All
                    </a>
                </div>
            </div>
            <div class="card-body pt-0">
                <?php if (!empty($recent_activity)): ?>
                    <div class="timeline position-relative">
                        <?php foreach (array_slice($recent_activity, 0, 5) as $index => $activity): ?>
                            <div class="timeline-item d-flex align-items-start mb-4 position-relative">
                                <?php if ($index < 4): ?>
                                    <div class="position-absolute top-0 start-0 ms-3 mt-4" style="width: 2px; height: calc(100% + 1rem); background: linear-gradient(180deg, hsl(var(--border)) 0%, transparent 100%);"></div>
                                <?php endif; ?>
                                
                                <div class="timeline-marker bg-<?= $activity['type'] === 'ordinance' ? 'primary' : ($activity['type'] === 'resolution' ? 'success' : 'info') ?> rounded-3 p-2 me-3 position-relative" style="z-index: 1;">
                                    <i class="bi bi-<?= $activity['type'] === 'ordinance' ? 'file-text' : ($activity['type'] === 'resolution' ? 'file-earmark-check' : 'journal-text') ?> text-white"></i>
                                </div>
                                <div class="timeline-content flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1 me-3">
                                            <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($activity['title']) ?></h6>
                                            <p class="text-muted mb-2" style="font-size: 0.9rem;"><?= htmlspecialchars($activity['description']) ?></p>
                                            <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 0.8rem;">
                                                <span>
                                                    <i class="bi bi-person me-1"></i><?= htmlspecialchars($activity['user_name']) ?>
                                                </span>
                                                <span>
                                                    <i class="bi bi-clock me-1"></i><?= date('M j, Y g:i A', strtotime($activity['created_at'])) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="badge bg-<?= $activity['type'] === 'ordinance' ? 'primary' : ($activity['type'] === 'resolution' ? 'success' : 'info') ?> bg-opacity-10 text-<?= $activity['type'] === 'ordinance' ? 'primary' : ($activity['type'] === 'resolution' ? 'success' : 'info') ?> px-2 py-1">
                                            <?= ucfirst($activity['type']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="bg-muted bg-opacity-50 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-clock-history text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <h6 class="mt-3 text-muted fw-semibold">No recent activity</h6>
                        <p class="text-muted mb-3">Start by creating your first document to see activity here.</p>
                        <a href="<?= BASE_URL ?>admin/add_ordinance" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i>Create Document
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Overview & Analytics -->
<div class="row g-4 mt-2">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-3 pt-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="bi bi-graph-up text-success"></i>
                            </div>
                            Monthly Overview
                        </h5>
                        <p class="text-muted mb-0 mt-2">Document creation statistics for this month</p>
                    </div>
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option value="current">Current Month</option>
                        <option value="last">Last Month</option>
                        <option value="quarter">This Quarter</option>
                    </select>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row g-4">
                    <div class="col-sm-3">
                        <div class="text-center p-3 rounded-3 bg-primary bg-opacity-5 border border-primary border-opacity-20">
                            <div class="bg-primary bg-opacity-10 rounded-2 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                <i class="bi bi-file-text text-primary"></i>
                            </div>
                            <h3 class="text-primary fw-bold mb-1"><?= isset($stats['this_month_ordinances']) ? $stats['this_month_ordinances'] : '0' ?></h3>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Ordinances<br>This Month</p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-center p-3 rounded-3 bg-success bg-opacity-5 border border-success border-opacity-20">
                            <div class="bg-success bg-opacity-10 rounded-2 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                <i class="bi bi-file-earmark-check text-success"></i>
                            </div>
                            <h3 class="text-success fw-bold mb-1"><?= isset($stats['this_month_resolutions']) ? $stats['this_month_resolutions'] : '0' ?></h3>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Resolutions<br>This Month</p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-center p-3 rounded-3 bg-info bg-opacity-5 border border-info border-opacity-20">
                            <div class="bg-info bg-opacity-10 rounded-2 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                <i class="bi bi-journal-text text-info"></i>
                            </div>
                            <h3 class="text-info fw-bold mb-1"><?= isset($stats['this_month_minutes']) ? $stats['this_month_minutes'] : '0' ?></h3>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Minutes<br>This Month</p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="text-center p-3 rounded-3 bg-warning bg-opacity-5 border border-warning border-opacity-20">
                            <div class="bg-warning bg-opacity-10 rounded-2 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
                                <i class="bi bi-megaphone text-warning"></i>
                            </div>
                            <h3 class="text-warning fw-bold mb-1"><?= isset($stats['this_month_publications']) ? $stats['this_month_publications'] : '0' ?></h3>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Publications<br>This Month</p>
                        </div>
                    </div>
                </div>
                
                <!-- Chart placeholder -->
                <div class="mt-4 p-4 bg-light bg-opacity-50 rounded-3 text-center">
                    <i class="bi bi-bar-chart display-4 text-muted opacity-50"></i>
                    <p class="text-muted mt-2 mb-0">Chart visualization would be displayed here</p>
                    <small class="text-muted">Integration with Chart.js or similar library</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Information -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-3 pt-4">
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 rounded-2 p-2 me-3">
                        <i class="bi bi-info-circle text-secondary"></i>
                    </div>
                    System Information
                </h5>
                <p class="text-muted mb-0 mt-2">Current system status and metrics</p>
            </div>
            <div class="card-body pt-0">
                <!-- Storage Usage -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted fw-medium">Storage Used</span>
                        <span class="fw-semibold">2.4 GB / 10 GB</span>
                    </div>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 24%"></div>
                    </div>
                    <small class="text-muted">24% of total storage capacity</small>
                </div>
                
                <!-- System Stats -->
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light bg-opacity-50 rounded-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-calendar-check text-success"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium">Last Backup</span>
                            <div class="fw-semibold"><?= date('M j, Y') ?></div>
                        </div>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i>Success
                    </span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light bg-opacity-50 rounded-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-shield-check text-success"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium">System Status</span>
                            <div class="fw-semibold">Online & Healthy</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Online</span>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light bg-opacity-50 rounded-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                            <i class="bi bi-code-slash text-primary"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium">System Version</span>
                            <div class="fw-semibold">v2.0.0</div>
                        </div>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">Latest</span>
                </div>
                
                <!-- Quick System Actions -->
                <div class="mt-4">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary btn-sm" onclick="performBackup()">
                            <i class="bi bi-download me-1"></i>Create Backup
                        </button>
                        <button class="btn btn-outline-primary btn-sm" onclick="clearCache()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Clear Cache
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

// Add custom JavaScript for dashboard functionality
$additional_js = "
<script>
    // Dashboard specific functionality
    function refreshDashboard() {
        const btn = event.target.closest('button');
        const icon = btn.querySelector('i');
        const originalClass = icon.className;
        
        // Add loading state
        icon.className = 'bi bi-arrow-clockwise me-1';
        icon.style.animation = 'spin 1s linear infinite';
        btn.disabled = true;
        
        // Simulate refresh (replace with actual refresh logic)
        setTimeout(() => {
            icon.style.animation = '';
            icon.className = originalClass;
            btn.disabled = false;
            
            // Show success message
            showToast('Dashboard refreshed successfully!', 'success');
        }, 1500);
    }
    
    function performBackup() {
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class=\"bi bi-arrow-clockwise me-1\"></i>Creating...';
        btn.disabled = true;
        
        // Simulate backup process
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            showToast('Backup created successfully!', 'success');
        }, 2000);
    }
    
    function clearCache() {
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class=\"bi bi-arrow-clockwise me-1\"></i>Clearing...';
        btn.disabled = true;
        
        // Simulate cache clearing
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            showToast('Cache cleared successfully!', 'success');
        }, 1000);
    }
    
    function showToast(message, type = 'info') {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = `alert alert-\${type} position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <i class=\"bi bi-check-circle-fill me-2\"></i>
            \${message}
            <button type=\"button\" class=\"btn-close ms-2\" onclick=\"this.parentElement.remove()\"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 3000);
    }
    
    // Add hover effects to stat cards
    document.addEventListener('DOMContentLoaded', function() {
        const statCards = document.querySelectorAll('.hover-shadow');
        
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
";

include __DIR__ . '/layout.php';
?>
