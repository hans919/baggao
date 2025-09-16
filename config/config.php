<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'baggao_legislative');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application configuration
define('BASE_URL', 'http://localhost/mom/');
define('APP_NAME', 'Baggao Legislative Information System');
define('UPLOAD_PATH', 'uploads/');

// Session configuration
session_start();

// Timezone
date_default_timezone_set('Asia/Manila');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
