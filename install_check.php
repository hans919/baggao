<?php
// Simple installation check script
// Run this first to check if your system is ready

echo "<h2>Baggao Legislative Information System - Installation Check</h2>";

// Check PHP version
echo "<h3>1. PHP Version Check</h3>";
if (version_compare(PHP_VERSION, '7.4.0') >= 0) {
    echo "<p style='color: green;'>✓ PHP " . PHP_VERSION . " - OK</p>";
} else {
    echo "<p style='color: red;'>✗ PHP version too old. Need 7.4+. Current: " . PHP_VERSION . "</p>";
}

// Check PDO MySQL
echo "<h3>2. Database Extension Check</h3>";
if (extension_loaded('pdo') && extension_loaded('pdo_mysql')) {
    echo "<p style='color: green;'>✓ PDO MySQL extension - OK</p>";
} else {
    echo "<p style='color: red;'>✗ PDO MySQL extension not found</p>";
}

// Check file permissions
echo "<h3>3. File Permissions Check</h3>";
$upload_dir = 'uploads';
if (is_writable($upload_dir)) {
    echo "<p style='color: green;'>✓ Uploads directory is writable - OK</p>";
} else {
    echo "<p style='color: red;'>✗ Uploads directory is not writable</p>";
}

// Database connection test
echo "<h3>4. Database Connection Test</h3>";
try {
    require_once 'config/config.php';
    require_once 'config/database.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<p style='color: green;'>✓ Database connection - OK</p>";
    
    // Test if tables exist
    $tables = ['users', 'councilors', 'ordinances', 'resolutions', 'minutes', 'publications'];
    $existing_tables = [];
    
    foreach ($tables as $table) {
        $stmt = $db->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table]);
        if ($stmt->fetch()) {
            $existing_tables[] = $table;
        }
    }
    
    echo "<h4>Database Tables:</h4>";
    if (count($existing_tables) === count($tables)) {
        echo "<p style='color: green;'>✓ All required tables exist (" . implode(', ', $existing_tables) . ")</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Some tables missing. Found: " . implode(', ', $existing_tables) . "</p>";
        echo "<p>Missing: " . implode(', ', array_diff($tables, $existing_tables)) . "</p>";
        echo "<p><strong>Please import the database file: database/baggao_legislative.sql</strong></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database configuration in config/config.php</p>";
}

echo "<h3>5. Next Steps</h3>";
echo "<ul>";
echo "<li>If all checks pass, go to: <a href='index.php'>Main Application</a></li>";
echo "<li>Admin login: <a href='index.php?page=auth&action=login'>Admin Dashboard</a></li>";
echo "<li>Default credentials: admin / admin123</li>";
echo "</ul>";

echo "<h3>6. Sample URLs</h3>";
echo "<ul>";
echo "<li><a href='index.php'>Home Page</a></li>";
echo "<li><a href='index.php?page=ordinances'>Ordinances</a></li>";
echo "<li><a href='index.php?page=resolutions'>Resolutions</a></li>";
echo "<li><a href='index.php?page=minutes'>Meeting Minutes</a></li>";
echo "<li><a href='index.php?page=councilors'>Councilors</a></li>";
echo "<li><a href='index.php?page=publications'>Publications</a></li>";
echo "<li><a href='index.php?page=reports'>Reports</a></li>";
echo "</ul>";
?>
