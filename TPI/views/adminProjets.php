<?php
include 'model/getAllProjets.php';
include 'model/getProjetById.php';
include 'model/getDomaines.php';

//Redirige vers le login si l'utilisateur n'est pas authentifié
if(!isset($_SESSION["log"])) {
  header('Location: index.php?page=login');
}

//detection ajout/modification/suppression de catégories, domaines et utilisateurs
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'modifierProjet') {
    $idProjetAlter = $_POST["idProjet"];
    $projetAlter = getProjetById($idProjetAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalModifierProjet').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'supprimerProjet') {
    $idProjetAlter = $_POST["idProjet"];
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalSupprimerProjet').modal('show');
          });
          </script>";
  }
}

//Message d'erreur suppression utilisateurs
if (isset($_SESSION["messageErreur"])) {
  echo $_SESSION["messageErreur"];
  unset($_SESSION["messageErreur"]);
}

//Message d'erreur si le nom et le prénom de l'utilisateur à ajouter existe déja
if (isset($_SESSION["messageMemeNomUtilisateur"])) {
  echo $_SESSION["messageMemeNomUtilisateur"];
  unset($_SESSION["messageMemeNomUtilisateur"]);
}
?>
<div class="container"><br>
  <div style="text-align: center;">
    <h3>Gestion des projets</h3>
  </div>
  <div class="row">
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="text-center">Titre</th>
          <th class="text-center">Description </th>
          <th class="text-center">Client </th>
          <th class="text-center">Durée prévue </th>
          <th class="text-center">Date de début </th>
        </tr>
      </thead>
      <tbody>
        <?php  foreach (getAllProjets() as $projet) {
            echo "<form action=\"#\" method=\"POST\">";
            echo '<tr>';
            echo '  <td class="text-center">'.$projet["titre"].'</td>';
            echo '  <td class="text-center">'.$projet["description"].'</td>';
            echo '  <td class="text-center">'.$projet["client"].'</td>';
            echo '  <td class="text-center">'.$projet["dureePrevue"].' semestre(s)</td>';
            echo '  <td class="text-center">'.$projet["dateDebut"].'</td>';
            echo '<input type="hidden" name="idProjet" value="'.$projet["idProjet"].'">';
            echo '  <td class="text-center"><button style="margin-right: 0px;" title="Supprimer ce projet" name="action" value="supprimerProjet" type="submit" class="cross btn">&#10060;</button><button type="submit" name="action" value="modifierProjet" class="btn btn-secondary">Modifier</button> </td>';
            echo '</tr>';
            echo '</form>';
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

  <!-- Modal de modification d'un projet-->
  <div class="modal fade" id="modalModifierProjet" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateProjet.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'un projet</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Titre</label>
             <input class="form-control" type="text" name="titre" value="<?php echo $projetAlter["titre"]; ?>" required>
           </div>
           <div class="form-group">
             <label for="">Description</label>
             <textarea class="form-control" name="description" rows="3" required><?php echo $projetAlter["description"]; ?></textarea>
           </div>
           <div class="form-group">
             <label for="">Client</label>
             <input class="form-control" type="text" name="client" value="<?php echo $projetAlter["client"]; ?>" required>
           </div>
           <div class="form-group">
             <label for="duree">Durée du projet</label>
               <?php if ($projetAlter["dureePrevue"] == 1) {  ?>
             <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" value="1" name="dureePrevue" checked>1 semestre
               </label>
             </div>
             <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" value="2" name="dureePrevue">2 semestres
               </label>
             </div>
           <?php }else { ?>
             <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" value="1" name="dureePrevue">1 semestre
               </label>
             </div>
             <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" value="2" name="dureePrevue" checked>2 semestres
               </label>
             </div>
           <?php } ?>
           </div>
           <div class="form-group">
               <label for="">Date début</label>
              <input class="form-control" type="date" value="<?php echo $projetAlter["dateDebut"]; ?>" name="dateDebut">
           </div>
           <div class="form-group">
            <label for="categorie">Domaine</label>
            <select class="form-control" name="idDomaine">
              <?php
                foreach (getDomaines() as $domaine) {
                  if ($domaine["idDomaine"] == $projetAlter["idDomaine"]) {
                    echo '<option value="'.$domaine["idDomaine"].'" selected>'.$domaine["domaine"].'</option>';
                  }
                  else {
                    echo '<option value="'.$domaine["idDomaine"].'">'.$domaine["domaine"].'</option>';
                  }
                }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projetDetail';">Annuler</button>
            <input type="hidden" name="idProjet" value="<?php echo $idProjetAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal de suppression d'un projet-->
<div class="modal fade" id="modalSupprimerProjet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer ce projet ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <p>Une fois supprimé le ne sera plus récupérable. De plus, toutes les informations relatant du projet (association d'élève/critères, évalautions) seront aussi supprimées.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <form action="model/deleteProjet.php" method="POST">
          <input type="hidden" name="idProjet" value="<?php echo $idProjetAlter; ?>">
          <input type="hidden" name="page" value="admin">
          <button type="submit" class="btn btn-primary">Supprimer</button>
        </form>
      </div>
    </div>
  </div>
</div>
