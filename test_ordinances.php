<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'core/Model.php';
require_once 'models/Ordinance.php';

$ordinanceModel = new Ordinance();
$ordinances = $ordinanceModel->getWithAuthor();
echo 'Found ' . count($ordinances) . ' ordinances' . PHP_EOL;
if (count($ordinances) > 0) {
    echo 'First ordinance: ' . $ordinances[0]['title'] . PHP_EOL;
}
?>
