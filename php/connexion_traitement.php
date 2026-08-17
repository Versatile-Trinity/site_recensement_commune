<?php
session_start();
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../connexion.php');
    exit;
}

$profil       = $_POST['profil'] ?? 'citoyen';
$identifiant  = trim($_POST['identifiant'] ?? '');
$motDePasse   = $_POST['mot_de_passe'] ?? '';

if ($profil === 'admin') {
    $requete = $pdo->prepare("SELECT * FROM administrateur WHERE identifiant = ?");
    $requete->execute([$identifiant]);
    $compte = $requete->fetch();

    if ($compte && password_verify($motDePasse, $compte['mot_de_passe'])) {
        $_SESSION['admin_id'] = $compte['id'];
        header('Location: ../espace_admin.php');
        exit;
    }
} else {
    $requete = $pdo->prepare("SELECT * FROM citoyen WHERE numero_copie = ?");
    $requete->execute([$identifiant]);
    $compte = $requete->fetch();

    if ($compte && password_verify($motDePasse, $compte['mot_de_passe'])) {
        if ($compte['statut'] !== 'valide') {
            $_SESSION['erreur_connexion'] = "Votre dossier est encore en attente de validation par un agent communal.";
            header('Location: ../connexion.php');
            exit;
        }
        $_SESSION['citoyen_id'] = $compte['id'];
        header('Location: ../espace_citoyen.php');
        exit;
    }
}

$_SESSION['erreur_connexion'] = "Identifiant ou mot de passe incorrect.";
header('Location: ../connexion.php');
exit;