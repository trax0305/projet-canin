<?php
// update_customer.php

require_once 'customerclass.php'; // Incluez votre classe Customer
require_once 'animalsclass.php'; // Incluez votre classe Animal

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = $_POST['customerId'];
    $customerData = [
        'lastname' => $_POST['lastname'],
        'firstname' => $_POST['firstname'],
        'mail' => $_POST['mail'],
    ];

    $animalData = [
        'name' => $_POST['name'],
        'breed' => $_POST['breed'],
    ];

    $customerInstance = new Customer();
    $animalInstance = new Animal();

    // Mettez à jour les informations du client
    $result = $customerInstance->updateCustomerAjax($customerId, $customerData);

    // Mettez à jour les informations de l'animal
    $animalResult = $animalInstance->updateAnimalAjax($customerId, $animalData);

    if ($result && $animalResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>

