<?php
require_once '../../dist/php/connectionclass.php';
$connexion = new Connexion();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["animal_id"])) {
    $animalId = $_POST["animal_id"];

    try {
        // Utiliser une requête préparée pour éviter les injections SQL
        $stmt = $connexion->getPDO()->prepare("UPDATE animals SET is_actif = 0 WHERE id = :animalId");
        $stmt->bindParam(":animalId", $animalId, PDO::PARAM_INT);
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

