<?php
session_start();
require_once '../../dist/php/verification.php';
require_once '../../dist/php/customerclass.php';
$customerInstance = new Customer();

// Récupère l'ID du client de l'URL
$customerId = isset($_GET['id']) ? $_GET['id'] : null;

// Récupérer les informations du client spécifique
$customer = null;
if ($customerId) {
    $customer = $customerInstance->getCustomerById($customerId); // Utiliser la méthode existante
}

require_once '../../dist/php/animalsclass.php';
$animalInstance = new Animal();

// Récupère l'ID du client de l'URL
$customerId = isset($_GET['id']) ? $_GET['id'] : null;

// récupere les information des l'animaeaux en fonction de l'id du client
$animals = null;
if ($customerId) {
    $animals = $animalInstance->getAnimalByCustomerId($customerId); // Utiliser la méthode existante
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
            <h1>Détail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">détail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informations du Client</h3>
                        </div>
                    <div class="card-body">
                      <table id="example2_users" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Prénom</th>
                                    <th>Nom</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Adresse</th>
                                    <th>Commentaire</th>
                                    <th>Actif</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($customer): ?>
                                    <tr>
                                        <td><?php echo $customer->id; ?></td>
                                        <td><?php echo $customer->firstname; ?></td>
                                        <td><?php echo $customer->lastname; ?></td>
                                        <td><?php echo $customer->telephone; ?></td>
                                        <td><?php echo $customer->mail; ?></td>
                                        <td><?php echo $customer->postal_adress; ?></td>
                                        <td><?php echo $customer->commentary; ?></td>
                                        <td><?php echo $customer->is_actif ? 'Oui' : 'Non'; ?></td>
                                        <td><a href="editCustomer.php?id=<?php echo $customer->id; ?>" class="btn btn-primary">Modifier</a></td>
                                        <td><button class="btn btn-danger btn-disable-customer" data-id="<?php echo $customer->id; ?>">Désactiver</button></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10">Client non trouvé.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">liste des animeaux du client</h3>
                    </div>
                    <div class="card-body">
                        <table id="example2_users" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>nom</th>
                                    <th>race</th>
                                    <th>age</th>
                                    <th>poids</th>
                                    <th>taille</th>
                                    <th>commentaire</th>
                                    <th>actif</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($animals) && is_array($animals)): ?>
                              <?php foreach ($animals as $animal): ?>
                                <tr>
                                  <td><?php echo $animal->id; ?></td>
                                  <td><?php echo $animal->name; ?></td>
                                  <td><?php echo $animal->breed; ?></td>
                                  <td><?php echo $animal->age; ?></td>
                                  <td><?php echo $animal->weight; ?></td>
                                  <td><?php echo $animal->height; ?></td>
                                  <td><?php echo $animal->comment; ?></td>
                                  <td><?php echo $animal->is_actif ? 'Oui' : 'Non'; ?></td>
                                  <td><a href="editAnimal.php?id=<?php echo $animal->id; ?>" class="btn btn-primary">Modifier</a></td>
                                  <td><button class="btn btn-danger btn-disable-animal" data-id="<?php echo $animal->id; ?>">Désactiver</button></td>
                                </tr>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="11">Aucun animal trouvé pour ce client.</td>
                                </tr>
                              <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>nom</th>
                                    <th>race</th>
                                    <th>age</th>
                                    <th>poids</th>
                                    <th>taille</th>
                                    <th>commentaire</th>
                                    <th>actif</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<?php
// Inclure le fichier des indicateurs
    include '../../dist/php/menufooter.php';
?>

<script>
$(document).ready(function() {
    // Gérer le clic sur le bouton "Désactiver" pour un client
    $(".btn-disable-animal").click(function() {
        var animalId = $(this).data("id");
        console.log("animal ID à désactiver : " + animalId); // Vérifiez si l'ID est correct

        // Envoyer une requête AJAX au serveur pour désactiver le client
        $.ajax({
            url: "disableAnimal.php", // Le script PHP qui gère la désactivation du client
            method: "POST",
            data: { animal_id: animalId },
            success: function(response) {
                console.log("Réponse du serveur : " + response); // Vérifiez la réponse du serveur
                // Mettre à jour l'interface utilisateur en conséquence
                if (response === "success") {
                    alert("animal désactivé avec succès.");
                    location.reload(); // Rechargez la page pour mettre à jour la liste des clients
                } else {
                    alert("Erreur lors de la désactivation de l'animal.");
                }
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    // Gérer le clic sur le bouton "Désactiver" pour un client
    $(".btn-disable-customer").click(function() {
        var customerId = $(this).data("id");
        console.log("Customer ID à désactiver : " + customerId); // Vérifiez si l'ID est correct

        // Envoyer une requête AJAX au serveur pour désactiver le client
        $.ajax({
            url: "disableCustomer.php", // Le script PHP qui gère la désactivation du client
            method: "POST",
            data: { customer_id: customerId },
            success: function(response) {
                console.log("Réponse du serveur : " + response); // Vérifiez la réponse du serveur
                // Mettre à jour l'interface utilisateur en conséquence
                if (response === "success") {
                    alert("Client désactivé avec succès.");
                    location.reload(); // Rechargez la page pour mettre à jour la liste des clients
                } else {
                    alert("Erreur lors de la désactivation du client.");
                }
            }
        });
    });
});
</script>
