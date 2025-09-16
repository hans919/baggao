<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin Dashboard - Baggao Legislative Information System' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Table Component CSS -->
    <link href="<?= BASE_URL ?>assets/css/table-component.css" rel="stylesheet">
    
    <style>
        :root {
            /* Modern Design System Colors */
            --background: 0 0% 100%;
            --foreground: 222.2 84% 4.9%;
            --card: 0 0% 100%;
            --card-foreground: 222.2 84% 4.9%;
            --popover: 0 0% 100%;
            --popover-foreground: 222.2 84% 4.9%;
            --primary: 221.2 83.2% 53.3%;
            --primary-foreground: 210 40% 98%;
            --secondary: 210 40% 96%;
            --secondary-foreground: 222.2 84% 4.9%;
            --muted: 248 50% 98%;
            --muted-foreground: 215.4 16.3% 46.9%;
            --accent: 210 40% 96%;
            --accent-foreground: 222.2 84% 4.9%;
            --destructive: 0 84.2% 60.2%;
            --destructive-foreground: 210 40% 98%;
            --border: 214.3 31.8% 91.4%;
            --input: 214.3 31.8% 91.4%;
            --ring: 221.2 83.2% 53.3%;
            --radius: 0.5rem;
            
            /* Content Layout */
            --sidebar-width: 280px;
            --header-height: 120px;
            --content-padding: 1.5rem;
            
            /* TanStack Table Colors */
            --table-bg: 0 0% 100%;
            --table-border: 214.3 31.8% 91.4%;
            --table-header-bg: 248 50% 98%;
            --table-row-hover: 248 50% 98%;
            --table-selected: 214 95% 93%;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: hsl(var(--muted));
            color: hsl(var(--foreground));
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            overflow-x: hidden;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, hsl(var(--muted)) 0%, hsl(var(--background)) 100%);
        }

        .admin-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: hsl(var(--background));
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content {
            flex: 1;
            padding: var(--content-padding);
            background: hsl(var(--background));
            min-height: calc(100vh - var(--header-height));
            margin-top: var(--header-height);
            position: relative;
        }

        /* Content Area Styling */
        .content-container {
            max-width: 100%;
            margin: 0 auto;
            position: relative;
        }

        .page-content {
            background: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Modern Alert Styles */
        .alert {
            border-radius: var(--radius);
            border: 1px solid;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            position: relative;
            animation: slideInDown 0.3s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, hsl(142.1 76.2% 36.3% / 0.1) 0%, hsl(142.1 76.2% 36.3% / 0.05) 100%);
            border-color: hsl(142.1 76.2% 36.3% / 0.2);
            color: hsl(142.1 76.2% 36.3%);
        }

        .alert-danger {
            background: linear-gradient(135deg, hsl(var(--destructive) / 0.1) 0%, hsl(var(--destructive) / 0.05) 100%);
            border-color: hsl(var(--destructive) / 0.2);
            color: hsl(var(--destructive));
        }

        .alert-warning {
            background: linear-gradient(135deg, hsl(48 96% 53% / 0.1) 0%, hsl(48 96% 53% / 0.05) 100%);
            border-color: hsl(48 96% 53% / 0.2);
            color: hsl(25 95% 53%);
        }

        .alert-info {
            background: linear-gradient(135deg, hsl(204 94% 94%) 0%, hsl(204 94% 96%) 100%);
            border-color: hsl(204 94% 88%);
            color: hsl(204 80% 40%);
        }

        .alert .btn-close {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            font-size: 0.75rem;
            opacity: 0.6;
        }

        .alert .btn-close:hover {
            opacity: 1;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: hsl(var(--ring));
            box-shadow: 0 0 0 3px hsl(var(--ring) / 0.1);
            outline: none;
        }

        .form-label {
            font-weight: 500;
            color: hsl(var(--foreground));
            margin-bottom: 0.5rem;
        }

        /* Button Styles */
        .btn {
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, hsl(var(--primary)) 0%, hsl(var(--primary) / 0.9) 100%);
            color: hsl(var(--primary-foreground));
            border-color: hsl(var(--primary));
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, hsl(var(--primary) / 0.9) 0%, hsl(var(--primary) / 0.8) 100%);
            border-color: hsl(var(--primary) / 0.9);
            color: hsl(var(--primary-foreground));
            transform: translateY(-1px);
            box-shadow: 0 4px 12px hsl(var(--primary) / 0.3);
        }

        .btn-secondary {
            background-color: hsl(var(--secondary));
            color: hsl(var(--secondary-foreground));
            border-color: hsl(var(--border));
        }

        .btn-secondary:hover {
            background-color: hsl(var(--secondary) / 0.8);
            border-color: hsl(var(--border));
            color: hsl(var(--secondary-foreground));
        }

        .btn-outline-primary {
            background-color: transparent;
            color: hsl(var(--primary));
            border-color: hsl(var(--primary));
        }

        .btn-outline-primary:hover {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
            border-color: hsl(var(--primary));
        }

        .btn-outline-secondary {
            background-color: transparent;
            color: hsl(var(--muted-foreground));
            border-color: hsl(var(--border));
        }

        .btn-outline-secondary:hover {
            background-color: hsl(var(--secondary));
            color: hsl(var(--secondary-foreground));
            border-color: hsl(var(--border));
        }

        .btn-outline-danger {
            background-color: transparent;
            color: hsl(var(--destructive));
            border-color: hsl(var(--destructive));
        }

        .btn-outline-danger:hover {
            background-color: hsl(var(--destructive));
            color: hsl(var(--destructive-foreground));
            border-color: hsl(var(--destructive));
        }

        /* Card Styles */
        .card {
            background-color: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: hsl(var(--muted));
            border-bottom: 1px solid hsl(var(--border));
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: hsl(var(--foreground));
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Mobile Responsiveness */
        @media (max-width: 991px) {
            .admin-content {
                margin-left: 0;
            }

            .main-content {
                padding: 1rem;
            }

            .admin-content.sidebar-open {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            :root {
                --content-padding: 1rem;
                --header-height: 100px;
            }

            .main-content {
                padding: 0.75rem;
            }

            .alert {
                padding: 0.75rem 1rem;
                margin-bottom: 1rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 0.5rem 0.75rem;
            }
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: hsl(var(--muted));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: hsl(var(--border));
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: hsl(var(--muted-foreground));
        }

        /* Utility Classes */
        .hover-shadow {
            transition: all 0.2s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .rounded-lg {
            border-radius: calc(var(--radius) + 4px);
        }

        .text-gradient {
            background: linear-gradient(135deg, hsl(var(--primary)) 0%, hsl(var(--primary) / 0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Loading States */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .spinner {
            width: 2rem;
            height: 2rem;
            border: 2px solid hsl(var(--border));
            border-top-color: hsl(var(--primary));
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animations */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-1rem);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Focus States for Accessibility */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            outline: 2px solid hsl(var(--ring));
            outline-offset: 2px;
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            :root {
                --background: 222.2 84% 4.9%;
                --foreground: 210 40% 98%;
                --card: 222.2 84% 4.9%;
                --card-foreground: 210 40% 98%;
                --muted: 217.2 32.6% 17.5%;
                --muted-foreground: 215 20.2% 65.1%;
                --border: 217.2 32.6% 17.5%;
                --input: 217.2 32.6% 17.5%;
            }

            .admin-wrapper {
                background: linear-gradient(135deg, hsl(var(--muted)) 0%, hsl(var(--background)) 100%);
            }
        }

        /* Print Styles */
        @media print {
            .admin-sidebar,
            .admin-header,
            .btn,
            .alert {
                display: none !important;
            }

            .admin-content {
                margin-left: 0;
            }

            .main-content {
                margin-top: 0;
                padding: 0;
            }
        }
    </style>
    
    <?php if (isset($additional_css)): ?>
        <?= $additional_css ?>
    <?php endif; ?>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Include Sidebar -->
        <?php include __DIR__ . '/partials/sidebar.php'; ?>
        
        <!-- Main Content Area -->
        <div class="admin-content">
            <!-- Include Header -->
            <?php include __DIR__ . '/partials/header.php'; ?>
            
            <!-- Main Content -->
            <main class="main-content">
                <div class="content-container">
                    <!-- Success/Error Messages -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            <div class="flex-grow-1"><?= htmlspecialchars($_SESSION['success']) ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div class="flex-grow-1"><?= htmlspecialchars($_SESSION['error']) ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['warning'])): ?>
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div class="flex-grow-1"><?= htmlspecialchars($_SESSION['warning']) ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['warning']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['info'])): ?>
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle-fill"></i>
                            <div class="flex-grow-1"><?= htmlspecialchars($_SESSION['info']) ?></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['info']); ?>
                    <?php endif; ?>
                    
                    <!-- Page Content -->
                    <div class="page-content">
                        <?= $content ?>
                    </div>
                </div>
            </main>
            
            <!-- Include Footer -->
            <?php include __DIR__ . '/partials/footer.php'; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Table Component JS -->
    <script src="<?= BASE_URL ?>assets/js/table-component.js"></script>
    
    <?php if (isset($additional_js)): ?>
        <?= $additional_js ?>
    <?php endif; ?>

    <script>
        // Enhanced alert management
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 7 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Add animation class
                alert.style.animation = 'slideInDown 0.3s ease-out';
                
                setTimeout(function() {
                    if (alert && alert.parentNode) {
                        alert.style.animation = 'fadeOut 0.3s ease-out';
                        setTimeout(() => {
                            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                            bsAlert.close();
                        }, 300);
                    }
                }, 7000);
            });

            // Add fade out animation style
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeOut {
                    from { opacity: 1; transform: translateY(0); }
                    to { opacity: 0; transform: translateY(-1rem); }
                }
            `;
            document.head.appendChild(style);
        });

        // Enhanced sidebar management
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const content = document.querySelector('.admin-content');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (sidebar && content) {
                const isVisible = sidebar.classList.contains('show');
                
                if (isVisible) {
                    sidebar.classList.remove('show');
                    content.classList.remove('sidebar-open');
                    if (overlay) overlay.style.display = 'none';
                    document.body.style.overflow = '';
                } else {
                    sidebar.classList.add('show');
                    content.classList.add('sidebar-open');
                    if (overlay) overlay.style.display = 'block';
                    if (window.innerWidth <= 767) {
                        document.body.style.overflow = 'hidden';
                    }
                }
            }
        }

        // Handle window resize for responsive behavior
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('adminSidebar');
            const content = document.querySelector('.admin-content');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (window.innerWidth >= 992) {
                // Desktop: ensure proper state
                if (sidebar) sidebar.classList.remove('show');
                if (content) content.classList.remove('sidebar-open');
                if (overlay) overlay.style.display = 'none';
                document.body.style.overflow = '';
            }
        });

        // Smooth scrolling for anchor links
        document.addEventListener('click', function(e) {
            if (e.target.matches('a[href^="#"]')) {
                e.preventDefault();
                const target = document.querySelector(e.target.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });

        // Loading state management
        function showLoading(container = document.body) {
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'loading-overlay';
            loadingOverlay.innerHTML = '<div class="spinner"></div>';
            container.style.position = 'relative';
            container.appendChild(loadingOverlay);
            return loadingOverlay;
        }

        function hideLoading(overlay) {
            if (overlay && overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }

        // Global error handler for AJAX requests
        window.addEventListener('unhandledrejection', function(event) {
            console.error('Unhandled promise rejection:', event.reason);
            // You could show a user-friendly error message here
        });

        // Performance monitoring
        window.addEventListener('load', function() {
            if ('performance' in window && 'getEntriesByType' in performance) {
                const navigation = performance.getEntriesByType('navigation')[0];
                console.log('Page load time:', navigation.loadEventEnd - navigation.loadEventStart, 'ms');
            }
        });
    </script>
</body>
</html>
