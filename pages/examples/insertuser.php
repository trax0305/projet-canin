<?php
require_once('../../dist/php/connectionclass.php');
require_once('../../dist/php/userclass.php');
require_once('../../dist/php/servicesclass.php');
$connexion = new Connexion();
$user_instance = new User();
$service_instance = new Services();
$user = $user_instance->getAll();
$service = $service_instance->getAll();


if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Appeler la méthode pour insérer les données du client et récupérer l'ID du client
    $user_insert = $user_instance->insertUser($_POST);
}
  // Le nom d'utilisateur est stocké dans $_SESSION["username"]
  $nomUtilisateur = $_SESSION["username"];


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CANIN BTS | Statistic</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Bonjour  <?php echo $nomUtilisateur; ?></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="logout.php" class="nav-link">Se déconnecter</a>
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
    <a href="../../index.html" class="brand-link">
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
          <a href="#" class="d-block"><?php echo $nomUtilisateur; ?></a>
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
            <a href="../charts/chartjs.php" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Graphique
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../forms/inscription.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Inscription
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../forms/modification.php" class="nav-link">
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ajout Utilisateur</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ajout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>
              <div class="card-tools">
              </div>
            </div>
            <div class="card-body">
            <form method='post' class='customer-form'>
              <!-- <input type="hidden" name="inputId" id="inputName" value=""> -->
              <div class="form-group">
                <label for="inputName">Nom</label>
                <input type="text" name="inputName" id="inputName" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputPrénom">Prénom</label>
                <input type="text" name="inputPrénom" id="inputPrénom" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputAdmin">Cocher si admin</label>
                <input type="checkbox" name="inputAdmin" id="inputAdmin"  class="form-control" value="1" checked>
              </div>
              <div class="form-group">
                <label for="inputAdress">Adresse postale</label>
                <input type="text" name="inputAdress" id="inputAdress" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="text" name="inputEmail" id="inputEmail" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputTelephone">Telephone</label>
                <input type="text" name="inputTelephone" id="inputTelephone" class="form-control">
              </div>
              <div class="form-group">
                <label for="inputActivite">Choisir une activité :</label>
                <select class="form-control" id="activite" name="activite" >
                  <?php foreach($service as $service): ?>
                    <option name="inputActivite" id="inputActivite" value=<?= $service->id ?> ><?= $service->name ?> </option>
                  <?php endforeach ; ?>
                </select>

              </div>
              
                
              
              <div class="form-group">
                <label for="inputTelephone">Mot de Passe</label>
                <input type="text" name="inputPassword" id="inputPassword" class="form-control">
              </div>
              <div class="card-footer">
                <button type="submit" id="test" style="display: block" class="btn btn-success">Ajouter</button>
              </div>
            </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    

      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- <script>
    function updateLabel() {
        var selectedActivity = document.getElementById("activite").value;
        console.log(selectedActivity);
    }
</script> -->