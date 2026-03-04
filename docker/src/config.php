<?php
// ===============================
// Configuration de la base de données
// ===============================
define('DB_HOST', 'my_mysql');
define('DB_USER', 'user');
define('DB_PASS', 'password');
define('DB_NAME', 'db');

// ===============================
// Connexion à la base de données (PDO)
// ===============================
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// ===============================
// Demarrage de la session
// ===============================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}