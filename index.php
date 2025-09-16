<?php
require_once 'config/config.php';
require_once 'config/database.php';

// Auto-load classes
spl_autoload_register(function ($class_name) {
    $directories = [
        'models/',
        'controllers/',
        'core/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Simple routing
$request = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Route mapping
$routes = [
    'home' => 'HomeController',
    'ordinances' => 'OrdinanceController',
    'resolutions' => 'ResolutionController',
    'minutes' => 'MinuteController',
    'councilors' => 'CouncilorController',
    'publications' => 'PublicationController',
    'reports' => 'ReportController',
    'admin' => 'AdminController',
    'auth' => 'AuthController'
];

// Initialize controller
if (isset($routes[$request])) {
    $controller_name = $routes[$request];
    $controller = new $controller_name();
    
    if (method_exists($controller, $action)) {
        $controller->$action($id);
    } else {
        $controller->index();
    }
} else {
    // 404 page
    include 'views/404.php';
}
?>
