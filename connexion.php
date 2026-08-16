<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Recensement Antananarivo</title>
    <link rel="stylesheet" href="CSS/style_commun.css">
    <link rel="stylesheet" href="CSS/style_connexion.css">
</head>
<body>
    <header>
        <img src="Photos/Logos/lemur.png" class="logomaki" alt="Lémurien, symbole de Madagascar" title="Maki">
        <h1>Enregistrement Citoyen pour la commune d'Antananarivo</h1>
    </header>

    <nav class="barre">
        <a href="acceuil.html"><span class="icone" aria-hidden="true">🏠</span>Accueil</a>
        <a href="connexion.php" class="actif"><span class="icone" aria-hidden="true">🔐</span>Connexion/Inscription</a>
        <a href="data_visualisation.php"><span class="icone" aria-hidden="true">📊</span>Data Visualisation</a>
        <a href="acceuil.html#listecontact"><span class="icone" aria-hidden="true">✉️</span>Contacts</a>
        <a href="information.html"><span class="icone" aria-hidden="true">ℹ️</span>S'informer</a>
        <a href="acceuil.html#legalsecurite"><span class="icone" aria-hidden="true">⚖️</span>Légal &amp; Sécurité</a>
    </nav>

    <main>
        <div class="boite-sombre login-container">
            <h2>Connexion</h2>
            <p class="sous-titre">Accédez à votre espace sécurisé</p>

            <?php if (!empty($_SESSION['succes_inscription'])): ?>
                <p class="message-succes"><?= htmlspecialchars($_SESSION['succes_inscription']) ?></p>
                <?php unset($_SESSION['succes_inscription']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['erreur_connexion'])): ?>
                <p class="message-erreur-liste"><?= htmlspecialchars($_SESSION['erreur_connexion']) ?></p>
                <?php unset($_SESSION['erreur_connexion']); ?>
            <?php endif; ?>

            <div class="onglets">
                <button type="button" class="onglet-btn actif" id="onglet-citoyen" onclick="afficherFormulaire('citoyen')">Citoyen</button>
                <button type="button" class="onglet-btn" id="onglet-admin" onclick="afficherFormulaire('admin')">Admin</button>
            </div>

            <form id="formCitoyen" action="php/connexion_traitement.php" method="POST">
                <input type="hidden" name="profil" value="citoyen">
                <div class="champ">
                    <label for="id-citoyen">Identifiant / Numéro de copie</label>
                    <input type="text" id="id-citoyen" name="identifiant" required>
                </div>
                <div class="champ">
                    <label for="mdp-citoyen">Mot de passe</label>
                    <input type="password" id="mdp-citoyen" name="mot_de_passe" required>
                </div>
                <button type="submit" class="bouton-action bouton-pleine-largeur">Se connecter</button>
            </form>

            <form id="formAdmin" action="php/connexion_traitement.php" method="POST" style="display:none;">
                <input type="hidden" name="profil" value="admin">
                <div class="champ">
                    <label for="id-admin">Identifiant administrateur</label>
                    <input type="text" id="id-admin" name="identifiant" required>
                </div>
                <div class="champ">
                    <label for="mdp-admin">Mot de passe</label>
                    <input type="password" id="mdp-admin" name="mot_de_passe" required>
                </div>
                <button type="submit" class="bouton-action bouton-pleine-largeur">Se connecter</button>
            </form>

            <div class="pied-connexion">
                <p><a href="#">Mot de passe oublié ?</a></p>
                <p>Pas encore inscrit ? <a href="connexion_inscription.php">Créer un compte</a></p>
            </div>
        </div>

        <a href="acceuil.html" class="retour-accueil">&larr; Retour à l'accueil</a>
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

    <script>
        function afficherFormulaire(profil){
            const estCitoyen = profil === 'citoyen';
            document.getElementById('formCitoyen').style.display = estCitoyen ? 'block' : 'none';
            document.getElementById('formAdmin').style.display = estCitoyen ? 'none' : 'block';
            document.getElementById('onglet-citoyen').classList.toggle('actif', estCitoyen);
            document.getElementById('onglet-admin').classList.toggle('actif', !estCitoyen);
        }
    </script>
</body>
</html>