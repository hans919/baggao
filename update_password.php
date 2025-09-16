<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'core/Model.php';
require_once 'models/User.php';

$userModel = new User();
$userModel->updatePassword(1, 'admin123');
echo "Password updated successfully!";
?>
