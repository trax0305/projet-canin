<?php
//session_start();
require_once 'connectionclass.php';
require_once 'capabilitiesclass.php';
require_once 'servicesclass.php';

$capa = new Capabilities();
$capabilites = $capa->getAll();
$service = new Services();
$service_test = $service->getAll();

class User {

    public $id;
    public $idisadmin;
    public $firstname;
    public $lastname;
    public $telephone;
    public $password;
    public $email;
    public $address;
    public $zip;
    public $connexion;

    function __construct($user_bdd = NULL) {
        $this->connexion = new Connexion();
        if ($user_bdd !== NULL) {
            $this->id = $user_bdd["id"];
            $this->idisadmin = $user_bdd["is_admin"];
            $this->firstname = $user_bdd["firstname"];
            $this->lastname = $user_bdd["lastname"];
            $this->telephone = $user_bdd["telephone"];
            $this->password = $user_bdd["password"];
            $this->email = $user_bdd["mail"];
            $this->address = $user_bdd["postal_adress"];
            $this->zip = $user_bdd["zip"];
        }
    }

    public function authenticateUser($username, $password) {
        try {
            $requete = $this->connexion->getPDO()->prepare("SELECT * FROM users WHERE firstname = :firstname AND mdp = :mdp");
            $requete->bindParam(':firstname', $username);
            $requete->bindParam(':mdp', $password);
            $requete->execute();

            if ($requete->rowCount() == 1) {
                $_SESSION["isLoggedIn"] = true;
                $_SESSION["username"] = $username;
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public function getAll() {
        $users_result = $this->connexion->getPDO()->query("SELECT * FROM users;");
        $users = [];
        while ($user_bdd = $users_result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($user_bdd);
        }
        return $users;
    }

    public function getByID($id) {
        $user_bdd = $this->connexion->getPDO()->query("SELECT * FROM users WHERE id = $id ;");
        if ($user_bdd) {
            return new User($user_bdd->fetch(PDO::FETCH_ASSOC));
        } else {
            return null;
        }
    }

    public function CanDoCapabilities($user_id) {
        $verif = $this->connexion->getPDO()->query("SELECT service_id FROM capabilities WHERE user_id = $user_id;");
        if ($verif) {
            $services = [
                'toilettage' => false,
                'découpage' => false,
                'vaccination' => false,
                'shampoing' => false,
            ];
            while ($row = $verif->fetch(PDO::FETCH_ASSOC)) {
                $service_id = $row['service_id'];
                $get_name_service = $this->connexion->getPDO()->query("SELECT name FROM services WHERE id = $service_id;");
                if ($get_name_service) {
                    $service_name_row = $get_name_service->fetch(PDO::FETCH_ASSOC);
                    $service_name = $service_name_row['name'];
                    if (isset($services[$service_name])) {
                        $services[$service_name] = true;
                    }
                }
            }
        }
        return ($services);
    }

    public function updateCapabilities($user_id, $selected_services) {
        // // Supprimez d'abord toutes les entrées existantes pour cet utilisateur
        // $delete_query = $this->connexion->getPDO()->prepare("DELETE FROM capabilities WHERE user_id = :user_id");
        // $delete_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        // $delete_query->execute();
        
        // Insérez ensuite les nouvelles entrées pour les services sélectionnés
        $insert_query = $this->connexion->getPDO()->prepare("INSERT INTO capabilities (user_id, service_id) VALUES (:user_id, :service_id)");
        $insert_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $insert_query->bindParam(':service_id', $service_id, PDO::PARAM_INT);
        
        foreach ($selected_services as $service_id) {
            $insert_query->execute();
        }
    }


    public function getAllServices() {
        $service_names = [];
        $getName = $this->connexion->getPDO()->query("SELECT name FROM services ;");
        if ($getName) {
            while ($row = $getName->fetch(PDO::FETCH_ASSOC)) {
                $service_names[] = $row['name'];
            }
        }
        return $service_names;
    }

    public function insertUser($formData) {
        $lastname = $this->sanitizeInput($formData['inputName']);
        $firstname = $this->sanitizeInput($formData['inputPrénom']);
        $email = $this->sanitizeInput($formData['inputEmail']);
        $telephone = $this->sanitizeInput($formData['inputTelephone']);
        $address = $this->sanitizeInput($formData['inputAdress']);
        $admin = $this->sanitizeInput($formData['inputAdmin']);
        $password = $this->sanitizeInput($formData['inputPassword']);
        $service = $this->sanitizeInput($formData['activite']);

        if (empty($lastname) || empty($firstname)) {
            return false;
        }

        $insertUserQuery = $this->connexion->getPDO()->prepare("INSERT INTO users (`is_admin`, `firstname`, `lastname`, `telephone`, `mail`, `postal_adress`, `mdp`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertUserQuery->bindParam(1, $admin, PDO::PARAM_INT);
        $insertUserQuery->bindParam(2, $firstname, PDO::PARAM_STR);
        $insertUserQuery->bindParam(3, $lastname, PDO::PARAM_STR);
        $insertUserQuery->bindParam(4, $telephone, PDO::PARAM_STR);
        $insertUserQuery->bindParam(5, $email, PDO::PARAM_STR);
        $insertUserQuery->bindParam(6, $address, PDO::PARAM_STR);
        $insertUserQuery->bindParam(7, $password, PDO::PARAM_STR);

        if ($insertUserQuery->execute()) {
            $user_id = $this->connexion->getPDO()->lastInsertId();

            $insertActiviteQuery = $this->connexion->getPDO()->prepare("INSERT INTO capabilities (`user_id`, `service_id`) VALUES (?, ?)");
            $insertActiviteQuery->bindParam(1, $user_id, PDO::PARAM_INT);
            $insertActiviteQuery->bindParam(2, $service, PDO::PARAM_INT);

            if ($insertActiviteQuery->execute()) {
                return $user_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteUser($formData) {
        $id = $this->sanitizeInput($formData['user_id']);

        $delete = $this->connexion->getPDO()->prepare("DELETE FROM users WHERE id = ?");
        $delete->bindParam(1, $id, PDO::PARAM_INT);

        if ($delete->execute()) {
            return $id;
        } else {
            return false;
        }
    }

    public function updateUser($formData) {
        $lastname = $this->sanitizeInput($formData['inputName']);
        $firstname = $this->sanitizeInput($formData['inputPrénom']);
        $email = $this->sanitizeInput($formData['inputEmail']);
        $telephone = $this->sanitizeInput($formData['inputTelephone']);
        $address = $this->sanitizeInput($formData['inputAdress']);

        if (empty($lastname) || empty($firstname)) {
            return false;
        }

        $updateUserQuery = $this->connexion->getPDO()->prepare("UPDATE users SET firstname = ?, lastname = ?, mail = ?, telephone = ?, postal_adress = ? WHERE lastname = ?");
        $updateUserQuery->bindParam(1, $firstname, PDO::PARAM_STR);
        $updateUserQuery->bindParam(2, $lastname, PDO::PARAM_STR);
        $updateUserQuery->bindParam(3, $email, PDO::PARAM_STR);
        $updateUserQuery->bindParam(4, $telephone, PDO::PARAM_STR);
        $updateUserQuery->bindParam(5, $address, PDO::PARAM_STR);
        $updateUserQuery->bindParam(6, $lastname, PDO::PARAM_STR);

        $result = $updateUserQuery->execute();

        if ($result) {
            echo "Mise à jour réussie!";
        } else {
            echo "Erreur lors de la mise à jour: " . implode(", ", $updateUserQuery->errorInfo());
        }

        $updateUserQuery->closeCursor();

        return $result;
    }

    private function sanitizeInput($input) {
        return $input;
    }

}
?>
