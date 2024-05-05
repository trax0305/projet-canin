<?php
require_once('../../dist/php/connectionclass.php');
require_once('../../dist/php/userclass.php');

$user_instance = new User();
$user = $user_instance->getAll();


if (isset($_POST["Delete"])) {
  $user_instance->deleteUser($_POST["user_id"]);
  header("Location: projects.php");
}
// Le nom d'utilisateur est stocké dans $_SESSION["username"]
$nomUtilisateur = $_SESSION["username"];
?>
<?php
// Inclure le fichier des indicateurs
    include '../../dist/php/menuheader.php';
?>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Employés</h3>
          <a class="btn btn-warning btn-sm float-right" href="insertuser.php">Ajouter un salarié</a>

          <div class="card-tools">
            
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          id
                      </th>
                      <th style="width: 20%">
                          Name
                      </th>
                      <th style="width: 30%">
                          Firstname
                      </th>
                      <th style="width: 30%">
                          Team Members
                      </th>
                      <th style="width: 8%" class="text-center">
                          Profil
                      </th>
                      <th style="width: 8%" class="text-center">
                          Modification
                      </th>
                      <th style="width: 8%" class="text-center" data-toggle="modal" data-target="#confirmationModal" data-item-id=<?= $user->id ?>>
                          Supprimer
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                
                <?php $images = [
                    "../../dist/img/avatar2.png",
                    "../../dist/img/avatar.png",
                    "../../dist/img/avatar3.png",
                ]; ?>
                <?php if(!empty($user)) : ?>
                  <?php foreach ($user as $user) : ?>
                    <?php 
                    $randomIndex = array_rand($images);
                    // Le chemin de l'image correspondant à l'indice choisi
                    $randomImage = $images[$randomIndex]; ?>
                    <tr>
                    <td> <?= $user->id ?></td>
                    <td> <?= $user->lastname ?></td>
                    <td> <?= $user->firstname ?></td>
                    <td><img alt='Avatar' class='table-avatar' src= '<?= $randomImage ?>'></td>
                    <form method='post' action='view.php'>
                      <input type='hidden' name='user_id' value='<?= $user->id ?>'>
                      <td class='project-actions text-right'>
                        <button type='submit' class='btn btn-primary btn-sm'>
                            <i class='fas fa-folder'></i> View
                        </button>
                      </td>
                    </form>
                    <form method='post' action='edit.php'>
                      <input type='hidden' name='user_id' value='<?= $user->id ?>'>
                      <td class='project-actions text-right'>
                        <button type='submit' class='btn btn-info btn-sm'>
                          <i class='fas fa-pencil-alt'></i> Edit
                        </button>
                      </td>
                    </form>
                    <td class='project-actions text-right'>
                    <button name="Delete" class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-id=<?= (int)$user->id ?> data-target="#modal-default">
                      <i class="fas fa-trash"></i> 
                      Delete
                    </button>
                    </td>
                <?php endforeach ; ?>
                <?php endif ; ?>
                <div class="modal fade" id="modal-default">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title">Suppression d'un utilisateur</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
                    <div class="modal-body">
                      <p>Etes-vous sûr de vouloir supprimer l'utilisateur ?</p>
                      <input type="hidden" name="user_id" value="" id="userToDelete">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="Delete" class="btn btn-danger">Supprimer</button>
                    </div>
                  </form>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
                  
                  
              </tbody>
            </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
    $(document).ready(function(){
        $('.delete-btn').on('click', function() {
            var userId = $(this).data('id');
            console.log(userId);
            let inputhidden = $('#userToDelete');
            console.log(inputhidden);
            inputhidden.val(userId);
            console.log(inputhidden);
        });
    });
</script>
<?php
// Inclure le fichier des indicateurs
    include '../../dist/php/menufooter.php';
?>

