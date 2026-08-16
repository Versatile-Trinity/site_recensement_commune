<?php
session_start();
if (empty($_SESSION['citoyen_id'])) {
    header('Location: connexion.php');
    exit;
}
require __DIR__ . '/php/config.php';
$requete = $pdo->prepare("SELECT * FROM citoyen WHERE id = ?");
$requete->execute([$_SESSION['citoyen_id']]);
$citoyen = $requete->fetch();

$etiquettes = [
    'en_attente' => 'En attente de validation',
    'valide'     => 'Validé',
    'rejete'     => 'Rejeté',
];

$initiales = mb_strtoupper(mb_substr($citoyen['nom'], 0, 1) . mb_substr($citoyen['prenom'] ?? '', 0, 1));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Citoyen - Recensement Antananarivo</title>
    <link rel="stylesheet" href="CSS/style_commun.css">
    <link rel="stylesheet" href="CSS/style_espace.css">
</head>
<body>
    <div class="barre-utilitaire">
        <a href="php/deconnexion.php" class="bouton-mini bouton-deconnexion">Se déconnecter</a>
    </div>

    <header class="entete-profil">
        <div class="avatar-citoyen"><?= htmlspecialchars($initiales) ?></div>
        <div class="info-profil">
            <h1><?= htmlspecialchars($citoyen['nom']) ?> <?= htmlspecialchars($citoyen['prenom'] ?? '') ?></h1>
            <span class="badge-statut badge-<?= $citoyen['statut'] ?>"><?= $etiquettes[$citoyen['statut']] ?></span>
        </div>
    </header>

    <main>
        <div class="boite-sombre">
            <h2>Mon dossier</h2>

            <dl class="liste-infos">
                <div class="ligne-info">
                    <dt>Nom</dt>
                    <dd><?= htmlspecialchars($citoyen['nom']) ?></dd>
                </div>
                <div class="ligne-info">
                    <dt>Prénom(s)</dt>
                    <dd><?= htmlspecialchars($citoyen['prenom'] ?: '—') ?></dd>
                </div>
                <div class="ligne-info">
                    <dt>Date de naissance</dt>
                    <dd><?= htmlspecialchars($citoyen['date_naissance']) ?></dd>
                </div>
                <div class="ligne-info">
                    <dt>N° de copie</dt>
                    <dd><?= htmlspecialchars($citoyen['numero_copie']) ?></dd>
                </div>
            </dl>
        </div>
    </main>
</body>
</html>