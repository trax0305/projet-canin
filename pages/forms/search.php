<?php
$serveur = "localhost";
$user = "root";
$pass = "root";
$dbname = "toilettage";

$connexion = new mysqli($serveur, $user, $pass, $dbname);

if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $searchQuery = "SELECT * FROM customers WHERE mail LIKE '%$searchTerm%' OR lastname LIKE '%$searchTerm'";
    $result = $connexion->query($searchQuery);

    if ($result->num_rows > 0) {
        $clientData = $result->fetch_assoc();
        $customerId = $clientData['id'];
        $animalsQuery = "SELECT * FROM animals WHERE customer_id = $customerId";
        $animalsResult = $connexion->query($animalsQuery);

        if ($animalsResult->num_rows > 0) {
            $animalsData = $animalsResult->fetch_assoc();
        }
    }
}
?>