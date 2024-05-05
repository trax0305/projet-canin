<!-- Inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?php
session_start();
require_once '../dist/php/verification.php';
require_once '../dist/php/customerclass.php';
require_once '../dist/php/animalsclass.php';
// Remplacez les valeurs suivantes par les informations de votre base de données
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "toilettage";

// Connexion à la base de données
$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Requête SQL avec alias pour éviter les conflits de noms de colonnes
$sql = "SELECT 
    appointments.id, 
    appointments.date_start as start, 
    appointments.date_end as end, 
    animals.name as animal_name, 
    services.name as service_name, 
    users.firstname 
FROM appointments
INNER JOIN animals ON appointments.animal_id = animals.id
INNER JOIN services ON appointments.service_id = services.id
INNER JOIN users ON appointments.user_id = users.id";

$resultat = $connexion->query($sql);

// Vérifier si la requête a réussi
if ($resultat) {
    // Initialiser un tableau pour stocker les données
    $datas = array();

    // Parcourir les résultats de la requête
    while ($row = $resultat->fetch_assoc()) {
        // Formater les dates en utilisant strtotime
        $row['start'] = date('Y-m-d H:i:s', strtotime($row['start']));
        $row['end'] = date('Y-m-d H:i:s', strtotime($row['end']));

        // Utiliser les clés correctes pour les informations supplémentaires
        $row['animal_name'] = $row['animal_name'];
        $row['service_name'] = $row['service_name'];
        $row['user_name'] = $row['firstname'];

        // Ajouter la ligne au tableau de données
        $datas[] = $row;
    }

    // Fermer la connexion à la base de données
    $connexion->close();

    // Convertir le tableau en format JSON
    $final_array = json_encode($datas);

//     // Afficher le résultat
//     echo("<pre>");
//     echo("<code>");
//     echo $final_array;
//     echo("</code>");
//     echo("</pre>");
// } else {
//     echo "Erreur de requête : " . $connexion->error;
}
// Créer une instance de la classe Customer
$customerInstance = new Customer();

//Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchCustomer'])) {
    // Récupérer les données du formulaire
    $searchData = array('search' => $_POST['search']);

    // Appeler la fonction de recherche
    $results = $customerInstance->searchCustomer($searchData);
}
?>
<?php
require_once '../dist/php/appointementsclass.php';
// Créer une instance de la classe Appointment
$appointmentInstance = new Appointment();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitAppointment'])) {
    // Récupérer les données du formulaire
    $formData = array(
        'start' => $_POST['start'],
        'end' => $_POST['end'],
        'is_paid' => $_POST['is_paid'],
        'user_id' => $_POST['user_id'],  // Assurez-vous de récupérer correctement l'ID de l'utilisateur
        'animal_id' => $_POST['animal_id'],
        'service_id' => $_POST['service_id']
    );

    // Appeler la méthode insertAppointment
    $appointmentId = $appointmentInstance->insertAppointment($formData);

    // Vous pouvez faire quelque chose avec l'ID du rendez-vous nouvellement inséré, si nécessaire
}
?>
<?php
// Inclure le fichier des indicateurs
    include '../dist/php/menuheader.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Calendrier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
              <li class="breadcrumb-item active">Calendrier</li>
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
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Prendre un R.D.V</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="customer-form">
                      <div class="card-body">
                       <div class="form-group">
                         <!-- <input type="texte" class="form-control" name="search" id="name" placeholder="Entrez votre recherche"> -->
                         </div>
                       <div style="display: flex; gap: 300px;">
                          <!-- <button id="blockBtn3" style="display: block" name = "searchCustomer" class="btn btn-primary">Rechercher</button> -->
                        </div>
                    </form>
                        <div class="card-body">
                          <form method="post" class="appointment-form">
                            <div class="form-group">
                                <label for="start">Date de début</label>
                                <input type="datetime-local" class="form-control" name="start" id="start" placeholder="Sélectionnez la date de début" lang="fr">
                            </div>
                            <div class="form-group">
                                <label for="end">Date de fin</label>
                                <input type="datetime-local" class="form-control" name="end" id="end" placeholder="Sélectionnez la date de fin" lang="fr">
                            </div>
                            <div class="form-group">
                                <label for="is_paid">Paiement effectué</label>
                                <select class="form-control" name="is_paid" id="is_paid">
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>
                            <div class="form-group">
                            <label for="userSelect">Sélectionner un salarié</label>
                                <select class="form-control" name="user_id" id="user_id" multiple>
                                    <option value="1 - Pierre">Émilie</option>
                                    <option value="2">Daniel</option>
                                    <option value="3">Olivia</option>
                                    <option value="4">Samuel</option>
                                    <!-- Ajoutez d'autres options selon vos besoins -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="animal_id">Animal</label>
                                    <select class="form-control select2" name="animal_id" id="animal_id">
                                    <?php
                                        // Inclure votre classe Animal et instancier un objet Animal
                                        $animal = new Animal();

                                        // Récupérer tous les animaux avec leurs maîtres correspondants
                                        $animals = $animal->getAllAnimalsWithOwners();

                                        // Parcourir les animaux et afficher chaque nom d'animal avec le nom de son maître dans la liste déroulante
                                        foreach ($animals as $animal) {
                                            echo '<option value="' . $animal['id'] . '">' . $animal['name'] . ' (Maître : ' . $animal['customer_firstname'] . ')</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                            <div class="form-group">
                            <label for="serviceSelect">Sélectionner un service</label>
                                <select class="form-control" name="service_id" id="service_id" multiple>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <!-- Ajoutez d'autres options selon vos besoins -->
                                </select>
                            </div>
                            <button type="submit" id="blockBtn2" style="display: block"  name="submitAppointment" class="btn btn-success">Valider la réservation</button>
                        </form>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <input id="event-datas" type="hidden" value='<?php echo $final_array; ?>'>
                <div id="calendar" style="max-width:100%;"></div>
                <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
                <!-- <div id="calendar"></div> -->
              </div>
              <!-- /.card-body -->
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
  <!-- /.content-wrapper -->

<script>
    let test = document.querySelector("#event-datas").value;
    let events = JSON.parse(test);

    console.log(events);

    console.log(JSON.stringify(events));

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: { center: 'dayGridMonth,timeGridWeek' },
            initialView: 'dayGridMonth',
            events: events.map(function (event) {
                return {
                    title: event.animal_name || event.service_name || event.user_name,
                    start: event.start,
                    end: event.end,
                    id : event.id,
                    url: '../pages/forms/detailrdv.php?id=' + event.id // Ajoutez le lien que vous souhaitez ici
                };
            }),
            locale: 'fr',
            // slotDuration: '02:00',
            eventClick: function (info) {
                if (info.event.url) {
                    window.location = info.event.url;
                }
            }
        });
        calendar.render();
    });
</script>

<?php
// Inclure le fichier des indicateurs
    include '../dist/php/menufooter.php';
?>
