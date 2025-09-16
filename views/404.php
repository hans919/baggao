<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Baggao Legislative Information System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            margin: 20px;
        }
        .error-icon {
            font-size: 6rem;
            color: #1e3c72;
            margin-bottom: 30px;
        }
        .error-code {
            font-size: 4rem;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 20px;
        }
        .btn-home {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-exclamation-triangle error-icon"></i>
        <div class="error-code">404</div>
        <h2 class="mb-3">Page Not Found</h2>
        <p class="text-muted mb-4">
            Sorry, the page you are looking for does not exist or has been moved.
        </p>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="<?= BASE_URL ?>" class="btn-home me-md-2">
                <i class="bi bi-house-door me-2"></i>Go Home
            </a>
            <button onclick="history.back()" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Go Back
            </button>
        </div>
        
        <hr class="my-4">
        
        <div class="row">
            <div class="col-6">
                <a href="<?= BASE_URL ?>ordinances" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-file-text"></i><br>Ordinances
                </a>
            </div>
            <div class="col-6">
                <a href="<?= BASE_URL ?>resolutions" class="btn btn-outline-success btn-sm w-100">
                    <i class="bi bi-file-earmark-check"></i><br>Resolutions
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
