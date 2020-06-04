<?php
include 'model/getCategoriesCriteres.php';
include 'model/getDomaines.php';
include 'model/getUtilisateurs.php';
include 'model/getCategorieById.php';
include 'model/getDomaineById.php';
include 'model/getUtilisateurById.php';
include 'model/updateUtilisateur.php';
//Redirige vers le login si l'utilisateur n'est pas authentifié
if(!isset($_SESSION["log"])) {
  header('Location: index.php?page=login');
}

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'modifierCategorie') {
    $idCategorieAlter = $_POST["idCategorie"];
    $categorieAlter = getCategorieById($idCategorieAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalModifierCategorie').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'modifierDomaine') {
    $idDomaineAlter = $_POST["idDomaine"];
    $domaineAlter = getDomaineById($idDomaineAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalModifierDomaine').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'modifierUtilisateur') {
    $idUtilisateurAlter = $_POST["idUtilisateur"];
    $utilisateurAlter = getUtilisateurById($idUtilisateurAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalModifierUtilisateur').modal('show');
          });
          </script>";
  }
}

?>
<div class="container"><br>
  <div class="row">
    <div class="col-sm">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="text-center">Catégories des critères <button style="float: right; padding: 0;" class="btn btn-link">Ajouter un critère</button></th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach (getCategoriesCriteres() as $categorie) {
            echo "<form action=\"#\" method=\"POST\">";
            echo '<tr>';
            echo '  <td>'.$categorie["categorie"].'';
            echo "<input type=\"hidden\" name=\"idCategorie\" value=\"".$categorie["idCategorie"]."\">";
            echo ' <button title="Supprimer cette catégorie" name="supprimer" type="submit" class="cross btn">&#10060;</button><button name="action" value="modifierCategorie" style="float: right;" class="btn btn-secondary">Modifier</button> </td>';
            echo '</tr>';
            echo '</form>';
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="text-center">Domaines des projets <button style="float: right; padding: 0;" class="btn btn-link">Ajouter un domaine</button></th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach (getDomaines() as $domaine) {
            echo "<form action=\"#\" method=\"POST\">";
            echo '<tr>';
            echo '  <td>'.$domaine["domaine"].'';
            echo "<input type=\"hidden\" name=\"idDomaine\" value=\"".$domaine["idDomaine"]."\">";
            echo ' <button title="Supprimer cette catégorie" name="supprimer" type="submit" class="cross btn">&#10060;</button><button style="float: right;" type="submit" name="action" value="modifierDomaine" class="btn btn-secondary">Modifier</button> </td>';
            echo '</tr>';
            echo '</form>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br>
  <div class="row">
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="text-center">Prénom</th>
          <th class="text-center">Nom </th>
          <th class="text-center">Email </th>
          <th class="text-center">Statut </th>
          <th class="text-center"><button style="float: right;" class="btn btn-link">Ajouter un utilisateur</button></th>
        </tr>
      </thead>
      <tbody>
        <?php  foreach (getUtilisateurs() as $utilisateur) {
          if ($utilisateur["idUtilisateur"] != $_SESSION["id"]) {
            echo "<form action=\"#\" method=\"POST\">";
            echo '<tr>';
            echo '  <td class="text-center">'.$utilisateur["prenom"].'</td>';
            echo '  <td class="text-center">'.$utilisateur["nom"].'</td>';
            echo '  <td class="text-center">'.$utilisateur["email"].'</td>';
            switch ($utilisateur["statut"]) {
              case 1:
                echo '  <td class="text-center">Administrateur</td>';
                break;
              case 2:
                echo '  <td class="text-center">Enseignant</td>';
                break;
              case 3:
                echo '  <td class="text-center">Elève</td>';
                break;
            }
            echo '<input type="hidden" name="idUtilisateur" value="'.$utilisateur["idUtilisateur"].'">';
            echo '  <td class="text-center"><button style="margin-right: 0px;" title="Supprimer cette catégorie" name="supprimer" type="submit" class="cross btn">&#10060;</button><button type="submit" name="action" value="modifierUtilisateur" class="btn btn-secondary">Modifier</button> </td>';
            echo '</tr>';
            echo '</form>';
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php if (isset($idCategorieAlter)) { ?>
  <!-- Modal de modification d'une catégorie-->
  <div class="modal fade" id="modalModifierCategorie" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateCategorie.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'une catégorie de critère</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Nom de la catégorie</label>
             <input class="form-control" type="text" name="categorie" value="<?php echo $categorieAlter["categorie"]; ?>">
           </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
            <input type="hidden" name="idCategorie" value="<?php echo $idCategorieAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>
<?php if (isset($idDomaineAlter)) { ?>
  <!-- Modal de modification d'un domaine-->
  <div class="modal fade" id="modalModifierDomaine" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateDomaine.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'une catégorie de critère</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Nom de la catégorie</label>
             <input class="form-control" type="text" name="domaine" value="<?php echo $domaineAlter["domaine"]; ?>">
           </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
            <input type="hidden" name="idDomaine" value="<?php echo $idDomaineAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>
<?php if (isset($idUtilisateurAlter)) { ?>
  <!-- Modal de modification d'un utilisateur-->
  <div class="modal fade" id="modalModifierUtilisateur" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateUtilisateur.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'une catégorie de critère</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Nom</label>
             <input class="form-control" type="text" name="nom" value="<?php echo $utilisateurAlter["nom"]; ?>">
           </div>
           <div class="form-group">
             <label for="">Prénom</label>
             <input class="form-control" type="text" name="prenom" value="<?php echo $utilisateurAlter["prenom"]; ?>">
           </div>
           <div class="form-group">
             <label for="">Email</label>
             <input class="form-control" type="text" name="email" value="<?php echo $utilisateurAlter["email"]; ?>">
           </div>
           <div class="form-group">
             <?php switch ($utilisateurAlter["statut"]) {
               case 1:
                echo '<div class="form-group">';
                echo '  <label for="">Statut</label>';
                echo '    <select class="form-control" name="statut">';
                echo '    <option value="1" selected>Administrateur</option>';
                echo '    <option value="2">Enseignant</option>';
                echo '    <option value="3">Elève</option>';
                echo '  </select>';
                echo '</div>';
                break;
               case 2:
                 echo '<div class="form-group">';
                 echo '  <label for="">Statut</label>';
                 echo '    <select class="form-control" name="statut">';
                 echo '    <option value="1">Administrateur</option>';
                 echo '    <option value="2" selected>Enseignant</option>';
                 echo '    <option value="3">Elève</option>';
                 echo '  </select>';
                 echo '</div>';
                 break;
               case 3:
                 echo '<div class="form-group">';
                 echo '  <label for="">Statut</label>';
                 echo '    <select class="form-control" name="statut">';
                 echo '    <option value="1">Administrateur</option>';
                 echo '    <option value="2">Enseignant</option>';
                 echo '    <option value="3" selected>Elève</option>';
                 echo '  </select>';
                 echo '</div>';
                 break;
             }
             ?>
           </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
            <input type="hidden" name="idUtilisateur" value="<?php echo $idUtilisateurAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>
