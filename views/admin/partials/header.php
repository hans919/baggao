<?php
// Get page title and breadcrumb
$page_title = isset($page_title) ? $page_title : 'Dashboard';
$page_description = isset($page_description) ? $page_description : '';
$breadcrumbs = isset($breadcrumbs) ? $breadcrumbs : [];
?>

<header class="admin-header bg-white border-bottom shadow-sm sticky-top">
    <div class="container-fluid px-0">
        <!-- Main Header Bar -->
        <div class="header-main d-flex align-items-center justify-content-between px-4 py-3">
            <!-- Left Section: Logo + Navigation -->
            <div class="header-left d-flex align-items-center">
                <!-- Mobile Menu Toggle -->
                <button class="btn btn-ghost d-lg-none me-3" type="button" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-5"></i>
                </button>
                
                <!-- Breadcrumb Navigation -->
                <nav class="breadcrumb-nav">
                    <?php if (!empty($breadcrumbs)): ?>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>admin" class="text-muted">
                                    <i class="bi bi-house-door me-1"></i>Home
                                </a>
                            </li>
                            <?php foreach ($breadcrumbs as $index => $crumb): ?>
                                <?php if ($index === count($breadcrumbs) - 1): ?>
                                    <li class="breadcrumb-item active"><?= htmlspecialchars($crumb['title']) ?></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?= htmlspecialchars($crumb['url']) ?>">
                                            <?= htmlspecialchars($crumb['title']) ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ol>
                    <?php else: ?>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>admin" class="text-muted">
                                    <i class="bi bi-house-door me-1"></i>Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active"><?= htmlspecialchars($page_title) ?></li>
                        </ol>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- Right Section: Actions -->
            <div class="header-right d-flex align-items-center gap-2">
                <!-- Global Search -->
                <div class="search-container position-relative">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0 search-input" 
                               placeholder="Search..."
                               data-bs-toggle="dropdown"
                               data-bs-auto-close="outside">
                        <div class="dropdown-menu w-100 shadow-lg border-0" style="min-width: 400px;">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <span>Quick Search</span>
                                <small class="text-muted">Type to search</small>
                            </div>
                            <div class="search-results p-2">
                                <div class="text-center text-muted py-3">
                                    <i class="bi bi-search fs-4 d-block mb-2"></i>
                                    Start typing to search documents
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View Toggle -->
                <div class="btn-group btn-group-sm view-toggle" role="group">
                    <input type="radio" class="btn-check" name="viewMode" id="tableView" checked>
                    <label class="btn btn-outline-secondary" for="tableView" title="Table View">
                        <i class="bi bi-table"></i>
                    </label>
                    <input type="radio" class="btn-check" name="viewMode" id="cardView">
                    <label class="btn btn-outline-secondary" for="cardView" title="Card View">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </label>
                </div>

                <!-- Filter Button -->
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                    <i class="bi bi-funnel me-1"></i>
                    <span class="d-none d-sm-inline">Filters</span>
                </button>

                <!-- User Menu -->
                <div class="dropdown user-menu">
                    <button class="btn btn-ghost d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode(isset($current_user['full_name']) ? $current_user['full_name'] : 'Admin User') ?>&background=6366f1&color=fff&size=32" 
                                 alt="User Avatar" class="rounded-circle">
                        </div>
                        <div class="user-info text-start d-none d-md-block">
                            <div class="user-name"><?= isset($current_user['full_name']) ? explode(' ', $current_user['full_name'])[0] : 'Admin' ?></div>
                            <small class="user-role text-muted">Administrator</small>
                        </div>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode(isset($current_user['full_name']) ? $current_user['full_name'] : 'Admin User') ?>&background=6366f1&color=fff&size=40" 
                                     alt="User Avatar" class="rounded-circle me-2">
                                <div>
                                    <div class="fw-semibold"><?= isset($current_user['full_name']) ? htmlspecialchars($current_user['full_name']) : 'Admin User' ?></div>
                                    <small class="text-muted"><?= isset($current_user['email']) ? htmlspecialchars($current_user['email']) : 'admin@baggao.gov.ph' ?></small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/profile">
                            <i class="bi bi-person me-2"></i>Profile Settings
                        </a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/preferences">
                            <i class="bi bi-gear me-2"></i>Preferences
                        </a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>" target="_blank">
                            <i class="bi bi-globe me-2"></i>View Public Site
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Header Section -->
        <div class="page-header px-4 py-3 bg-light border-top">
            <div class="d-flex align-items-center justify-content-between">
                <div class="page-title-section">
                    <h1 class="page-title h4 fw-semibold mb-1"><?= htmlspecialchars($page_title) ?></h1>
                    <?php if (!empty($page_description)): ?>
                        <p class="page-description text-muted mb-0"><?= htmlspecialchars($page_description) ?></p>
                    <?php endif; ?>
                </div>
                
                <!-- Page Actions -->
                <div class="page-actions d-flex align-items-center gap-2">
                    <?php if (isset($page_actions) && !empty($page_actions)): ?>
                        <?php foreach ($page_actions as $action): ?>
                            <a href="<?= htmlspecialchars($action['url']) ?>" 
                               class="btn btn-<?= htmlspecialchars($action['variant'] ?? 'primary') ?> btn-sm">
                                <?php if (isset($action['icon'])): ?>
                                    <i class="bi bi-<?= htmlspecialchars($action['icon']) ?> me-1"></i>
                                <?php endif; ?>
                                <?= htmlspecialchars($action['label']) ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Filter Sidebar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filterSidebar">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Filters & Options</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="filter-section mb-4">
            <h6 class="filter-title">Date Range</h6>
            <div class="row g-2">
                <div class="col-6">
                    <input type="date" class="form-control form-control-sm" placeholder="From">
                </div>
                <div class="col-6">
                    <input type="date" class="form-control form-control-sm" placeholder="To">
                </div>
            </div>
        </div>
        
        <div class="filter-section mb-4">
            <h6 class="filter-title">Status</h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="statusActive" checked>
                <label class="form-check-label" for="statusActive">Active</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="statusDraft">
                <label class="form-check-label" for="statusDraft">Draft</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="statusArchived">
                <label class="form-check-label" for="statusArchived">Archived</label>
            </div>
        </div>

        <div class="filter-actions">
            <button class="btn btn-primary btn-sm w-100 mb-2">Apply Filters</button>
            <button class="btn btn-outline-secondary btn-sm w-100">Clear All</button>
        </div>
    </div>
