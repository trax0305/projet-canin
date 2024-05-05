<?php

require_once 'connectionclass.php';

class Capabilities {
    public $user_id;
    public $service_id;
    private $connexion;

    function __construct($capabilities_bdd = NULL){
        $this->connexion = new Connexion();
        if ($capabilities_bdd !== NULL){
            $this->user_id = $capabilities_bdd['user_id'];
            $this->service_id = $capabilities_bdd['service_id'];
        }
    }

    public function getAll(){
        try {
            // Assurez-vous que $this->connexion->getPDO() n'est pas null
            if (!$this->connexion->getPDO()) {
                throw new PDOException("La connexion PDO est null.");
            }

            $query = "SELECT users.firstname AS nom_utilisateur, services.name AS nom_service 
                      FROM capabilities 
                      JOIN users ON capabilities.user_id = users.id 
                      JOIN services ON capabilities.service_id = services.id";

            $stmt = $this->connexion->getPDO()->query($query);

            // Récupération des résultats sous forme d'objets
            $capabilities_result = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $capabilities_result;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
?>

