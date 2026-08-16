<?php
session_start();
$erreurs = $_SESSION['erreurs_inscription'] ?? [];
$anciennes = $_SESSION['anciennes_valeurs'] ?? [];
unset($_SESSION['erreurs_inscription'], $_SESSION['anciennes_valeurs']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'inscription - Recensement Antananarivo</title>
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
        <div class="boite-sombre inscription-container">
            <h2>Demande d'inscription</h2>
            <p class="sous-titre">Remplissez ce formulaire pour soumettre votre demande. Un agent communal validera ensuite votre dossier.</p>

            <?php if (!empty($erreurs)): ?>
                <div class="message-erreur-liste">
                    <ul>
                        <?php foreach ($erreurs as $erreur): ?>
                            <li><?= htmlspecialchars($erreur) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="formInscription" action="php/inscription_traitement.php" method="POST" onsubmit="return verifierMotsDePasse();">

                <fieldset class="groupe-formulaire">
                    <legend>Identité civile</legend>
                    <div class="grille-champs">
                        <div class="champ">
                            <label for="nom">Nom <span class="obligatoire">*</span></label>
                            <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?= htmlspecialchars($anciennes['nom'] ?? '') ?>" required>
                        </div>
                        <div class="champ">
                            <label for="prenom">Prénom(s)</label>
                            <input type="text" id="prenom" name="prenom" placeholder="Vos prénoms" value="<?= htmlspecialchars($anciennes['prenom'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="grille-champs">
                        <div class="champ">
                            <label for="date-naissance">Date de naissance <span class="obligatoire">*</span></label>
                            <input type="date" id="date-naissance" name="date_naissance" value="<?= htmlspecialchars($anciennes['date_naissance'] ?? '') ?>" required>
                        </div>
                        <div class="champ">
                            <label for="numero-copie">N° de copie (acte / CIN) <span class="obligatoire">*</span></label>
                            <input type="text" id="numero-copie" name="numero_copie" placeholder="Ex : 101-2005-00456" value="<?= htmlspecialchars($anciennes['numero_copie'] ?? '') ?>" required>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="groupe-formulaire">
                    <legend>Sécurité du compte</legend>
                    <div class="grille-champs">
                        <div class="champ">
                            <label for="mdp">Mot de passe <span class="obligatoire">*</span></label>
                            <input type="password" id="mdp" name="mot_de_passe" minlength="6" required>
                        </div>
                        <div class="champ">
                            <label for="mdp-confirm">Confirmation <span class="obligatoire">*</span></label>
                            <input type="password" id="mdp-confirm" name="mot_de_passe_confirmation" minlength="6" required>
                        </div>
                    </div>
                </fieldset>

                <p class="message-erreur" id="erreur-mdp"></p>

                <button type="submit" class="bouton-action bouton-pleine-largeur">Soumettre ma demande</button>
            </form>

            <div class="pied-connexion">
                <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
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
        function verifierMotsDePasse(){
            const mdp = document.getElementById('mdp').value;
            const confirmation = document.getElementById('mdp-confirm').value;
            const erreur = document.getElementById('erreur-mdp');
            if(mdp !== confirmation){
                erreur.textContent = "Les mots de passe ne correspondent pas.";
                return false;
            }
            erreur.textContent = "";
            return true;
        }
    </script>
</body>
</html>