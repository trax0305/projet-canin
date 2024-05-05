<?php
session_start();
require_once 'dist/php/verification.php';
require_once 'dist/php/customerclass.php';
require_once 'dist/php/animalsclass.php';

$CalRate = new Customer();
$CalRateanimals = new Animal();

$revenue = $CalRate->calculateRevenue();
$customerscount = $CalRate->countTotalCustomers();
$countrdvfuture = $CalRate->countFutureAppointments();
$countAnimals = $CalRateanimals->countTotalAnimal();

?>

<?php
// Inclure le fichier des indicateurs
    include 'dist/php/menuheader.php';
?>
<?php
// Inclure le fichier des indicateurs
    include 'dist/php/indicateursclass.php';
?>
<?php
// Inclure le fichier des indicateurs
    include 'dist/php/menufooter.php';
?>
