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


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Appeler une méthode pour mettre à jour les informations du client
    // Cette méthode doit être ajoutée dans votre classe Customer
    $result = $customerInstance->updateCustomer($_POST);

    if ($result) {
        // Rediriger vers une page de succès ou afficher un message
        echo "Mise à jour réalisée avec succès."; // Changez cela selon vos besoins
    } else {
        // Gérer l'erreur
        echo "Erreur lors de la mise à jour des informations du client.";
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
    
    <!-- ... [Autres parties du HTML] ... -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Modifier les informations du Client</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($customer): ?>
                            <form action="editCustomer.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $customer->id; ?>">
                                
                                <div class="form-group">
                                    <label for="firstname">Prénom</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $customer->firstname; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="lastname">Nom</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $customer->lastname; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="telephone">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $customer->telephone; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="mail" value="<?php echo $customer->mail; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="address">Adresse</label>
                                    <input type="text" class="form-control" id="address" name="postal_adress" value="<?php echo $customer->postal_adress; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="commentary">Commentaire</label>
                                    <textarea class="form-control" id="commentary" name="commentary"><?php echo $customer->commentary; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="is_actif">Actif</label>
                                    <select class="form-control" id="is_actif" name="is_actif">
                                        <option value="1" <?php echo $customer->is_actif ? 'selected' : ''; ?>>Oui</option>
                                        <option value="0" <?php echo !$customer->is_actif ? 'selected' : ''; ?>>Non</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </form>
                        <?php else: ?>
                            <p>Mise à jour effectuée.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ... [Reste du HTML] ... -->

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