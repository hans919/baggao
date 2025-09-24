<?php
$current_admin_page = 'councilors';
$page_title = 'Councilor Details';
$page_description = 'View detailed councilor information';
$breadcrumbs = [
    ['title' => 'Councilors', 'url' => BASE_URL . 'admin/councilors'],
    ['title' => 'View Details', 'url' => '#']
];

// Start output buffering for content
ob_start();
?>

<style>
    /* Ensure pure white background */
    .main-content {
        background-color: #ffffff !important;
    }
    
    .page-content {
        background-color: #ffffff !important;
    }
    
    .content-container {
        background-color: #ffffff !important;
    }
    
    /* Ensure cards have white background */
    .card {
        background-color: #ffffff !important;
    }
    
    /* Light background areas should be very light gray instead of off-white */
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .bg-muted {
        background-color: #f8f9fa !important;
    }
    
    body, .wrapper, .main-wrapper {
        background-color: #ffffff !important;
    }
    
    /* Profile photo styling */
    .profile-photo {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Stats cards */
    .stat-card {
        transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    /* Timeline styling */
    .timeline-item {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0.25rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
    }
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-2 text-gradient">Councilor Profile</h1>
        <p class="text-muted mb-0">Detailed information for <?= htmlspecialchars($councilor['name']) ?></p>
        <div class="d-flex align-items-center gap-3 mt-2">
            <span class="badge bg-<?= $councilor['status'] === 'active' ? 'success' : 'secondary' ?> px-3 py-2">
                <i class="bi bi-<?= $councilor['status'] === 'active' ? 'check-circle' : 'dash-circle' ?> me-1"></i>
                <?= ucfirst($councilor['status']) ?>
            </span>
            <span class="text-muted">•</span>
            <small class="text-muted">Member since <?= $councilor['term_start'] ?></small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>councilors/view/<?= $councilor['id'] ?>" target="_blank" class="btn btn-outline-secondary">
            <i class="bi bi-eye me-1"></i>
            Public View
        </a>
        <a href="<?= BASE_URL ?>admin/edit_councilor/<?= $councilor['id'] ?>" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>
            Edit Profile
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column - Profile Information -->
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center p-4">
                <div class="mb-4">
                    <?php if (!empty($councilor['photo'])): ?>
                        <img src="<?= BASE_URL . UPLOAD_PATH . $councilor['photo'] ?>" 
                             alt="<?= htmlspecialchars($councilor['name']) ?>" 
                             class="profile-photo rounded-circle">
                    <?php else: ?>
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center profile-photo">
                            <i class="bi bi-person display-1 text-secondary"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h4 class="fw-bold mb-2"><?= htmlspecialchars($councilor['name']) ?></h4>
                <p class="text-primary fw-semibold mb-3"><?= htmlspecialchars($councilor['position']) ?></p>
                
                <?php if (!empty($councilor['district'])): ?>
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="bi bi-geo-alt text-muted me-2"></i>
                        <span class="text-muted"><?= htmlspecialchars($councilor['district']) ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($councilor['email'])): ?>
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-envelope text-muted me-2"></i>
                        <a href="mailto:<?= htmlspecialchars($councilor['email']) ?>" class="text-decoration-none">
                            <?= htmlspecialchars($councilor['email']) ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <!-- Social Media Links -->
                <?php if (!empty($councilor['social_facebook']) || !empty($councilor['social_twitter'])): ?>
                    <div class="d-flex gap-2 justify-content-center mt-3">
                        <?php if (!empty($councilor['social_facebook'])): ?>
                            <a href="<?= htmlspecialchars($councilor['social_facebook']) ?>" target="_blank" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($councilor['social_twitter'])): ?>
                            <a href="<?= htmlspecialchars($councilor['social_twitter']) ?>" target="_blank" 
                               class="btn btn-outline-info btn-sm">
                                <i class="bi bi-twitter"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <h6 class="fw-bold mb-0">Legislative Activity</h6>
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card bg-primary bg-opacity-10 rounded-3 p-3 text-center">
                            <div class="fw-bold text-primary mb-1" style="font-size: 1.5rem;">
                                <?= $councilor['ordinance_count'] ?? 0 ?>
                            </div>
                            <small class="text-muted fw-medium">Ordinances</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card bg-success bg-opacity-10 rounded-3 p-3 text-center">
                            <div class="fw-bold text-success mb-1" style="font-size: 1.5rem;">
                                <?= $councilor['resolution_count'] ?? 0 ?>
                            </div>
                            <small class="text-muted fw-medium">Resolutions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Detailed Information -->
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-person-badge text-primary me-2"></i>
                    Basic Information
                </h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Position</label>
                        <div><?= htmlspecialchars($councilor['position']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Status</label>
                        <div>
                            <span class="badge bg-<?= $councilor['status'] === 'active' ? 'success' : 'secondary' ?> px-2 py-1">
                                <?= ucfirst($councilor['status']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Term Start</label>
                        <div><?= $councilor['term_start'] ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">Term End</label>
                        <div><?= $councilor['term_end'] ?></div>
                    </div>
                    <?php if (!empty($councilor['district'])): ?>
                    <div class="col-md-6">
                        <label class="fw-semibold text-muted small">District/Ward</label>
                        <div><?= htmlspecialchars($councilor['district']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Biography -->
        <?php if (!empty($councilor['bio'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-file-person text-info me-2"></i>
                    Biography
                </h6>
            </div>
            <div class="card-body pt-0">
                <p class="mb-0 lh-lg"><?= nl2br(htmlspecialchars($councilor['bio'])) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Committees -->
        <?php if (!empty($councilor['committees'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-people-fill text-warning me-2"></i>
                    Committee Memberships
                </h6>
            </div>
            <div class="card-body pt-0">
                <?php 
                $committees = array_map('trim', explode(',', $councilor['committees']));
                foreach ($committees as $committee): 
                    if (!empty($committee)):
                ?>
                    <span class="badge bg-warning bg-opacity-10 text-warning me-2 mb-2 px-3 py-2">
                        <?= htmlspecialchars($committee) ?>
                    </span>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Education -->
        <?php if (!empty($councilor['education'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-mortarboard text-secondary me-2"></i>
                    Educational Background
                </h6>
            </div>
            <div class="card-body pt-0">
                <p class="mb-0 lh-lg"><?= nl2br(htmlspecialchars($councilor['education'])) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Achievements -->
        <?php if (!empty($councilor['achievements'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-award text-success me-2"></i>
                    Achievements & Awards
                </h6>
            </div>
            <div class="card-body pt-0">
                <p class="mb-0 lh-lg"><?= nl2br(htmlspecialchars($councilor['achievements'])) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Contact Information -->
        <?php if (!empty($councilor['contact_info'])): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-telephone text-info me-2"></i>
                    Contact Information
                </h6>
            </div>
            <div class="card-body pt-0">
                <p class="mb-0 lh-lg"><?= nl2br(htmlspecialchars($councilor['contact_info'])) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Recent Activity -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-clock-history text-primary me-2"></i>
                    Recent Legislative Activity
                </h6>
            </div>
            <div class="card-body pt-0">
                <?php if (!empty($recent_ordinances) || !empty($recent_resolutions)): ?>
                    <div class="timeline">
                        <?php if (!empty($recent_ordinances)): ?>
                            <?php foreach (array_slice($recent_ordinances, 0, 3) as $ordinance): ?>
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">
                                                <a href="<?= BASE_URL ?>admin/edit_ordinance/<?= $ordinance['id'] ?>" 
                                                   class="text-decoration-none">
                                                    <?= htmlspecialchars($ordinance['title']) ?>
                                                </a>
                                            </h6>
                                            <p class="text-muted mb-1 small">Ordinance No. <?= htmlspecialchars($ordinance['ordinance_number']) ?></p>
                                            <small class="text-muted"><?= date('M j, Y', strtotime($ordinance['date_passed'])) ?></small>
                                        </div>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">Ordinance</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($recent_resolutions)): ?>
                            <?php foreach (array_slice($recent_resolutions, 0, 3) as $resolution): ?>
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">
                                                <a href="<?= BASE_URL ?>admin/edit_resolution/<?= $resolution['id'] ?>" 
                                                   class="text-decoration-none">
                                                    <?= htmlspecialchars($resolution['subject']) ?>
                                                </a>
                                            </h6>
                                            <p class="text-muted mb-1 small">Resolution No. <?= htmlspecialchars($resolution['resolution_number']) ?></p>
                                            <small class="text-muted"><?= date('M j, Y', strtotime($resolution['date_approved'])) ?></small>
                                        </div>
                                        <span class="badge bg-success bg-opacity-10 text-success">Resolution</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="<?= BASE_URL ?>admin/ordinances?author=<?= $councilor['id'] ?>" class="btn btn-outline-primary btn-sm me-2">
                            <i class="bi bi-file-text me-1"></i>View All Ordinances
                        </a>
                        <a href="<?= BASE_URL ?>admin/resolutions?author=<?= $councilor['id'] ?>" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-file-earmark-check me-1"></i>View All Resolutions
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-file-text display-4 text-muted opacity-50"></i>
                        <p class="text-muted mt-2 mb-0">No recent legislative activity</p>
                        <small class="text-muted">Documents authored by this councilor will appear here</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
    <a href="<?= BASE_URL ?>admin/councilors" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Councilors
    </a>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>admin/edit_councilor/<?= $councilor['id'] ?>" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit Profile
        </a>
        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
            <i class="bi bi-trash me-2"></i>Delete Councilor
        </button>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-danger">Delete Councilor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle display-4 text-danger"></i>
                </div>
                <p class="text-center mb-0">Are you sure you want to delete <strong><?= htmlspecialchars($councilor['name']) ?></strong>?</p>
                <p class="text-center text-muted small">This action cannot be undone. All associated data will be permanently removed.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= BASE_URL ?>admin/delete_councilor/<?= $councilor['id'] ?>" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>Delete Permanently
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Show success/error messages
<?php if (isset($_SESSION['success'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('success', '<?= $_SESSION['success'] ?>');
    });
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('danger', '<?= $_SESSION['error'] ?>');
    });
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>

<?php
$content = ob_get_clean();

// Include the admin layout
include __DIR__ . '/layout.php';
?>