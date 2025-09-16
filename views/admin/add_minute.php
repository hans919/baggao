<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meeting Minutes - Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 222.2 84% 4.9%;
            --card: 0 0% 100%;
            --card-foreground: 222.2 84% 4.9%;
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
            --radius: 0.75rem;
        }

        body {
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .sidebar {
            background-color: hsl(var(--card));
            border-right: 1px solid hsl(var(--border));
            min-height: 100vh;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid hsl(var(--border));
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0 0.75rem 0.25rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: hsl(var(--muted-foreground));
            text-decoration: none;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background-color: hsl(var(--accent));
            color: hsl(var(--accent-foreground));
        }

        .nav-link.active {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 1rem;
            height: 1rem;
        }

        .main-content {
            background-color: hsl(var(--background));
            min-height: 100vh;
        }

        .header {
            background-color: hsl(var(--card));
            border-bottom: 1px solid hsl(var(--border));
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 600;
            color: hsl(var(--foreground));
            margin: 0;
        }

        .breadcrumb {
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
            margin: 0;
        }

        .card {
            background-color: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid hsl(var(--border));
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: hsl(var(--foreground));
            margin: 0;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: hsl(var(--foreground));
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid hsl(var(--input));
            border-radius: var(--radius);
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: hsl(var(--primary));
            box-shadow: 0 0 0 2px hsl(var(--primary) / 0.2);
            outline: none;
        }

        .btn {
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
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
        }

        .btn-outline {
            background-color: transparent;
            color: hsl(var(--foreground));
            border: 1px solid hsl(var(--border));
        }

        .btn-outline:hover {
            background-color: hsl(var(--accent));
            color: hsl(var(--accent-foreground));
        }

        .divider {
            height: 1px;
            background-color: hsl(var(--border));
            margin: 1rem 0;
        }

        .text-muted {
            color: hsl(var(--muted-foreground)) !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-brand">
                    <h4 class="fw-bold text-primary mb-1">Admin Panel</h4>
                    <p class="text-muted small mb-0">Legislative System</p>
                </div>
                
                <div class="sidebar-nav">
                    <div class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>admin">
                            <i class="bi bi-grid"></i>Dashboard
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>admin/ordinances">
                            <i class="bi bi-file-text"></i>Ordinances
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>admin/resolutions">
                            <i class="bi bi-file-earmark-check"></i>Resolutions
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link active" href="<?= BASE_URL ?>admin/minutes">
                            <i class="bi bi-journal-text"></i>Meeting Minutes
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>admin/publications">
                            <i class="bi bi-megaphone"></i>Publications
                        </a>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>">
                            <i class="bi bi-globe"></i>Public Site
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>auth/logout">
                            <i class="bi bi-box-arrow-right"></i>Logout
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 main-content">
                <!-- Header -->
                <div class="header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">Add Meeting Minutes</h1>
                            <p class="breadcrumb">Record new meeting minutes and proceedings</p>
                        </div>
                        <a href="<?= BASE_URL ?>admin/minutes" class="btn btn-outline">
                            <i class="bi bi-arrow-left me-2"></i>Back to Minutes
                        </a>
                    </div>
                </div>

                <div class="container-fluid">
                    <!-- Add Minutes Form -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Meeting Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= BASE_URL ?>admin/create_minute" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Meeting Title</label>
                                        <input type="text" class="form-control" id="title" name="title" 
                                               placeholder="e.g., Regular Session Meeting" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="session_type" class="form-label">Session Type</label>
                                        <select class="form-select" id="session_type" name="session_type" required>
                                            <option value="">Select Session Type</option>
                                            <option value="Regular Session">Regular Session</option>
                                            <option value="Special Session">Special Session</option>
                                            <option value="Committee Meeting">Committee Meeting</option>
                                            <option value="Public Hearing">Public Hearing</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="meeting_date" class="form-label">Meeting Date</label>
                                        <input type="date" class="form-control" id="meeting_date" name="meeting_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="meeting_time" class="form-label">Meeting Time</label>
                                        <input type="time" class="form-control" id="meeting_time" name="meeting_time" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="attendees" class="form-label">Attendees</label>
                                    <textarea class="form-control" id="attendees" name="attendees" rows="3" 
                                              placeholder="List all attendees (councilors, staff, guests)" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="agenda" class="form-label">Agenda</label>
                                    <textarea class="form-control" id="agenda" name="agenda" rows="4" 
                                              placeholder="Meeting agenda items" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="summary" class="form-label">Meeting Summary</label>
                                    <textarea class="form-control" id="summary" name="summary" rows="6" 
                                              placeholder="Detailed summary of the meeting proceedings" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="document" class="form-label">Document (PDF)</label>
                                        <input type="file" class="form-control" id="document" name="document" accept=".pdf">
                                    </div>
                                </div>

                                <div class="form-text text-muted mb-4">
                                    Optional: Upload PDF document of the official meeting minutes
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus me-2"></i>Create Minutes
                                    </button>
                                    <a href="<?= BASE_URL ?>admin/minutes" class="btn btn-outline">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
