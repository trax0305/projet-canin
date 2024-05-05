<?php

// require_once 'include/session.php';
require_once 'connectionclass.php';

// Récupère les données de la table 'animals'
require_once 'animalsclass.php';

// Créer une instance de la classe animals
   $animalInstance = new Animal();

// Récupérer tous les clients
   $animals = $animalInstance->getAll();


// Inclure la classe Customer
require_once 'customerclass.php';

// ... (autres inclusions et code) ...

// Créer une instance de la classe Customer
$customerInstance = new Customer();

// Récupérer tous les clients
$customers = $customerInstance->getAll();



// Récupère les données de la table 'services'
require_once 'servicesclass.php';

// Créer une instance de la classe Services
$servicesInstance = new Services();

// Récupérer tous les services
$services = $servicesInstance->getAll();



// // Récupère les données de la table 'user'
// require_once 'userclass.php';

// // Créer une instance de la classe Services
// $userInstance = new User();

// // Récupérer tous les services
// $users = $userInstance->getAll();



class Appointment {
    public $id;
    public $date_start;
    public $date_end;
    public $is_paid;
    public $user_id;
    public $animal_id;
    public $service_id;
    public $connexion;

    public function __construct($appointment_bdd = NULL) {
        $this->connexion = new Connexion();
        if ($appointment_bdd !== NULL) {
            $this->id = $appointment_bdd['id'];
            $this->date_start = $appointment_bdd['date_start'];
            $this->date_end = $appointment_bdd['date_end'];
            $this->is_paid = $appointment_bdd['is_paid'];
            $this->user_id = $appointment_bdd['user_id'];
            $this->animal_id = $appointment_bdd['animal_id'];
            $this->service_id = $appointment_bdd['service_id'];
        }
    }
    
    public function sanitizeInput($input) {
        // Utiliser filter_var() pour nettoyer les données
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    public function insertAppointment($formData) {
        $start = $this->sanitizeInput($formData['start']);
        $end = $this->sanitizeInput($formData['end']);
        $isPaid = $this->sanitizeInput($formData['is_paid']);
        $userId = $this->sanitizeInput($formData['user_id']);
        $animalId = $this->sanitizeInput($formData['animal_id']);
        $serviceId = $this->sanitizeInput($formData['service_id']);
    
        $insertAppointmentQuery = "INSERT INTO appointments (`date_start`, `date_end`, `is_paid`, `user_id`, `animal_id`, `service_id`) 
                                  VALUES (:date_start, :date_end, :is_paid, :user_id, :animal_id, :service_id)";
    
        $stmt = $this->connexion->getPDO()->prepare($insertAppointmentQuery);
        $stmt->bindParam(':date_start', $start, PDO::PARAM_STR);
        $stmt->bindParam(':date_end', $end, PDO::PARAM_STR);
        $stmt->bindParam(':is_paid', $isPaid, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
        $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }

    public function getAll() {
        $appointments_result = mysqli_query($this->connexion->conn, "SELECT * FROM appointments;");
        if (!$appointments_result) {
            die("Database query failed.");
        }
        $appointments = [];
        while ($appointment_bdd = mysqli_fetch_assoc($appointments_result)) {
            $appointments[] = new Appointment($appointment_bdd);
        }
        return $appointments;
    }
    public function getUpcomingAppointmentsByAnimalId($animalId) {
        $currentDate = date('Y-m-d H:i:s');
        $query = "SELECT * FROM appointments WHERE animal_id = :animal_id AND date_start > :current_date";
        $stmt = $this->connexion->getPDO()->prepare($query);
        $stmt->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
        $stmt->bindParam(':current_date', $currentDate);
        $stmt->execute();
    
        $appointments = [];
    
        while ($appointment_bdd = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $appointments[] = new Appointment($appointment_bdd);
        }
    
        return $appointments;
    }
    
}
?>