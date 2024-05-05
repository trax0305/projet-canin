<?php

require_once 'connectionclass.php';

class Animal {
    public $connexion;
    public $id;
    public $name;
    public $breed;
    public $age;
    public $weight;
    public $height;
    public $comment;
    public $is_actif;
    public $customer_id;

    function __construct($animal_bdd = NULL) {
        $this->connexion = new Connexion();
        if ($animal_bdd !== NULL) {
            $this->id = $animal_bdd['id'];
            $this->name = $animal_bdd['name'];
            $this->breed = $animal_bdd['breed'];
            $this->age = $animal_bdd['age'];
            $this->weight = $animal_bdd['weight'];
            $this->height = $animal_bdd['height'];
            $this->comment = $animal_bdd['comment'];
            $this->is_actif = $animal_bdd['is_actif'];
            $this->customer_id = $animal_bdd['customer_id'];
        }
    }

    public function countTotalAnimal() {
        // Récupérez la connexion PDO depuis la classe Connexion
        $pdo = $this->connexion->getPDO();

        // Requête SQL pour compter le nombre total de lignes dans la table customer
        $sql = "SELECT COUNT(*) AS total_animals FROM animals";

        // Exécution de la requête
        $stmt = $pdo->query($sql);

        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourne le nombre total d'animaux
        return $result['total_animals'];
    }

    public function searchAnimal($searchData) {
        // Validate and sanitize user input
        $searchTerm = '%' . $searchData['search'] . '%';

        // Utilisez des requêtes préparées pour éviter les attaques par injection SQL
        $searchQuery = "SELECT c.*, a.*
                        FROM customers c
                        LEFT JOIN animals a ON c.id = a.customer_id
                        WHERE a.name LIKE :searchTerm";

        $stmt = $this->connexion->getPDO()->prepare($searchQuery);
        $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        $results = array(); // Initialisez un tableau pour stocker les résultats

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = array('customer' => $row);
        }

        return $results; // Retourne les résultats
    }

    public function updateAnimalAjax($customerId, $newData) {
        // Utilisez des requêtes préparées pour éviter les attaques par injection SQL
        $updateQuery = "UPDATE animals SET `name` = ?, breed = ? WHERE customer_id = ?";
        $stmt = $this->connexion->getPDO()->prepare($updateQuery);

        // Vérifiez si la requête a réussi
        if ($stmt->execute([$newData['name'], $newData['breed'], $customerId])) {
            return true; // La mise à jour a réussi
        } else {
            return false; // La mise à jour a échoué
        }
    }

    public function insertAnimal($formData, $customerId) {
        // Récupérer les données du formulaire pour l'animal
        $namedog = $formData["nameDog"];
        $race = $formData["race"];
        $age = $formData["age"];
        $poids = $formData["poids"];
        $taille = $formData["taille"];
        $commentairedog = $formData["commentairedog"];
        $is_actif = $formData["is_actif"];

        // Préparez et exécutez la requête d'insertion pour l'animal avec la clé étrangère
        $insertAnimalQuery = "INSERT INTO animals (`name`, `breed`, `age`, `weight`, `height`, `comment`, `customer_id`, `is_actif`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connexion->getPDO()->prepare($insertAnimalQuery);
        $stmt->execute([$namedog, $race, $age, $poids, $taille, $commentairedog, $customerId, $is_actif]);

        return $stmt->rowCount() > 0;
    }

    public function getAll() {
        $query = "SELECT * FROM animals";
        $stmt = $this->connexion->getPDO()->query($query);
        $animals = [];

        while ($animal_bdd = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $animals[] = new Animal($animal_bdd);
        }

        return $animals;
    }

    public function getBreedData() {
        $query = "SELECT breed, COUNT(*) as count FROM animals GROUP BY breed";
        $stmt = $this->connexion->getPDO()->query($query);
        $breedData = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $breedData[] = [
                'breed' => $data['breed'],
                'count' => $data['count'],
            ];
        }

        return $breedData;
    }

    public function getAgeData(){
        $query = "SELECT CASE WHEN age > 10 THEN 'Chien agé' WHEN age >= 5 AND age <= 10 THEN 'Entre 5 et 10 ans' WHEN age < 5 THEN '< 5 ans' END AS category_age, COUNT(*) AS number_animal_age FROM animals GROUP BY category_age";
        $stmt = $this->connexion->getPDO()->query($query);
        $ageData = [];

        while ($datage = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ageData[] = [
                'age' => $datage['number_animal_age'],
                'resu' => $datage['category_age'],
            ];
        }

        return $ageData;
    }

    public function getWeightData(){
        $query = "SELECT CASE WHEN weight > 30 AND weight < 50 THEN 'Poids normal' WHEN weight >= 50 THEN 'Poids élevé' WHEN weight <= 30 THEN 'Poids léger' END AS category_weight, COUNT(*) AS number_animal FROM animals GROUP BY category_weight";
        $stmt = $this->connexion->getPDO()->query($query);
        $weightData = [];

        while ($datweight = $stmt->fetch(PDO::FETCH_ASSOC)){
            $weightData[] = [
                'weight' => $datweight['number_animal'],
                'category' => $datweight['category_weight'],
            ];
        }

        return $weightData;
    }

    public function getAllAnimalsWithOwners() {
        $query = "SELECT a.*, c.firstname AS customer_firstname
                  FROM animals a
                  LEFT JOIN customers c ON a.customer_id = c.id";
        $stmt = $this->connexion->getPDO()->query($query);
    
        $animals = [];
    
        while ($animal_bdd = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $animals[] = $animal_bdd;
        }
    
        return $animals;
    }
    
    public function getAnimalByCustomerId($customer_id) {
        $query = "SELECT * FROM animals WHERE customer_id = :customer_id";
        $stmt = $this->connexion->getPDO()->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        $animals = [];

        while ($animal_bdd = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $animals[] = new Animal($animal_bdd);
        }

        return $animals;
    }

    public function getAnimalById($animal_id) {
        $query = "SELECT * FROM animals WHERE id = :animal_id";
        $stmt = $this->connexion->getPDO()->prepare($query);
        $stmt->bindParam(':animal_id', $animal_id, PDO::PARAM_INT);
        $stmt->execute();

        $animal_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($animal_data) {
            return new Animal($animal_data);
        } else {
            return null;
        }
    }

    public function updateAnimal($formData) {
        // Assurez-vous que l'ID de l'animal est inclus dans les données du formulaire
        $animalId = isset($formData['id']) ? $formData['id'] : null;
    
        // Vérifiez si l'ID de l'animal est défini avant de procéder à la mise à jour
        if ($animalId) {
            // Récupération des données du formulaire
            $name = $formData['name'];
            $breed = $formData['breed'];
            $age = $formData['age'];
            $weight = $formData['weight'];
            $height = $formData['height'];
            $comment = $formData['comment'];
            $is_actif = $formData['is_actif'];
    
            // Préparation de la requête
            $updateQuery = "UPDATE animals SET `name` = :name, `breed` = :breed, `age` = :age, `weight` = :weight, `height` = :height, `comment` = :comment, `is_actif` = :is_actif WHERE id = :id";
            $stmt = $this->connexion->getPDO()->prepare($updateQuery);
    
            // Liaison des paramètres
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':breed', $breed, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
            $stmt->bindParam(':height', $height, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':is_actif', $is_actif, PDO::PARAM_INT);
            $stmt->bindParam(':id', $animalId, PDO::PARAM_INT);
    
            // Exécution de la requête
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            // Gérer le cas où l'ID de l'animal n'est pas défini
            return false;
        }
    }
}
?>