</div>

<style>
/* Modern Admin Header Styles */
.admin-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid #e5e7eb;
    z-index: 1030;
    transition: all 0.2s ease;
}

.admin-header .header-main {
    min-height: 60px;
}

.admin-header .page-header {
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
}

/* Breadcrumb */
.breadcrumb {
    font-size: 0.875rem;
    margin-bottom: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: #6b7280;
}

.breadcrumb-item a {
    color: #6b7280;
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #4f46e5;
}

.breadcrumb-item.active {
    color: #111827;
    font-weight: 500;
}

/* Ghost Button */
.btn-ghost {
    background: transparent;
    border: 1px solid transparent;
    color: #6b7280;
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.btn-ghost:hover {
    background: #f3f4f6;
    color: #374151;
    border-color: #e5e7eb;
}

/* Search Container */
.search-container {
    width: 280px;
}

.search-input {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.search-input:focus {
    background: #ffffff;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.input-group-text {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    color: #6b7280;
}

/* View Toggle */
.view-toggle .btn {
    border: 1px solid #e5e7eb;
    background: #ffffff;
    color: #6b7280;
    padding: 0.375rem 0.75rem;
}

.view-toggle .btn.active,
.view-toggle .btn:checked + .btn {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #ffffff;
}

/* User Menu */
.user-menu .btn {
    background: transparent;
    border: 1px solid transparent;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.user-menu .btn:hover {
    background: #f3f4f6;
    border-color: #e5e7eb;
}

.user-avatar img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: #111827;
    line-height: 1.2;
}

.user-role {
    font-size: 0.75rem;
    color: #6b7280;
    line-height: 1.2;
}

/* Page Title Section */
.page-title {
    color: #111827;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.page-description {
    color: #6b7280;
    font-size: 0.875rem;
}

/* Dropdown Menus */
.dropdown-menu {
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    padding: 0.5rem;
}

.dropdown-item {
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    margin-bottom: 0.125rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background: #f3f4f6;
    color: #374151;
}

.dropdown-header {
    color: #374151;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-color: #e5e7eb;
}

/* Filter Sidebar */
.offcanvas {
    border: none;
    box-shadow: -4px 0 25px rgba(0, 0, 0, 0.1);
}

.offcanvas-header {
    border-bottom: 1px solid #e5e7eb;
    padding: 1.5rem;
}

.offcanvas-title {
    font-weight: 600;
    color: #111827;
}

.filter-section {
    padding: 0 1.5rem;
}

.filter-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
}

.filter-actions {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    margin-top: auto;
}

/* Form Controls */
.form-control {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    background: #f9fafb;
    transition: all 0.2s ease;
}

.form-control:focus {
    background: #ffffff;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-check-input:checked {
    background-color: #4f46e5;
    border-color: #4f46e5;
}

/* Buttons */
.btn-primary {
    background: #4f46e5;
    border-color: #4f46e5;
    font-weight: 500;
}

.btn-primary:hover {
    background: #4338ca;
    border-color: #4338ca;
}

.btn-outline-secondary {
    border-color: #e5e7eb;
    color: #6b7280;
    background: #ffffff;
}

.btn-outline-secondary:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    color: #374151;
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-container {
        width: 100%;
        max-width: 200px;
    }
    
    .header-right {
        flex-wrap: wrap;
        gap: 0.5rem !important;
    }
    
    .page-header {
        padding: 1rem 1rem !important;
    }
    
    .page-title {
        font-size: 1.25rem;
    }
    
    .user-info {
        display: none !important;
    }
}

@media (max-width: 576px) {
    .admin-header .container-fluid {
        padding: 0 1rem;
    }
    
    .search-container {
        width: 100%;
    }
    
    .view-toggle .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .page-actions .btn {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .admin-header {
        background: rgba(17, 24, 39, 0.95);
        border-bottom-color: #374151;
    }
    
    .page-header {
        background: #111827;
        border-top-color: #374151;
    }
    
    .page-title {
        color: #f9fafb;
    }
    
    .page-description {
        color: #9ca3af;
    }
    
    .btn-ghost:hover {
        background: #374151;
        color: #f9fafb;
    }
    
    .search-input {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }
    
    .form-control {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }
}

/* Animation */
.admin-header {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Focus states for accessibility */
.btn:focus,
.form-control:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}
</style>
