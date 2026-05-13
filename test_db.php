<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=interview_prep', 'root', '', [
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "Connexion MySQL OK\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables trouvees: " . implode(', ', $tables) . "\n";
} catch (PDOException $e) {
    echo "ERREUR: " . $e->getMessage() . "\n";
}
