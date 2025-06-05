<?php
require 'config.php';

// Connexion sans base pour la créer d'abord
try {
    
    $pdo->exec("USE ‘taregirk-test_db‘");

    // Créer la table
    $sql = "CREATE TABLE IF NOT EXISTS podcasts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        url TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";

    $pdo->exec($sql);
    echo "Table 'podcasts' créée avec succès ou déjà existante.\n";

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
