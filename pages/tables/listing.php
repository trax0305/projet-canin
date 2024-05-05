<?php
session_start();
require_once '../../dist/php/verification.php';
require_once '../../dist/php/customerclass.php';
require_once '../../dist/php/connectionclass.php';

// Crée une instance de la classe Connexion
$connexionClass = new Connexion();

// Obtient l'instance PDO à partir de la classe Connexion
$conn = $connexionClass->getPDO();

// Récupère les données de la table 'animals'
$sql = "SELECT * FROM animals";
$result = $conn->query($sql);
$animals = $result->fetchAll(PDO::FETCH_ASSOC);

// Récupère les données de la table 'customers'
$sql_customers = "SELECT * FROM customers";
$result_customers = $conn->query($sql_customers);
$customers = $result_customers->fetchAll(PDO::FETCH_ASSOC);

// Récupère les données de la table 'services'
$sql_services = "SELECT * FROM services";
$result_services = $conn->query($sql_services);
$services = $result_services->fetchAll(PDO::FETCH_ASSOC);

// Récupère les données de la table 'users'
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);
$users = $result_users->fetchAll(PDO::FETCH_ASSOC);

// Le reste de votre code reste inchangé
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
            <h1>Listing</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Listing</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Tableau pour la table 'animals' -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Animaux</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Race</th>
                                        <th>Âge</th>
                                        <th>Poids</th>
                                        <th>Hauteur</th>
                                        <th>Commentaire</th>
                                        <th>ID du Client</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Affiche les données dans le tableau
                                if (!empty($animals)) {
                                    foreach ($animals as $row) {
                                        echo "<tr>";
                                        echo "<td>" . $row["id"] . "</td>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td>" . $row["breed"] . "</td>";
                                        echo "<td>" . $row["age"] . "</td>";
                                        echo "<td>" . $row["weight"] . "</td>";
                                        echo "<td>" . $row["height"] . "</td>";
                                        echo "<td>" . $row["comment"] . "</td>";
                                        echo "<td>" . $row["customer_id"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Aucun animal trouvé</td></tr>";
                                }
                                ?>
                            </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Race</th>
                                        <th>Âge</th>
                                        <th>Poids</th>
                                        <th>Hauteur</th>
                                        <th>Commentaire</th>
                                        <th>ID du Client</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tableau pour la table 'customers' -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Clients</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2_customers" class="table table-bordered table-hover">
                            <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Adresse</th>
                                        <th>Commentaire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($customers)) {
                                    foreach ($customers as $row_customers) {
                                        echo "<tr>";
                                        echo "<td>" . $row_customers["id"] . "</td>";
                                        echo "<td>" . $row_customers["firstname"] . "</td>";
                                        echo "<td>" . $row_customers["lastname"] . "</td>";
                                        echo "<td>" . $row_customers["mail"] . "</td>";
                                        echo "<td>" . $row_customers["telephone"] . "</td>";
                                        echo "<td>" . $row_customers["postal_adress"] . "</td>";
                                        echo "<td>" . $row_customers["commentary"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Aucun client trouvé</td></tr>";
                                }
                                ?>
                            </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Adresse</th>
                                        <th>Commentaire</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tableau pour la table 'services' -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Services</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2_services" class="table table-bordered table-hover">
                            <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom du Service</th>
                                        <th>Prix</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($services)) {
                                    foreach ($services as $row_services) {
                                        echo "<tr>";
                                        echo "<td>" . $row_services["id"] . "</td>";
                                        echo "<td>" . $row_services["name"] . "</td>";
                                        echo "<td>" . $row_services["price"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>Aucun service trouvé</td></tr>";
                                }
                                ?>
                            </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom du Service</th>
                                        <th>Prix</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tableau pour la table 'users' -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Utilisateurs</h3>
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
                                        <th>Mot de passe</th>
                                        <th>Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($users)) {
                                    foreach ($users as $row_users) {
                                        echo "<tr>";
                                        echo "<td>" . $row_users["id"] . "</td>";
                                        echo "<td>" . $row_users["firstname"] . "</td>";
                                        echo "<td>" . $row_users["lastname"] . "</td>";
                                        echo "<td>" . $row_users["telephone"] . "</td>";
                                        echo "<td>" . $row_users["mail"] . "</td>";
                                        echo "<td>" . $row_users["postal_adress"] . "</td>";
                                        echo "<td>" . $row_users["mdp"] . "</td>";
                                        echo "<td>" . ($row_users["is_admin"] == 1 ? 'Oui' : 'Non') . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Aucun utilisateur trouvé</td></tr>";
                                }
                                ?>
                            </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Téléphone</th>
                                        <th>Email</th>
                                        <th>Adresse</th>
                                        <th>Mot de passe</th>
                                        <th>Admin</th>
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
<?php
// Inclure le fichier des indicateurs
    include '../../dist/php/menufooter.php';
?>
