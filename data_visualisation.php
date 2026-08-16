<?php
require __DIR__ . '/php/config.php';

$totalCitoyens = (int) $pdo->query("SELECT COUNT(*) FROM citoyen WHERE statut = 'valide'")->fetchColumn();

$parJour = $pdo->query("
    SELECT DATE(date_creation) AS jour, COUNT(*) AS total
    FROM citoyen
    WHERE statut = 'valide'
    GROUP BY DATE(date_creation)
    ORDER BY jour ASC
")->fetchAll();

$cumul = 0;
$points = [];
foreach ($parJour as $ligne) {
    $cumul += (int) $ligne['total'];
    $points[] = ['date' => $ligne['jour'], 'total' => $cumul];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Visualisation - Recensement Antananarivo</title>
    <link rel="stylesheet" href="CSS/style_commun.css">
    <link rel="stylesheet" href="CSS/style_dataviz.css">
</head>
<body>
    <header>
        <img src="Photos/Logos/lemur.png" class="logomaki" alt="Lémurien, symbole de Madagascar" title="Maki">
        <h1>Enregistrement Citoyen pour la commune d'Antananarivo</h1>
    </header>

    <nav class="barre">
        <a href="acceuil.html"><span class="icone" aria-hidden="true">🏠</span>Accueil</a>
        <a href="connexion.php"><span class="icone" aria-hidden="true">🔐</span>Connexion/Inscription</a>
        <a href="data_visualisation.php" class="actif"><span class="icone" aria-hidden="true">📊</span>Data Visualisation</a>
        <a href="acceuil.html#listecontact"><span class="icone" aria-hidden="true">✉️</span>Contacts</a>
        <a href="information.html"><span class="icone" aria-hidden="true">ℹ️</span>S'informer</a>
        <a href="acceuil.html#legalsecurite"><span class="icone" aria-hidden="true">⚖️</span>Légal &amp; Sécurité</a>
    </nav>

    <main>
        <div class="boite-sombre boite-dataviz">
            <h2>Citoyens recensés</h2>
            <p class="sous-titre">Nombre de citoyens enregistrés dans la base de données communale.</p>

            <div class="total-citoyens">
                <span class="total-nombre"><?= $totalCitoyens ?></span>
                <span class="total-libelle">citoyens recensés</span>
            </div>
        </div>

        <div class="boite-sombre boite-dataviz boite-courbe">
            <h2>Évolution dans le temps</h2>

            <?php if (count($points) < 2): ?>
                <p class="sous-titre">Le graphique apparaîtra dès qu'il y aura des dossiers validés sur plusieurs jours différents.</p>
            <?php else:
                $largeur = 640; $hauteur = 220; $marge = 34;
                $n = count($points);
                $maxValeur = max(1, max(array_column($points, 'total')));
                $largeurUtile = $largeur - 2 * $marge;
                $hauteurUtile = $hauteur - 2 * $marge;

                $coords = [];
                foreach ($points as $i => $p) {
                    $x = $marge + ($i / ($n - 1)) * $largeurUtile;
                    $y = $marge + $hauteurUtile - ($p['total'] / $maxValeur) * $hauteurUtile;
                    $coords[] = [round($x, 1), round($y, 1)];
                }
                $pointsLigne = implode(' ', array_map(fn($c) => $c[0] . ',' . $c[1], $coords));
                $pointsAire = $pointsLigne . ' ' . ($largeur - $marge) . ',' . ($hauteur - $marge) . ' ' . $marge . ',' . ($hauteur - $marge);
            ?>
                <svg viewBox="0 0 <?= $largeur ?> <?= $hauteur ?>" class="graphique-courbe" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="degradeAire" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="var(--bleu-accent)" stop-opacity="0.35"/>
                            <stop offset="100%" stop-color="var(--bleu-accent)" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <polygon points="<?= $pointsAire ?>" fill="url(#degradeAire)"/>
                    <polyline points="<?= $pointsLigne ?>" fill="none" stroke="var(--bleu-accent-clair)" stroke-width="2.5"/>
                    <?php foreach ($coords as $i => $c): ?>
                        <circle cx="<?= $c[0] ?>" cy="<?= $c[1] ?>" r="4" fill="var(--bleu-accent-clair)">
                            <title><?= htmlspecialchars($points[$i]['date']) ?> : <?= $points[$i]['total'] ?> citoyens</title>
                        </circle>
                    <?php endforeach; ?>
                </svg>
                <div class="legende-courbe">
                    <span><?= htmlspecialchars($points[0]['date']) ?></span>
                    <span><?= htmlspecialchars($points[$n - 1]['date']) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="footer-top-bar"></div>
        <div class="footer-colonnes">
            <div class="colonne">
                <h3 id="listecontact">Nous contacter</h3>
                <ul>
                    <li><a href="tel:+261330567496">📞 +261 33 05 674 96</a></li>
                </ul>
            </div>
            <div class="colonne">
                <h3>Démarches &amp; Justificatifs</h3>
                <ul>
                    <li><a href="information.html#guide">Guide d'utilisation</a></li>
                </ul>
            </div>
            <div class="colonne" id="legalsecurite">
                <h3>Légal &amp; Sécurité</h3>
                <ul>
                    <li><a href="information.html#confidentialite">Protection des données privées</a></li>
                    <li><a href="information.html#mentions">Mentions légales</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bas">
            <p>&copy; 2026 Base de Données Communale - Antananarivo. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>