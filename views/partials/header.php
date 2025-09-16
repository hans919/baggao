<!-- Navigation Header -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container-fluid px-4">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>">
            <img src="<?= BASE_URL ?>assets/images/baggao-logo.png" alt="Baggao Logo" class="logo" style="display: none;">
            <div class="d-flex flex-column">
                <span class="fw-bold">Baggao Legislative</span>
                <small style="font-size: 0.75rem; opacity: 0.8;">Information System</small>
            </div>
        </a>

        <!-- Mobile toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page ?? '') === 'home' ? 'active' : '' ?>" href="<?= BASE_URL ?>">
                        <i class="bi bi-house-door"></i>Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array(($current_page ?? ''), ['ordinances', 'resolutions']) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-file-text"></i>Legislation
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= ($current_page ?? '') === 'ordinances' ? 'active' : '' ?>" href="<?= BASE_URL ?>ordinances">
                            <i class="bi bi-file-text me-2"></i>Ordinances
                        </a></li>
                        <li><a class="dropdown-item <?= ($current_page ?? '') === 'resolutions' ? 'active' : '' ?>" href="<?= BASE_URL ?>resolutions">
                            <i class="bi bi-file-earmark-check me-2"></i>Resolutions
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page ?? '') === 'minutes' ? 'active' : '' ?>" href="<?= BASE_URL ?>minutes">
                        <i class="bi bi-journal-text"></i>Minutes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page ?? '') === 'councilors' ? 'active' : '' ?>" href="<?= BASE_URL ?>councilors">
                        <i class="bi bi-people"></i>Councilors
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page ?? '') === 'publications' ? 'active' : '' ?>" href="<?= BASE_URL ?>publications">
                        <i class="bi bi-megaphone"></i>News
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page ?? '') === 'reports' ? 'active' : '' ?>" href="<?= BASE_URL ?>reports">
                        <i class="bi bi-file-earmark-bar-graph"></i>Reports
                    </a>
                </li>
            </ul>

            <!-- Search Form and Admin Login -->
            <div class="d-flex align-items-center gap-3">
                <!-- Search Form -->
                <form class="d-flex search-form" method="GET" action="<?= BASE_URL ?>home/search" role="search">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="search" name="q" placeholder="Search documents..." 
                               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Admin Login -->
                <a href="<?= BASE_URL ?>auth/login" class="btn btn-outline-light btn-sm d-flex align-items-center">
                    <i class="bi bi-person-lock me-1"></i>
                    <span class="d-none d-md-inline">Admin</span>
                </a>
            </div>
        </div>
    </div>
</nav>
