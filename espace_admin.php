<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: connexion.php');
    exit;
}
require __DIR__ . '/php/config.php';

$requeteAdmin = $pdo->prepare("SELECT * FROM administrateur WHERE id = ?");
$requeteAdmin->execute([$_SESSION['admin_id']]);
$admin = $requeteAdmin->fetch();

$dossiers = $pdo->query("SELECT * FROM citoyen ORDER BY FIELD(statut,'en_attente','valide','rejete'), date_creation DESC")->fetchAll();

$etiquettes = [
    'en_attente' => 'En attente',
    'valide'     => 'Validé',
    'rejete'     => 'Rejeté',
];

$compteurs = ['en_attente' => 0, 'valide' => 0, 'rejete' => 0];
foreach ($dossiers as $d) { $compteurs[$d['statut']]++; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Admin - Recensement Antananarivo</title>
    <link rel="stylesheet" href="CSS/style_commun.css">
    <link rel="stylesheet" href="CSS/style_espace.css">
</head>
<body>
    <div class="barre-utilitaire">
        <a href="php/deconnexion.php" class="bouton-mini bouton-deconnexion">Se déconnecter</a>
    </div>

    <header class="entete-profil">
        <div class="avatar-citoyen avatar-admin">🛡️</div>
        <div class="info-profil">
            <h1>Espace Administrateur</h1>
            <span class="badge-statut badge-info">Connecté : <?= htmlspecialchars($admin['nom_complet'] ?: $admin['identifiant']) ?></span>
        </div>
    </header>

    <main>
        <div class="boite-sombre">
            <div class="entete-espace">
                <h2>Dossiers citoyens (<?= count($dossiers) ?>)</h2>
            </div>

            <div class="stats-admin">
                <div class="mini-stat mini-stat-en_attente">
                    <span class="mini-stat-nombre"><?= $compteurs['en_attente'] ?></span>
                    <span class="mini-stat-libelle">En attente</span>
                </div>
                <div class="mini-stat mini-stat-valide">
                    <span class="mini-stat-nombre"><?= $compteurs['valide'] ?></span>
                    <span class="mini-stat-libelle">Validés</span>
                </div>
                <div class="mini-stat mini-stat-rejete">
                    <span class="mini-stat-nombre"><?= $compteurs['rejete'] ?></span>
                    <span class="mini-stat-libelle">Rejetés</span>
                </div>
            </div>

            <?php if (empty($dossiers)): ?>
                <p>Aucun dossier pour le moment.</p>
            <?php else: ?>
                <table class="tableau-dossiers">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom(s)</th>
                            <th>Date de naissance</th>
                            <th>N° de copie</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dossiers as $d): ?>
                        <tr>
                            <td><?= htmlspecialchars($d['nom']) ?></td>
                            <td><?= htmlspecialchars($d['prenom'] ?? '') ?></td>
                            <td><?= htmlspecialchars($d['date_naissance']) ?></td>
                            <td><?= htmlspecialchars($d['numero_copie']) ?></td>
                            <td><span class="badge-statut badge-<?= $d['statut'] ?>"><?= $etiquettes[$d['statut']] ?></span></td>
                            <td class="actions-dossier">
                                <?php if ($d['statut'] !== 'valide'): ?>
                                <form method="POST" action="php/admin_statut.php">
                                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                    <input type="hidden" name="action" value="valide">
                                    <button type="submit" class="bouton-mini bouton-valider">Valider</button>
                                </form>
                                <?php endif; ?>
                                <?php if ($d['statut'] !== 'rejete'): ?>
                                <form method="POST" action="php/admin_statut.php" onsubmit="return confirm('Confirmer le rejet de ce dossier ?');">
                                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                    <input type="hidden" name="action" value="rejete">
                                    <button type="submit" class="bouton-mini bouton-rejeter">Rejeter</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>