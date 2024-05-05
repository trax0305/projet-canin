<?php

// récupération de la connexion
require_once 'connectionclass.php';

class Services {
    public $connexion;
    public $id;
    public $name;
    public $price;

    public function __construct($services_bdd = NULL) {
        $this->connexion = new Connexion();
        if ($services_bdd !== NULL) {
            $this->id = $services_bdd['id'];
            $this->name = $services_bdd['name'];
            $this->price = $services_bdd['price'];
        }
    }

    public function getAll() {
        try {
            // Assurez-vous que $this->connexion->getPDO() n'est pas null
            if (!$this->connexion->getPDO()) {
                throw new PDOException("La connexion PDO est null.");
            }

            $query = "SELECT * FROM services";
            $stmt = $this->connexion->getPDO()->query($query);

            // Récupération des résultats sous forme d'objets
            $services_result = $stmt->fetchAll(PDO::FETCH_OBJ);

            $services = [];
            foreach ($services_result as $service_bdd) {
                $services[] = new Services((array)$service_bdd);
            }

            return $services;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public function getName() {
        try {
            // Assurez-vous que $this->connexion->getPDO() n'est pas null
            if (!$this->connexion->getPDO()) {
                throw new PDOException("La connexion PDO est null.");
            }

            $query = "SELECT services.name AS nom_service, COUNT(*) AS number_service 
                      FROM services 
                      JOIN appointments ON appointments.service_id = services.id 
                      GROUP BY services.name";

            $stmt = $this->connexion->getPDO()->query($query);

            // Récupération des résultats sous forme d'objets
            $name_service_result = $stmt->fetchAll(PDO::FETCH_OBJ);

            $serv = [];
            foreach ($name_service_result as $name_service_bdd) {
                $serv[] = [
                    'name_service' => $name_service_bdd->nom_service,
                    'number_service' => $name_service_bdd->number_service,
                ];
            }

            return $serv;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
?>
