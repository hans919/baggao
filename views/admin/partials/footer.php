<footer class="admin-footer bg-white border-top border-light mt-auto py-3">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center text-muted">
                    <small>
                        © <?= date('Y') ?> <strong>Baggao Legislative Information System</strong>. 
                        <span class="d-none d-sm-inline">All rights reserved.</span>
                    </small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-md-end gap-4">
                    <!-- System Status -->
                    <div class="d-flex align-items-center text-muted">
                        <div class="status-indicator bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                        <small>System Status: <span class="text-success fw-semibold">Online</span></small>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="d-none d-lg-flex align-items-center gap-3 text-muted">
                        <?php if (isset($stats)): ?>
                            <small>
                                <i class="bi bi-file-text me-1"></i>
                                <?= isset($stats['total_ordinances']) ? $stats['total_ordinances'] : '0' ?> Ordinances
                            </small>
                            <small>
                                <i class="bi bi-file-earmark-check me-1"></i>
                                <?= isset($stats['total_resolutions']) ? $stats['total_resolutions'] : '0' ?> Resolutions
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Footer Links -->
                    <div class="d-flex align-items-center gap-3">
                        <a href="<?= BASE_URL ?>admin/help" class="text-muted text-decoration-none" title="Help & Documentation">
                            <i class="bi bi-question-circle"></i>
                            <span class="d-none d-lg-inline ms-1">Help</span>
                        </a>
                        <a href="<?= BASE_URL ?>admin/support" class="text-muted text-decoration-none" title="Support">
                            <i class="bi bi-headset"></i>
                            <span class="d-none d-lg-inline ms-1">Support</span>
                        </a>
                        <a href="<?= BASE_URL ?>" target="_blank" class="text-muted text-decoration-none" title="View Public Site">
                            <i class="bi bi-globe"></i>
                            <span class="d-none d-lg-inline ms-1">Public Site</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Footer Info (Desktop Only) -->
        <div class="row mt-2 d-none d-lg-flex">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="bi bi-server me-1"></i>
                    Server Time: <?= date('M j, Y g:i A T') ?>
                </small>
            </div>
            <div class="col-md-6 text-end">
                <small class="text-muted">
                    Version 2.0.0 | 
                    <a href="<?= BASE_URL ?>admin/changelog" class="text-muted text-decoration-none">What's New</a> | 
                    <a href="<?= BASE_URL ?>admin/privacy" class="text-muted text-decoration-none">Privacy Policy</a>
                </small>
            </div>
        </div>
    </div>
</footer>

<style>
.admin-footer {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.status-indicator {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.admin-footer a:hover {
    color: var(--bs-primary) !important;
    transition: color 0.2s ease;
}

.admin-footer small {
    font-size: 0.8rem;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .admin-footer .row > .col-md-6:last-child {
        margin-top: 0.5rem;
    }
    
    .admin-footer .d-flex.gap-4 {
        gap: 1rem !important;
    }
    
    .admin-footer .d-flex.gap-3 {
        gap: 0.75rem !important;
    }
}
</style>
