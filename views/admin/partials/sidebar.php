<?php
// Get current page for active navigation
$current_page = isset($current_admin_page) ? $current_admin_page : '';
$request_uri = $_SERVER['REQUEST_URI'];
?>

<!-- Sidebar Overlay (Mobile) -->
<div class="sidebar-overlay position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-lg-none" 
     style="z-index: 1040; display: none;" onclick="toggleSidebar()"></div>

<!-- Main Sidebar -->
<nav class="admin-sidebar position-fixed top-0 start-0 h-100 d-flex flex-column" id="adminSidebar" style="z-index: 1045;">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="brand-section d-flex align-items-center">
                <div class="brand-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="brand-text ms-3">
                    <h6 class="brand-title mb-0">Legislative</h6>
                    <small class="brand-subtitle">Admin Panel</small>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button class="btn btn-ghost d-lg-none p-2" onclick="toggleSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="sidebar-menu flex-grow-1">
        <!-- Dashboard Section -->
        <div class="menu-section">
            <div class="menu-header">
                <span class="menu-title">Overview</span>
            </div>
            <div class="menu-items">
                <a href="<?= BASE_URL ?>admin" 
                   class="menu-item <?= ($current_page === 'dashboard' || strpos($request_uri, '/admin') !== false && strpos($request_uri, '/admin/') === false) ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-grid-1x2"></i>
                    </div>
                    <span class="menu-text">Dashboard</span>
                    <?php if (isset($stats['total_records'])): ?>
                        <span class="menu-badge"><?= $stats['total_records'] ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>

        <!-- Data Management Section -->
        <div class="menu-section">
            <div class="menu-header">
                <span class="menu-title">Data Management</span>
            </div>
            <div class="menu-items">
                <a href="<?= BASE_URL ?>admin/ordinances" 
                   class="menu-item <?= $current_page === 'ordinances' || strpos($request_uri, '/ordinances') !== false ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <span class="menu-text">Ordinances</span>
                    <span class="menu-badge"><?= isset($stats['total_ordinances']) ? $stats['total_ordinances'] : '0' ?></span>
                </a>

                <a href="<?= BASE_URL ?>admin/resolutions" 
                   class="menu-item <?= $current_page === 'resolutions' || strpos($request_uri, '/resolutions') !== false ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <span class="menu-text">Resolutions</span>
                    <span class="menu-badge"><?= isset($stats['total_resolutions']) ? $stats['total_resolutions'] : '0' ?></span>
                </a>

                <a href="<?= BASE_URL ?>admin/minutes" 
                   class="menu-item <?= $current_page === 'minutes' || strpos($request_uri, '/minutes') !== false ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <span class="menu-text">Meeting Minutes</span>
                    <span class="menu-badge"><?= isset($stats['total_minutes']) ? $stats['total_minutes'] : '0' ?></span>
                </a>

                <a href="<?= BASE_URL ?>admin/publications" 
                   class="menu-item <?= $current_page === 'publications' || strpos($request_uri, '/publications') !== false ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-megaphone"></i>
                    </div>
                    <span class="menu-text">Publications</span>
                    <span class="menu-badge"><?= isset($stats['total_publications']) ? $stats['total_publications'] : '0' ?></span>
                </a>

                <a href="<?= BASE_URL ?>admin/councilors" 
                   class="menu-item <?= $current_page === 'councilors' || strpos($request_uri, '/councilors') !== false ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <span class="menu-text">Councilors</span>
                    <span class="menu-badge"><?= isset($stats['total_councilors']) ? $stats['total_councilors'] : '0' ?></span>
                </a>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="menu-section">
            <div class="menu-header">
                <span class="menu-title">Analytics</span>
            </div>
            <div class="menu-items">
                <a href="<?= BASE_URL ?>admin/reports" 
                   class="menu-item <?= $current_page === 'reports' ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <span class="menu-text">Reports</span>
                </a>

                <a href="<?= BASE_URL ?>admin/analytics" 
                   class="menu-item <?= $current_page === 'analytics' ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <span class="menu-text">Analytics</span>
                </a>
            </div>
        </div>

        <!-- System Section -->
        <div class="menu-section">
            <div class="menu-header">
                <span class="menu-title">System</span>
            </div>
            <div class="menu-items">
                <a href="<?= BASE_URL ?>admin/users" 
                   class="menu-item <?= $current_page === 'users' ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <span class="menu-text">Users</span>
                </a>

                <a href="<?= BASE_URL ?>admin/settings" 
                   class="menu-item <?= $current_page === 'settings' ? 'active' : '' ?>">
                    <div class="menu-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <span class="menu-text">Settings</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <!-- User Profile -->
        <div class="user-profile">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode(isset($current_user['full_name']) ? $current_user['full_name'] : 'Admin User') ?>&background=4f46e5&color=fff&size=40" 
                     alt="User Avatar" class="rounded-circle">
            </div>
            <div class="user-info">
                <div class="user-name"><?= isset($current_user['full_name']) ? htmlspecialchars($current_user['full_name']) : 'Admin User' ?></div>
                <div class="user-role">Administrator</div>
            </div>
            <div class="user-actions">
                <div class="dropdown">
                    <button class="btn btn-ghost" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/profile">
                            <i class="bi bi-person me-2"></i>Profile
                        </a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/preferences">
                            <i class="bi bi-gear me-2"></i>Preferences
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- External Links -->
        <div class="external-links">
            <a href="<?= BASE_URL ?>" target="_blank" class="external-link">
                <i class="bi bi-globe me-2"></i>
                <span>Public Site</span>
                <i class="bi bi-arrow-up-right ms-auto"></i>
            </a>
        </div>
    </div>
