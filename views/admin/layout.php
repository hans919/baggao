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
    
    <style>
        :root {
            /* shadcn/ui color palette */
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
            --muted: 210 40% 96%;
            --muted-foreground: 215.4 16.3% 46.9%;
            --accent: 210 40% 96%;
            --accent-foreground: 222.2 84% 4.9%;
            --destructive: 0 84.2% 60.2%;
            --destructive-foreground: 210 40% 98%;
            --border: 214.3 31.8% 91.4%;
            --input: 214.3 31.8% 91.4%;
            --ring: 221.2 83.2% 53.3%;
            --radius: 0.75rem;
            
            /* Admin specific colors */
            --sidebar-bg: 222.2 84% 4.9%;
            --sidebar-text: 210 40% 98%;
            --sidebar-muted: 215 20.2% 65.1%;
            --sidebar-active: 221.2 83.2% 53.3%;
            --sidebar-hover: 217.2 32.6% 17.5%;
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
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            background-color: hsl(var(--muted));
        }

        .admin-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: hsl(var(--background));
            margin-left: 280px;
            min-height: 100vh;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .admin-content {
                margin-left: 0;
            }
        }

        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: hsl(var(--muted));
        }

        ::-webkit-scrollbar-thumb {
            background: hsl(var(--border));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: hsl(var(--muted-foreground));
        }

        /* Custom utilities */
        .hover-shadow {
            transition: all 0.2s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            transform: translateY(-1px);
        }

        .border-0 {
            border: none !important;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        }

        .rounded-lg {
            border-radius: calc(var(--radius) + 2px);
        }

        /* Form improvements */
        .form-control:focus, .form-select:focus {
            border-color: hsl(var(--ring));
            box-shadow: 0 0 0 3px hsl(var(--ring) / 0.1);
        }

        .btn {
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
            border-color: hsl(var(--primary));
        }

        .btn-primary:hover {
            background-color: hsl(var(--primary) / 0.9);
            border-color: hsl(var(--primary) / 0.9);
            color: hsl(var(--primary-foreground));
        }

        .card {
            background-color: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        }

        .alert {
            border-radius: var(--radius);
            border: 1px solid;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: hsl(142.1 76.2% 36.3% / 0.1);
            border-color: hsl(142.1 76.2% 36.3% / 0.2);
            color: hsl(142.1 76.2% 36.3%);
        }

        .alert-danger {
            background-color: hsl(var(--destructive) / 0.1);
            border-color: hsl(var(--destructive) / 0.2);
            color: hsl(var(--destructive));
        }

        .alert-warning {
            background-color: hsl(48 96% 53% / 0.1);
            border-color: hsl(48 96% 53% / 0.2);
            color: hsl(25 95% 53%);
        }

        .alert-info {
            background-color: hsl(204 94% 94%);
            border-color: hsl(204 94% 88%);
            color: hsl(204 80% 40%);
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
            <main class="flex-grow-1 p-4">
                <!-- Success/Error Messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= $_SESSION['success'] ?></div>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?= $_SESSION['error'] ?></div>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['warning'])): ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?= $_SESSION['warning'] ?></div>
                    </div>
                    <?php unset($_SESSION['warning']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['info'])): ?>
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div><?= $_SESSION['info'] ?></div>
                    </div>
                    <?php unset($_SESSION['info']); ?>
                <?php endif; ?>
                
                <!-- Page Content -->
                <?= $content ?>
            </main>
            
            <!-- Include Footer -->
            <?php include __DIR__ . '/partials/footer.php'; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if (isset($additional_js)): ?>
        <?= $additional_js ?>
    <?php endif; ?>

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Mobile sidebar toggle (if needed)
        function toggleSidebar() {
            const sidebar = document.querySelector('.admin-sidebar');
            const content = document.querySelector('.admin-content');
            sidebar.classList.toggle('mobile-hidden');
            content.classList.toggle('mobile-full');
        }
    </script>
</body>
</html>
