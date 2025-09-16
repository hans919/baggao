<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'core/Model.php';
require_once 'models/User.php';

$userModel = new User();
$user = $userModel->authenticate('admin@baggao.gov.ph', 'admin123');

if ($user) {
    echo "Login successful! User: " . $user['email'] . ", Role: " . $user['role'];
} else {
    echo "Login failed!";
}
?>
