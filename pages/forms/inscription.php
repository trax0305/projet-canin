<?php
session_start();
require_once '../../dist/php/customerclass.php';
require_once '../../dist/php/verification.php';

// Créer une instance de la classe Customer
$customerInstance = new Customer();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Appeler la méthode pour insérer les données du client et récupérer l'ID du client
    $customerId = $customerInstance->insertCustomer($_POST);

    // Vérifier si l'insertion s'est bien déroulée
    if ($customerId !== false) {
        echo "Données insérées dans la base de données avec succès.";
    } else {
        echo "Erreur lors de l'insertion des données du client.";
    }
}
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
                <h3 class="card-title">Nouveau Client</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" class="customer-form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="name" class="form-control" name="name" id="name" placeholder="Entrez votre nom">
                  </div>
                  <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="prenom" class="form-control" name="prenom" id="prenom" placeholder="Entrez votre Prénom">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre email">
                  </div>
                  <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="phone" class="form-control" name="phone" id="phone" placeholder="Entrez votre Numéro de téléphone">
                  </div>
                  <div class="form-group">
                    <label for="adress">Adresse</label>
                    <input type="adress" class="form-control" name="adress" id="adress" placeholder="Entrez votre adresse">
                  </div>
                  <div class="form-group">
                    <label for="commentaire">Commentaire</label>
                    <input type="commentaire" class="form-control" name="commentaire" id="commentaire" placeholder="Commentaires">
                  </div>
                    <button type="submit" id="blockBtn2" style="display: block" class="btn btn-success">Valider l'inscription</button>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
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
                  <button type="submit" class="btn btn-secondary">Envoyer</button>
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
