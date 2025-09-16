<?php
$hash = password_hash('admin123', PASSWORD_DEFAULT);
echo 'Hash: ' . $hash . PHP_EOL;
echo 'Verify: ' . (password_verify('admin123', $hash) ? 'true' : 'false') . PHP_EOL;
?>
