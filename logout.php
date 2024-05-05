<?php
// Détruisez la session pour déconnecter l'utilisateur
session_start();
session_destroy();
header("Location: login.php");
exit;
?>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <head>
        <title>Login form</title>
        <link rel="stylesheet" type="text/css" href="docs/assets/css/stylelogin.css">
        <body>
            <div class="loginbox">
            <img src="docs\assets\img\doglogo.png">
                <h1>Se connecter</h1>
                <form action="login.php" method="post">
                <p>Nom</p>
                    <input type="text" name="nom" id="nom" placeholder="Tapez votre nom" required>
                <p>Mot de passe</p>
                    <input type="password" name="mdp" id="mdp" placeholder="Tapez votre mot de passe" required>
                    <input type="submit" name="" value="Connexion"> </br>
            <?php
            // Afficher le message d'erreur s'il est défini
            if (isset($_GET['error']) && $_GET['error'] == '1') {
                echo '<p class="error-message">Nom d\'utilisateur ou mot de passe incorrect.</p>';
            }
            ?>
                <div class="mdpforget">
                    <a href="#">Mot de passe oublié ?</a><br>
                    <a href="#">Pas de compte ?</a><br>
                </div>
                </form>
            </div>
        </body>
    </head>
    
</body>
</html> -->