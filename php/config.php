<?php
require __DIR__ . '/../vendor/autoload.php';

$hote = '127.0.0.1';
$base = 'recensement_citoyen_bd';
$utilisateur = 'root';
$motdepasse = '';

try {
    $pdo = new PDO(
        "mysql:host=$hote;dbname=$base;charset=utf8mb4",
        $utilisateur,
        $motdepasse,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}