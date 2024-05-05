<?php
session_start();
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
        if($user_bdd !== NULL) {
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
        $serveur = "localhost";
        $dbname = "toilettage";
        $user = "root";
        $pass = "root";
 
        try {
            $connexion = new PDO("mysql:host=$serveur;dbname=$dbname", $user, $pass);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
            $requete = $connexion->prepare("SELECT * FROM users WHERE firstname = :firstname AND mdp = :mdp");
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
        $users_result = $this->connexion->conn->query("SELECT * FROM users;"); // résultat de la requête qui contient tous les users
        $users = [];
        while($user_bdd = mysqli_fetch_assoc($users_result)) {
            $users[] = new User($user_bdd);
        }
        return $users;
    }
 
    public function getByID($id) {
        $user_bdd = $this->connexion->conn->query("SELECT * FROM users WHERE id = $id ;"); // résultat de la requête qui contient tous les users
        if ($user_bdd) {
            // Retourne un tableau associatif des données de l'utilisateur
            return new User($user_bdd->fetch_assoc());
        } else {
            // Gérer les erreurs de requête ici
            return null;
        }
    }
 
    public function CanDoCapabilities($user_id){
        $verif = $this->connexion->conn->query("SELECT service_id FROM capabilities WHERE user_id = $user_id;");
        if ($verif) {
            $services=[
                // mettre à jour en fonction de la requête
                'toilettage'=> false,
                'découpage'=> false,
                'vaccination'=> false,
                'shampoing'=> false,
            ];
            while ($row = $verif->fetch_assoc()) {
                $service_id = $row['service_id'];
                $get_name_service = $this->connexion->conn->query("SELECT name FROM services WHERE id = $service_id;");
                if ($get_name_service) {
                    $service_name_row = $get_name_service->fetch_assoc();
                    $service_name = $service_name_row['name'];
                    if (isset($services[$service_name])) {
                        $services[$service_name] = true;
                    }
                }
                               
            }
           
        }
        return($services);
    }
 
    public function getAllServices(){
        $service_names = [];
        $getName = $this->connexion->conn->query("SELECT name FROM services ;");
        if ($getName) {
            while ($row = $getName->fetch_assoc()) {
                $service_names[] = $row['name'];
            }
        }
        return $service_names;
    }
   
 
    public function insertUser($formData){
        $lastname = $this->sanitizeInput($formData['inputName']);
        $firstname = $this->sanitizeInput($formData['inputPrénom']);
        $email = $this->sanitizeInput($formData['inputEmail']);
        $telephone = $this->sanitizeInput($formData['inputTelephone']);
        $address = $this->sanitizeInput($formData['inputAdress']);
        $admin = $this->sanitizeInput($formData['inputAdmin']);
        $password = $this->sanitizeInput($formData['inputPassword']);
        $service = $this->sanitizeInput($formData['activite']); // Utilisez 'activite' au lieu de 'inputActivite'
        if (empty($lastname) || empty($firstname)) {
            // Gérer l'erreur, afficher un message ou retourner une valeur appropriée
            return false;
        }
        // Utilisation d'une déclaration préparée pour éviter les injections SQL
        $insertUserQuery = $this->connexion->conn->prepare("INSERT INTO users (`is_admin`, `firstname`, `lastname`, `telephone`, `mail`, `postal_adress`, `mdp`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertUserQuery->bind_param("issssss", $admin, $firstname, $lastname, $telephone, $email, $address, $password);
   
        // Exécution de la requête pour insérer l'utilisateur
        if ($insertUserQuery->execute()) {
            // Récupérer l'ID du nouvel utilisateur inséré
           
            $user_id = $this->connexion->conn->insert_id;
   
            // Utilisation d'une autre déclaration préparée pour insérer la capacité (activité)
            $insertActiviteQuery = $this->connexion->conn->prepare("INSERT INTO capabilities (`user_id`, `service_id`) VALUES (?, ?)");
            $insertActiviteQuery->bind_param("ii", $user_id, $service);
   
            // Exécution de la requête pour insérer la capacité (activité)
            if ($insertActiviteQuery->execute()) {
                return $user_id; // Vous pouvez retourner l'ID de l'utilisateur ici
            } else {
                // Gérer l'erreur pour l'insertion de la capacité
                return false;
            }
        } else {
            // Gérer l'erreur pour l'insertion de l'utilisateur
            return false;
        }
    }
 
    public function deleteUser($formData){
        // Récupérer l'ID de l'utilisateur à supprimer
        $id = $this->sanitizeInput($formData['user_id']);
   
        // Préparer la requête de suppression avec une déclaration préparée
        $delete = $this->connexion->conn->prepare("DELETE FROM users WHERE id = ?");
       
        // Liaison des paramètres
        $delete->bind_param("i", $id);
        // Exécuter la requête
        if ($delete->execute()) {
            // Retourner l'ID de l'utilisateur supprimé
            return $id;
        } else {
            // Gérer l'erreur pour la suppression de l'utilisateur
            return false;
        }
    }
 
    public function updateUser($formData){
        $lastname = $this->sanitizeInput($formData['inputName']);
        $firstname = $this->sanitizeInput($formData['inputPrénom']);
        $email = $this->sanitizeInput($formData['inputEmail']);
        $telephone = $this->sanitizeInput($formData['inputTelephone']);
        $address = $this->sanitizeInput($formData['inputAdress']);
 
        if (empty($lastname) || empty($firstname)) {
            // Gérer l'erreur, afficher un message ou retourner une valeur appropriée
            return false;
        }
        $updateUserQuery = $this->connexion->conn->prepare("UPDATE users SET firstname = ?, lastname = ?, mail = ?, telephone = ?, postal_adress = ? WHERE lastname = ?");
        $updateUserQuery->bind_param("ssssss", $firstname, $lastname, $email, $telephone, $address, $lastname);
       
        $result = $updateUserQuery->execute();
 
    // Vérifiez si la mise à jour a réussi
        if ($result) {
            echo "Mise à jour réussie!";
        } else {
            echo "Erreur lors de la mise à jour: " . $updateUserQuery->error;
        }
 
    // Fermez la requête préparée
        $updateUserQuery->close();
 
        return $result; // Retournez le résultat de la mise à jour
    }
 
   
 
    private function sanitizeInput($input) {
        // Implement your input sanitization logic here
        // Example: $sanitizedInput = mysqli_real_escape_string($this->connexion->conn, $input);
        return $input;
    }
 
}
?>