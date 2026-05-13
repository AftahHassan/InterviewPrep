<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    echo "Connected OK\n";
    
    // Drop and recreate the database
    $pdo->exec("DROP DATABASE IF EXISTS interview_prep");
    echo "Dropped database\n";
    
    $pdo->exec("CREATE DATABASE interview_prep CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Created database\n";
    
    echo "SUCCESS\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
