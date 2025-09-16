<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Baggao Legislative Information System' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-foreground: #ffffff;
            --secondary: #f1f5f9;
            --secondary-foreground: #0f172a;
            --muted: #f8fafc;
            --muted-foreground: #64748b;
            --accent: #f1f5f9;
            --accent-foreground: #0f172a;
            --destructive: #ef4444;
            --destructive-foreground: #ffffff;
            --border: #e2e8f0;
            --input: #e2e8f0;
            --ring: #2563eb;
            --background: #ffffff;
            --foreground: #0f172a;
            --card: #ffffff;
            --card-foreground: #0f172a;
            --popover: #ffffff;
            --popover-foreground: #0f172a;
            --radius: 0.5rem;
        }

        * {
            border-color: var(--border);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            line-height: 1.6;
        }

        /* Navbar with shadcn/ui styling */
        .navbar-custom {
            background: var(--primary);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            backdrop-filter: blur(8px);
        }

        .navbar-custom .navbar-brand {
            color: var(--primary-foreground);
            font-weight: 600;
            font-size: 1.25rem;
            transition: color 0.2s ease;
        }

        .navbar-custom .navbar-brand:hover {
            color: rgb(255 255 255 / 0.9);
        }

        .navbar-custom .navbar-nav .nav-link {
            color: rgb(255 255 255 / 0.9);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            border-radius: var(--radius);
            margin: 0 0.125rem;
            font-size: 0.875rem;
        }

        .navbar-custom .navbar-nav .nav-link:hover,
        .navbar-custom .navbar-nav .nav-link.active {
            color: var(--primary-foreground);
            background-color: rgb(255 255 255 / 0.1);
        }

        .navbar-custom .navbar-nav .nav-link i {
            margin-right: 0.375rem;
            font-size: 0.875rem;
        }

        .navbar-custom .navbar-toggler {
            border: 1px solid rgb(255 255 255 / 0.2);
            padding: 0.375rem 0.75rem;
        }

        .navbar-custom .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgb(255 255 255 / 0.2);
        }

        /* shadcn/ui inspired form controls */
        .form-control {
            border: 1px solid var(--input);
            border-radius: var(--radius);
            background-color: var(--background);
            font-size: 0.875rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--ring);
            box-shadow: 0 0 0 2px rgb(37 99 235 / 0.2);
            outline: none;
        }

        /* shadcn/ui buttons */
        .btn {
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: rgb(37 99 235 / 0.9);
            border-color: rgb(37 99 235 / 0.9);
            color: var(--primary-foreground);
        }

        .btn-outline-light {
            border-color: rgb(255 255 255 / 0.2);
            color: var(--primary-foreground);
        }

        .btn-outline-light:hover {
            background-color: rgb(255 255 255 / 0.1);
            border-color: rgb(255 255 255 / 0.3);
            color: var(--primary-foreground);
        }

        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
        }

        .btn-info {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
        }

        .btn-warning {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }

        /* shadcn/ui cards */
        .card {
            background-color: var(--card);
            color: var(--card-foreground);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            transform: translateY(-1px);
        }

        .card-header {
            background-color: var(--muted);
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Layout improvements */
        .main-content {
            background-color: var(--muted);
            min-height: calc(100vh - 80px);
            padding-top: 2rem;
        }

        .search-form {
            width: 280px;
        }

        @media (max-width: 991px) {
            .search-form {
                width: 100%;
                margin-top: 1rem;
            }
        }

        /* Typography */
        .page-title {
            color: var(--foreground);
            font-weight: 600;
            margin-bottom: 2rem;
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .text-muted {
            color: var(--muted-foreground) !important;
        }

        /* Footer */
        .footer {
            background-color: var(--foreground);
            color: var(--background);
            border-top: 1px solid var(--border);
        }

        .logo {
            height: 32px;
            width: auto;
            margin-right: 0.75rem;
        }

        /* Badges */
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: calc(var(--radius) - 2px);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }
            
            .btn {
                font-size: 0.8rem;
                padding: 0.375rem 0.75rem;
            }
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            background-color: var(--popover);
            color: var(--popover-foreground);
        }

        .dropdown-item {
            color: var(--popover-foreground);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: var(--accent);
            color: var(--accent-foreground);
        }

        .dropdown-item.active {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        /* Input groups */
        .input-group .form-control:focus {
            z-index: 3;
        }

        .input-group .btn {
            border-left: 0;
        }

        /* Enhanced animations */
        .card {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Text selection */
        ::selection {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        /* Focus styles */
        .btn:focus,
        .nav-link:focus {
            outline: 2px solid var(--ring);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid px-4">
            <?= $content ?? '' ?>
        </div>
    </main>
    
    <?php include 'partials/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
