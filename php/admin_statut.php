<?php
session_start();
require __DIR__ . '/config.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../espace_admin.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

$statutsAutorises = ['valide', 'rejete', 'en_attente'];
if ($id > 0 && in_array($action, $statutsAutorises, true)) {
    $maj = $pdo->prepare("UPDATE citoyen SET statut = ? WHERE id = ?");
    $maj->execute([$action, $id]);
}

header('Location: ../espace_admin.php');
exit;