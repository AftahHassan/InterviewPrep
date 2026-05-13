<?php
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PDO drivers: " . implode(', ', PDO::getAvailableDrivers()) . "\n";
echo "Testing MySQL connection...\n";
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [PDO::ATTR_TIMEOUT => 3]);
echo "Connected!\n";
