<?php
session_start();
require_once __DIR__ . '/../../config.php'; 
require_once __DIR__ . '/../../classes/Admin.php';

if (!isset($mysqlClient)) {
    die("Erreur : connexion à la base de données non établie.");
}

$admin = new Admin($mysqlClient);

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    echo "Accès refusé.";
    exit;
}
?>
