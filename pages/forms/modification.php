<?php

require_once '../../dist/php/verification.php';
require_once '../../dist/php/customerclass.php';
require_once '../../dist/php/animalsclass.php';
// Fermer la connexion à la base de données
// $connexion->close();

?>

<?php
// Inclure le fichier des indicateurs
    include '../../dist/php/menuheader.php';
?>


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
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Modification des informations client</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" class="customer-form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Rechercher un client</label>
                    <input type="texte" class="form-control" name="search" id="name" placeholder="Entrez votre recherche">
                  </div>
                  <button id="blockBtn3" style="display: block" class="btn btn-primary">Rechercher</button>
              </form>


              <?php
              // Créer une instance de la classe Customer
$customerInstance = new Customer();
//Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les données du formulaire
  $searchData = array('search' => $_POST['search']);

  // Appeler la fonction de recherche
  $results = $customerInstance->searchCustomer($searchData);

  // Afficher les résultats sous forme de tableau HTML
  if (!empty($results)) {
      echo '<table border="1">
              <tr>
                  <th>Customer ID</th>
                  <th>Customer Mail</th>
                  <th>Customer Lastname</th>
                  <th>Animal ID</th>
                  <th>Animal Name</th>
              </tr>';

      foreach ($results as $result) {
          echo '<tr>
                  <td>' . $result['customer']['id'] . '</td>
                  <td>' . $result['customer']['mail'] . '</td>
                  <td>' . $result['customer']['lastname'] . '</td>
                  <td>' . $result['animal']['id'] . '</td>
                  <td>' . $result['animal']['name'] . '</td>
              </tr>';
      }

      echo '</table>';
  } else {
      echo 'Aucun résultat trouvé.';
  }
}
?>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Main content -->
    <section class="content">
      <!-- Div à cacher -->
      <div id="d1" style="display: none" >
      <div class="container-fluid">
        <div class="row-inscription">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Votre Chien</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" class="animal-form">
                <div class="card-body">
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" onclick="submitBothForms()" class="btn btn-secondary">Envoyer</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
        <!-- /.Div à cacher -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
// Inclure le fichier des indicateurs
    include '../../dist/php/menufooter.php';
?>
