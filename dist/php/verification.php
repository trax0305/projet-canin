<?php
// Vérifier la connexion
if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}
// Vérifiez si l'utilisateur est connecté en vérifiant la session
session_start();
define("BASE_URL", "/"); // Remplacez "/votre_site" par le chemin réel de votre site
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location:http://localhost:8000/login.php");
    exit;
}
// Le nom d'utilisateur est stocké dans $_SESSION["username"]
$nomUtilisateur = $_SESSION["username"];
?>