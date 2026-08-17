<?php
session_start();
require __DIR__ . '/config.php';

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../connexion_inscription.php');
    exit;
}

$nom            = trim($_POST['nom'] ?? '');
$prenom         = trim($_POST['prenom'] ?? '');
$dateNaissance  = trim($_POST['date_naissance'] ?? '');
$numeroCopie    = trim($_POST['numero_copie'] ?? '');
$motDePasse     = $_POST['mot_de_passe'] ?? '';
$confirmation   = $_POST['mot_de_passe_confirmation'] ?? '';

 // dump($_POST); // <- décommente pour inspecter les données reçues pendant les tests

$validateur = Validation::createValidator();
$erreurs = [];

$verifier = function ($valeur, array $contraintes) use ($validateur, &$erreurs) {
    foreach ($validateur->validate($valeur, $contraintes) as $violation) {
        $erreurs[] = $violation->getMessage();
    }
};

$verifier($nom, [new Assert\NotBlank(message: "Le nom est obligatoire.")]);
$verifier($dateNaissance, [new Assert\NotBlank(message: "La date de naissance est obligatoire.")]);
$verifier($numeroCopie, [new Assert\NotBlank(message: "Le numéro de copie est obligatoire.")]);
$verifier($motDePasse, [new Assert\Length(min: 6, minMessage: "Le mot de passe doit contenir au moins 6 caractères.")]);

if ($motDePasse !== $confirmation) {
    $erreurs[] = "Les mots de passe ne correspondent pas.";
}

if (empty($erreurs) && $numeroCopie !== '') {
    $verif = $pdo->prepare("SELECT id FROM citoyen WHERE numero_copie = ?");
    $verif->execute([$numeroCopie]);
    if ($verif->fetch()) {
        $erreurs[] = "Ce numéro de copie est déjà enregistré.";
    }
}

if (!empty($erreurs)) {
    $_SESSION['erreurs_inscription'] = $erreurs;
    $_SESSION['anciennes_valeurs'] = [
        'nom' => $nom,
        'prenom' => $prenom,
        'date_naissance' => $dateNaissance,
        'numero_copie' => $numeroCopie,
    ];
    header('Location: ../connexion_inscription.php');
    exit;
}

$hash = password_hash($motDePasse, PASSWORD_DEFAULT);

$insertion = $pdo->prepare(
    "INSERT INTO citoyen (nom, prenom, date_naissance, numero_copie, mot_de_passe, statut)
     VALUES (?, ?, ?, ?, ?, 'en_attente')"
);
$insertion->execute([$nom, $prenom, $dateNaissance, $numeroCopie, $hash]);

$_SESSION['succes_inscription'] = "Votre demande a été envoyée. Un agent communal doit valider votre dossier avant que vous puissiez vous connecter.";
header('Location: ../connexion.php');
exit;