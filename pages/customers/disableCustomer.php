<?php
require_once '../../dist/php/connectionclass.php';
$connexion = new Connexion();
// Assurez-vous que l'utilisateur est authentifié ou a les autorisations nécessaires ici

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customerId = $_POST["customer_id"];

    try {
        // Utiliser une requête préparée pour éviter les injections SQL
        $stmt = $connexion->getPDO()->prepare("UPDATE customers SET is_actif = 0 WHERE id = :customerId");
        $stmt->bindParam(":customerId", $customerId, PDO::PARAM_INT);
        $stmt->execute();

        echo "success";
    } catch (PDOException $e) {
        echo "error";
    } finally {
        // Fermer la connexion
        $stmt = null;
    }
}
?>
