<?php
  require_once('../../dist/php/connectionclass.php');
  require_once('../../dist/php/userclass.php');
  require_once('../../dist/php/servicesclass.php');

  $user_instance = new User();
  $user = $user_instance->getAll();
  $service = new Services();
  $service_profile = $service->getAll();
  $service_names = $user_instance->getAllServices();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["user_id"])) {
    $userId = $_POST["user_id"];

    // Utilisez l'ID pour récupérer les informations de l'utilisateur (supposez que vous ayez une fonction pour cela)
    $user_config = $user_instance->getByID($userId);
  }



  // Vérifier la connexion
  if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
  }

  if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: login.php");
    exit;
  }
  // Le nom d'utilisateur est stocké dans $_SESSION["username"]
  $nomUtilisateur = $_SESSION["username"];

  // Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["user_id"])) {
  $userId = $_POST["user_id"];
  
  // Récupérer les services cochés ou décochés
  $selectedServices = isset($_POST['services']) ? $_POST['services'] : [];
  
  // Appeler la fonction pour mettre à jour les capacités de l'utilisateur
  $user_instance->updateCapabilities($userId, $selectedServices);
}

// Utilisez l'ID pour récupérer les informations de l'utilisateur
if (isset($_POST["user_id"])) {
  $userId = $_POST["user_id"];
  $user_config = $user_instance->getByID($userId);
}

  ?>
<?php
// Inclure le fichier des indicateurs
    include '../../dist/php/menuheader.php';
?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="../../dist/img/user4-128x128.jpg"
                        alt="User profile picture">
                  </div>

                  <h3 class="profile-username text-center"><?= $user_config->firstname . " "  .$user_config->lastname?></h3>

                  <p class="text-muted text-center">Service associé</p>

                  <ul class="list-group list-group-unbordered mb-3">
                      <?php
                     $canDoService = $user_config->CanDoCapabilities($user_config->id);
                     foreach ($service_names as $service_name) : ?>
                     <li class="list-group-item">
                       <b><?= $service_name ?></b>
                       <?php if ($canDoService[$service_name]) : ?>
                         <input type='checkbox' name='<?= $service_name?>'class="float-right" checked>
                       <?php else : ?>
                         <input type='checkbox' name='<?= $service_name?>'class="float-right">
                       <?php endif ; ?>
                     </li>
                     <?php endforeach ; ?>
                  </ul>
                  <form method='post' action='edit.php'>
                      <input type='hidden' name='user_id' value='<?= $userId ?>'>
                      <button class="btn btn-primary btn-block">Modifier</button>
                  </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- About Me Box -->
              <div class="card card-primary">
                
                
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Informations</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal">
                        <div class="form-group row">
                          <b class="col-sm-2 col-form-label">Nom</b>
                          <div class="col-sm-10">
                            <div class="border p-2">
                              <b><?= $user_config->lastname ?></b>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <b class="col-sm-2 col-form-label">Prénom</b>
                          <div class="col-sm-10">
                            <div class="border p-2">
                              <b><?= $user_config->firstname ?></b>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <b class="col-sm-2 col-form-label">Email</b>
                          <div class="col-sm-10">
                            <div class="border p-2">
                              <b><?= $user_config->email ?></b>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputExperience" class="col-sm-2 col-form-label">Téléphone</label>
                          <div class="col-sm-10">
                            <div class="border p-2">
                              <b><?= $user_config->telephone ?></b>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputSkills" class="col-sm-2 col-form-label">Adresse</label>
                          <div class="col-sm-10">
                            <div class="border p-2">
                              <b><?= $user_config->address ?></b>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputSkills" class="col-sm-2 col-form-label">Est Admin</label>
                          <div class="col-sm-10">
                            <div class="border p-2">
                              <?php if ($user_config->idisadmin == 1): ?>
                                <b>Oui</b>
                              <?php else : ?>
                                <b>Non</b>
                              <?php endif ; ?>
                            </div>
                          </div>
                        </div>
                        
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  <!-- ./wrapper -->
  </div>
  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  </body>
  </html>
