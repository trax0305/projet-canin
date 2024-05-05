<?php
require_once '../../dist/php/verification.php';
require_once '../../dist/php/customerclass.php';
require_once '../../dist/php/animalsclass.php';

$appointmentId = isset($_GET['id']) ? $_GET['id'] : null;

// Créer une instance de la classe Customer
$customerInstance = new Customer();

// Récupérer les détails du rendez-vous
$appointmentDetails = $customerInstance->getAppointmentDetails($appointmentId);

// Faire quelque chose avec les détails du rendez-vous
if (!$appointmentDetails) {
    // Gérer le cas où le rendez-vous n'est pas trouvé
    die("Rendez-vous non trouvé.");
}

// Remplacez les valeurs suivantes par les informations de votre base de données
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "toilettage";

// Vérifier la connexion
$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Formater la date au format "dd/mm/yyyy hh:mm"
$formattedDateStart = date('Y-m-d\TH:i', strtotime($appointmentDetails['date_start']));

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que le champ 'appointment_id' existe dans $_POST
    if (isset($_POST['appointment_id'])) {
        // Récupérer les données du formulaire
        $appointmentId = $_POST['appointment_id'];
        $dateStart = $_POST['date_start'];
        $dateEnd = $_POST['date_end'];
        // Ajoutez d'autres champs de formulaire selon vos besoins

        // Préparez la requête de mise à jour
        $updateSql = "UPDATE appointments SET date_start=?, date_end=? WHERE id=?";
        $stmt = $connexion->prepare($updateSql);

        // Vérifiez si la préparation de la requête a réussi
        if ($stmt) {
            // Liez les paramètres à la requête
            $stmt->bind_param("ssi", $dateStart, $dateEnd, $appointmentId);

            // Exécutez la requête
            $stmt->execute();

            // Fermez la requête préparée
            $stmt->close();

            // Fermer la connexion à la base de données
            $connexion->close();

            // Redirigez l'utilisateur vers une page de confirmation ou une autre page après la mise à jour
            header("Location: ../calendar.php");
            exit();
        } else {
            echo "Erreur de préparation de la requête : " . $connexion->error;
        }
    }
}

// Requête SQL avec alias pour éviter les conflits de noms de colonnes
$sql = "SELECT 
    appointments.id, 
    appointments.is_paid as is_paid, 
    appointments.date_start as start, 
    appointments.date_end as end, 
    animals.name as animal_name, 
    services.name as service_name, 
    users.firstname 
FROM appointments
INNER JOIN animals ON appointments.animal_id = animals.id
INNER JOIN services ON appointments.service_id = services.id
INNER JOIN users ON appointments.user_id = users.id
WHERE appointments.id = $appointmentId";

$resultat = $connexion->query($sql);

// Vérifier si la requête a réussi
if ($resultat) {
    // Récupérer la première ligne du résultat
    $row = $resultat->fetch_assoc();

    // Formater les dates en utilisant strtotime
    $row['start'] = date('Y-m-d H:i:s', strtotime($row['start']));
    $row['end'] = date('Y-m-d H:i:s', strtotime($row['end']));

    // Récupérer les informations individuelles
    $isPaid = $row['is_paid'];
    $animalName = $row['animal_name'];
    $serviceName = $row['service_name'];
    $userName = $row['firstname'];

    // Fermer la connexion à la base de données
    $connexion->close();

    // Convertir le tableau en format JSON
    $final_array = json_encode($row);
} else {
    echo "Erreur de requête : " . $connexion->error;
}

// // Afficher le résultat
// echo("<pre>");
// echo("<code>");
// echo $final_array;
// echo("</code>");
// echo("</pre>");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CANIN BTS | General Form Elements</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="../../dist/css/adminlte.min.css"> -->
  <link rel="stylesheet" href="../../dist/css/adminlte.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index.php" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CANINBTS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tableau de bord</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="../charts/chartjs.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Graphique
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../forms/inscription.php" class="nav-link ">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Inscription
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../forms/modification.php" class="nav-link active">
              <i class="nav-icon fas fa-solid fa-pen"></i>
              <p>
                Modification
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../tables/data.html" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>Listing</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../calendar.html" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendrier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Gallery
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../examples/projects.html" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>Admin</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../documentation.html" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inscription</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inscription</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="row-inscription">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Modification des informations client</h3>
            </div>
              <form method="post" class="customer-form">
                  <div class="card-body">
                      <!-- Afficher les détails du rendez-vous -->
                      <?php if (isset($appointmentDetails)): ?>
                          <div>
                              <input type="hidden" name="appointment_id" value="<?php echo $appointmentDetails['id']; ?>">
                              <div class="form-group">
                                  <label for="date_start">Date de début:</label>
                                  <input type="datetime-local" class="form-control" name="date_start" value="<?php echo $formattedDateStart; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="date_end">Date de fin:</label>
                                  <input type="datetime-local" class="form-control" name="date_end" value="<?php echo $appointmentDetails['date_end']; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="is_paid">Payé:</label>
                                  <input type="text" class="form-control" name="is_paid" value="<?php echo ($isPaid == 1) ? 'Payé' : 'Non payé'; ?>" readonly>
                              </div>
                              <div class="form-group">
                                  <label for="user_name">Employé:</label>
                                  <input type="text" class="form-control" name="user_name" value="<?php echo $userName ?>" readonly>
                              </div>
                              <div class="form-group">
                                  <label for="animal_name">Animal:</label>
                                  <input type="text" class="form-control" name="animal_name" value="<?php echo $animalName ?>" readonly>
                              </div>
                              <div class="form-group">
                                  <label for="service_name">Service:</label>
                                  <input type="text" class="form-control" name="service_name" value="<?php echo $serviceName ?>" readonly>
                              </div>
                              <!-- Ajoutez d'autres champs de formulaire pour d'autres détails du rendez-vous -->
                          </div>
                      <?php endif; ?>
                  </div>
                  <button type="submit" class="btn btn-secondary">Envoyer</button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Bouton hide JS -->
<script src="../../dist/js/pages/bouton.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