</nav>

<style>
/* Modern Sidebar Styles */
.admin-sidebar {
    width: 280px;
    background: #ffffff;
    border-right: 1px solid #e5e7eb;
    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Sidebar Header */
.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f8fafc;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.brand-title {
    color: #111827;
    font-weight: 700;
    font-size: 1.125rem;
    line-height: 1.2;
}

.brand-subtitle {
    color: #6b7280;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Menu Sections */
.sidebar-menu {
    padding: 1rem 0;
    overflow-y: auto;
}

.menu-section {
    margin-bottom: 2rem;
}

.menu-header {
    padding: 0 1.5rem 0.75rem;
}

.menu-title {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6b7280;
}

.menu-items {
    padding: 0 0.75rem;
}

/* Menu Items */
.menu-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    margin-bottom: 0.25rem;
    color: #374151;
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    position: relative;
}

.menu-item:hover {
    background: #f3f4f6;
    color: #111827;
    text-decoration: none;
    transform: translateX(4px);
}

.menu-item.active {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.menu-item.active:hover {
    background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
    transform: translateX(6px);
}

.menu-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    font-size: 1rem;
}

.menu-text {
    flex: 1;
    font-size: 0.875rem;
    font-weight: 500;
}

.menu-badge {
    background: #e5e7eb;
    color: #6b7280;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 1rem;
    min-width: 1.5rem;
    text-align: center;
}

.menu-item.active .menu-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Sidebar Footer */
.sidebar-footer {
    border-top: 1px solid #e5e7eb;
    padding: 1.5rem;
    background: #f8fafc;
}

/* Stats Card */
.stats-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 1rem;
}

.stats-header {
    margin-bottom: 0.75rem;
}

.stats-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #4f46e5;
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* User Profile */
.user-profile {
    display: flex;
    align-items: center;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 0.75rem;
    margin-bottom: 1rem;
}

.user-avatar {
    margin-right: 0.75rem;
}

.user-avatar img {
    width: 40px;
    height: 40px;
}

.user-info {
    flex: 1;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #111827;
    line-height: 1.2;
    margin-bottom: 0.125rem;
}

.user-role {
    font-size: 0.75rem;
    color: #6b7280;
    line-height: 1.2;
}

.user-actions .btn {
    background: transparent;
    border: none;
    color: #6b7280;
    padding: 0.25rem;
}

.user-actions .btn:hover {
    color: #374151;
    background: #f3f4f6;
}

