  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tableau de bord</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tableau de Bord</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $customerscount; ?></h3>

                <p>Nombre de clients</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $countAnimals; ?></h3>

                <p>Nombre d'animaux</p>
              </div>
              <div class="icon">
                <i class="ion "></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $revenue; ?><sup style="font-size: 20px">€</sup></h3>

                <p>Chiffre d'affaire réalisé</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $countrdvfuture ;?></h3>

                <p>Nombre de RDV à venir</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-sharp"></i>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row-inscription">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h2 class="card-title">Rechercher par client</h2>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" class="customer-form">
                <div class="card-body">
                  <div class="form-group">
                    <input type="texte" class="form-control" name="search" id="name" placeholder="Entrez votre recherche">
                  </div>
                    <div style="display: flex; gap: 300px;">
                      <button id="blockBtn3" style="display: block" class="btn btn-primary">Rechercher</button>
                      <a href="pages/forms/inscription.php" style="display: block" class="btn btn-success">Rajouter un nouveau client</a>
                      <a href="pages/calendar.php" style="display: block" class="btn btn-warning">Accéder au Calendrier des R.D.V</a>
                    </div>
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
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Mail</th>
                  <th>Nom Animal</th>
                  <th>Race</th>
                  <th>Action</th>
              </tr>';

              foreach ($results as $result) {
                echo '<tr>
                    <td class="editable" id="lastname_' . $result['customer']['id'] . '">' . $result['customer']['lastname'] . '</td>
                    <td class="editable" id="firstname_' . $result['customer']['id'] . '">' . $result['customer']['firstname'] . '</td>
                    <td class="editable" id="mail_' . $result['customer']['id'] . '">' . $result['customer']['mail'] . '</td>
                    <td class="editable" id="name_' . $result['customer']['id'] . '">' . $result['animal']['name'] . '</td>
                    <td class="editable" id="breed_' . $result['customer']['id'] . '">' . $result['animal']['breed'] . '</td>
                    <td><i class="fas fa-edit" onclick="editRecord(event, ' . $result['customer']['id'] . ')" style="cursor: pointer;"></i>
                    <a href="pages/customers/detailCustomer.php?id=' . $result['customer']['id'] . '"><i class="fas fa-eye" style="cursor: pointer; margin-left: 10px;"></i></a>
            
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
    <section class="content">
      <div class="container-fluid">
        <div class="row-inscription">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Rechercher par animal</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" class="customer-form">
                <div class="card-body">
                  <div class="form-group">
                    <input type="texte" class="form-control" name="search" id="name" placeholder="Entrez votre recherche">
                  </div>
                  <button id="blockBtn3" style="display: block" class="btn btn-primary">Rechercher</button>
              </form>


              <?php
              // Créer une instance de la classe Animal
              $animalInstance = new Animal();
              //Vérifier si le formulaire a été soumis
              if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              // Récupérer les données du formulaire
              $searchData = array('search' => $_POST['search']);

              // Appeler la fonction de recherche
                $results = $animalInstance->searchAnimal($searchData);
              

              // Afficher les résultats sous forme de tableau HTML
              if (!empty($results)) {
              echo '<table border="1">
              <tr>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Mail</th>
                  <th>Nom Animal</th>
                  <th>Race</th>
                  <th>Action</th>
              </tr>';

              foreach ($results as $result) {
                echo '<tr>
                    <td class="editable" id="lastname_' . $result['customer']['id'] . '">' . $result['customer']['lastname'] . '</td>
                    <td class="editable" id="firstname_' . $result['customer']['id'] . '">' . $result['customer']['firstname'] . '</td>
                    <td class="editable" id="mail_' . $result['customer']['id'] . '">' . $result['customer']['mail'] . '</td>
                    <td class="editable" id="name_' . $result['customer']['id'] . '">' . $result['customer']['name'] . '</td>
                    <td class="editable" id="breed_' . $result['customer']['id'] . '">' . $result['customer']['breed'] . '</td>
                    <td><i class="fas fa-edit" onclick="editRecord(event, ' . $result['customer']['id'] . ')" style="cursor: pointer;"></i>
                    <a href="pages/customers/detailCustomer.php?id=' . $result['customer']['id'] . '"><i class="fas fa-eye" style="cursor: pointer; margin-left: 10px;"></i></a>
                
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
    <section class="content">
      <div class="container-fluid">
        <div class="row-inscription">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Liste des R.D.V à venir</h3>
              </div>
              <!-- /.card-header -->

              <?php
              // Créer une instance de la classe Customer
              $CustomerListInstance = new Customer();

              // Appeler la fonction de recherche
              try {
              $resultsListInstance = $CustomerListInstance->getAppointments();
              } catch (PDOException $e) {
              echo "Erreur lors de l'appel à la base de données : " . $e->getMessage();
              // Ajoutez un return; ici si vous voulez arrêter l'exécution du script en cas d'erreur.
              }

              // Afficher les résultats sous forme de tableau HTML
              if (!empty($resultsListInstance)) {
              echo '<table border="1">
              <tr>
             <th>Dte/Hre début</th>
             <th>Dte/Hre fin</th>
             <th>Payé</th>
             <th>Nom Animal</th>
             <th>Employé</th>
             <th>Prestation</th>
             <th>Détail</th>
             </tr>';

              foreach ($resultsListInstance as $result) {
               echo '<tr>
                <td>' . date('Y-m-d H:i:s', strtotime($result['date_start'])) . '</td>
                <td>' . date('Y-m-d H:i:s', strtotime($result['date_end'])) . '</td>
                <td>' . ($result['is_paid'] ? 'Oui' : 'Non') . '</td>
                <td>' . $result['animal_name'] . '</td>
                <td>' . $result['user_firstname'] . '</td>
                <td>' . $result['service_name'] . '</td>
                <td>
                    <a href="pages/forms/detailrdv.php?id=' . $result['id'] . '">
                        <i class="fas fa-eye" style="cursor: pointer; margin-left: 10px;"></i>
                    </a>
                </td>
              </tr>';
              }

              echo '</table>';
              } else {
              echo 'Aucun rendez-vous trouvé.';
                }
               ?>

            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- BoutonModifier -->

<script src="/dist/js/editform.js"></script>