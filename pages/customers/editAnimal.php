<?php
session_start();
require_once '../../dist/php/verification.php';
require_once '../../dist/php/animalsclass.php';
$animalInstance = new Animal();

// Récupère l'ID de l'animal de l'URL
$animalId = isset($_GET['id']) ? $_GET['id'] : null;

// Récupérer les informations de l'animal spécifique
$animal = null;
if ($animalId) {
    $animal = $animalInstance->getAnimalById($animalId); // Utiliser la méthode existante
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Appeler une méthode pour mettre à jour les informations de l'animal
    // Cette méthode doit être ajoutée dans votre classe Animal
    $result = $animalInstance->updateAnimal($_POST);

    if ($result) {
        // Rediriger vers une page de succès ou afficher un message
        echo "Mise à jour de l'animal réussi."; // Changez cela selon vos besoins
    } else {
        // Gérer l'erreur
        echo "Erreur lors de la mise à jour des informations de l'animal.";
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
                        <h3 class="card-title">Modifier les informations de l'animal</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($animal): ?>
                            <form action="editAnimal.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $animal->id; ?>">

                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $animal->name; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="breed">race</label>
                                    <input type="text" class="form-control" id="breed" name="breed" value="<?php echo $animal->breed; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="age">age</label>
                                    <input type="text" class="form-control" id="age" name="age" value="<?php echo $animal->age; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="weight">poids</label>
                                    <input type="text" class="form-control" id="weight" name="weight" value="<?php echo $animal->weight; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="height">taille</label>
                                    <textarea class="form-control" id="height" name="height"><?php echo $animal->height; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="comment">commentaire</label>
                                    <textarea class="form-control" id="comment" name="comment"><?php echo $animal->comment; ?></textarea>

                                <div class="form-group">
                                    <label for="is_actif">Actif</label>
                                    <select class="form-control" id="is_actif" name="is_actif">
                                        <option value="1" <?php echo $animal->is_actif ? 'selected' : ''; ?>>Oui</option>
                                        <option value="0" <?php echo !$animal->is_actif ? 'selected' : ''; ?>>Non</option>
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