/* External Links */
.external-link {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    color: #6b7280;
    text-decoration: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.external-link:hover {
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
}

/* Ghost Button */
.btn-ghost {
    background: transparent;
    border: none;
    color: #6b7280;
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
}

.btn-ghost:hover {
    background: #f3f4f6;
    color: #374151;
}

/* Dropdown Menu */
.dropdown-menu {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 0.5rem;
    min-width: 160px;
}

.dropdown-item {
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    margin-bottom: 0.125rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background: #f3f4f6;
}

/* Responsive Design */
@media (max-width: 1199px) {
    .admin-sidebar {
        width: 260px;
    }
}

@media (max-width: 991px) {
    .admin-sidebar {
        transform: translateX(-100%);
    }

    .admin-sidebar.show {
        transform: translateX(0);
    }
}

@media (max-width: 767px) {
    .admin-sidebar {
        width: 100%;
        max-width: 320px;
    }

    .menu-text {
        font-size: 0.8rem;
    }

    .sidebar-footer {
        padding: 1rem;
    }

    .stats-grid {
        gap: 0.5rem;
    }
}

@media (max-width: 575px) {
    .admin-sidebar {
        width: 100vw;
        max-width: none;
    }

    .sidebar-header {
        padding: 1rem;
    }

    .menu-items {
        padding: 0 0.5rem;
    }

    .menu-item {
        padding: 0.625rem;
    }
}

/* Sidebar Overlay */
.sidebar-overlay {
    transition: opacity 0.3s ease;
}

/* Mobile Toggle (floating button) */
@media (max-width: 991px) {
    .sidebar-toggle {
        position: fixed;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        z-index: 1050;
        width: 44px;
        height: 44px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 0 0.75rem 0.75rem 0;
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-toggle:hover {
        background: #4338ca;
        transform: translateY(-50%) translateX(4px);
    }

    .sidebar-toggle i {
        font-size: 1.125rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .admin-sidebar {
        background: #111827;
        border-right-color: #374151;
    }

    .sidebar-header {
        background: #1f2937;
        border-bottom-color: #374151;
    }

    .brand-title {
        color: #f9fafb;
    }

    .menu-item {
        color: #d1d5db;
    }

    .menu-item:hover {
        background: #374151;
        color: #f9fafb;
    }

    .stats-card,
    .user-profile {
        background: #1f2937;
        border-color: #374151;
    }

    .stats-title,
    .user-name {
        color: #f9fafb;
    }

    .sidebar-footer {
        background: #1f2937;
        border-top-color: #374151;
    }
}

/* Animation */
.admin-sidebar {
    animation: slideInLeft 0.3s ease-out;
}

@keyframes slideInLeft {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Scrollbar Styling */
.sidebar-menu::-webkit-scrollbar {
    width: 4px;
}

.sidebar-menu::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-menu::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 2px;
}

.sidebar-menu::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>

<script>
// Enhanced Sidebar Toggle Function
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    if (sidebar && overlay) {
        const isShown = sidebar.classList.contains('show');
        
        if (isShown) {
            sidebar.classList.remove('show');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        } else {
            sidebar.classList.add('show');
            overlay.style.display = 'block';
            if (window.innerWidth <= 767) {
                document.body.style.overflow = 'hidden';
            }
        }
    }
}

// Enhanced sidebar management
document.addEventListener('DOMContentLoaded', function() {
    // Create mobile toggle button if it doesn't exist
    if (window.innerWidth <= 991 && !document.querySelector('.sidebar-toggle')) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle';
        toggleBtn.onclick = toggleSidebar;
        toggleBtn.innerHTML = '<i class="bi bi-list"></i>';
        document.body.appendChild(toggleBtn);
    }

    // Auto-close sidebar on mobile when clicking navigation links
    const menuItems = document.querySelectorAll('.admin-sidebar .menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 991) {
                setTimeout(toggleSidebar, 150);
            }
        });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const toggleBtn = document.querySelector('.sidebar-toggle');

        if (window.innerWidth >= 992) {
            // Desktop: ensure sidebar is visible and remove mobile states
            sidebar.classList.remove('show');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
            if (toggleBtn) toggleBtn.style.display = 'none';
        } else {
            // Mobile: ensure toggle button exists
            if (toggleBtn) toggleBtn.style.display = 'flex';
            if (!toggleBtn && !document.querySelector('.sidebar-toggle')) {
                const newToggleBtn = document.createElement('button');
                newToggleBtn.className = 'sidebar-toggle';
                newToggleBtn.onclick = toggleSidebar;
                newToggleBtn.innerHTML = '<i class="bi bi-list"></i>';
                document.body.appendChild(newToggleBtn);
            }
        }
    });

    // Keyboard navigation support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const sidebar = document.getElementById('adminSidebar');
            if (sidebar && sidebar.classList.contains('show')) {
                toggleSidebar();
            }
        }
    });
});

// Smooth scroll to top when clicking on dashboard
document.addEventListener('DOMContentLoaded', function() {
    const dashboardLink = document.querySelector('a[href*="admin"]:not([href*="admin/"])');
    if (dashboardLink) {
        dashboardLink.addEventListener('click', function() {
            setTimeout(() => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        });
    }
});
</script>
