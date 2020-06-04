<?php
include 'model/getCategoriesCriteres.php';
include 'model/getAllCriteresByCategories.php';
include 'model/getCritereById.php';


//Détecte un modification ou suppression
if (isset($_POST['action'])) {
  $idCritereAlter = $_POST["idCritere"];
  $critereAlter = getCritereById($idCritereAlter);
  if ($_POST['action'] == 'modifier') {
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalAlterCritereGestion').modal('show');
          });
          </script>";
      //header('Location: index.php?page=projetEvaluation');
  } else if ($_POST['action'] == 'supprimer') {
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalDeleteCritereGestion').modal('show');
          });
          </script>";
  }
  else {
    //invalid action!
  }
}

?>
<script type="text/javascript">
  $(document).ready(function(){

  });
</script>
<div class="container">
  <div class="card">
   <div class="card-body">
     <h5 class="card-title" style="display: inline-block;">Critères</h5>
     <button type="button" class="btn btn-link" style="float: right;" data-toggle="modal" data-target="#modalAjoutCritereGestion">Ajouter un nouveau critère</button>
     <div class="container">
       <?php foreach (getCategoriesCriteres() as $categorie) {
         echo "<h5>".$categorie["categorie"]."</h5>";

         if (!empty(getAllCriteresByCategories($categorie["idCategorie"]))) {
           echo "<ul class=\"list-group\">";
           foreach (getAllCriteresByCategories($categorie["idCategorie"]) as $critere) {
             echo "<li class=\"list-group-item\"><form action=\"#\" method=\"POST\">";
             echo "<input type=\"hidden\" name=\"idCritere\" value=\"".$critere["idCritere"]."\">";
             echo " <small style=\"float: right;\">/ ".$critere["pointsMax"]." pt.</small><h6>".$critere["critere"]."</h6> <p>".$critere["definition"]."<p>";
             echo "<button class=\"btn btn-secondary\" type=\"submit\" name=\"action\" value=\"modifier\">Modifier</button>&nbsp;<button class=\"btn btn-danger\"type=\"submit\" name=\"action\" value=\"supprimer\">Supprimer</button></li>";
             echo "</form>";
           }
           echo "</ul><br><br>";
         }
         else {
           echo "<div class=\"alert alert-secondary\" role=\"alert\">Aucun critères ajoutés pour l'instant</div>";
         }
       } ?>
     </div>
   </div>
 </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalDeleteCritereGestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Etes-vous sur de vouloir supprimer ce critère</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>Une fois supprimé le critère ne sera plus récupérable ainsi que toutes les informations relatant du projet (évaluations, critères associés, etc ...)</p>
      </div>
      <div class="modal-footer">
        <form class="" action="model/deleteCritere.php" method="post">
          <input type="hidden" name="idCritere" value="<?php echo $idCritereAlter; ?>">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Supprimer</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if (isset($critereAlter)) { ?>
  <!-- Modal de modification de critères-->
  <div class="modal fade" id="modalAlterCritereGestion" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateCritere.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'un critère</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Critère</label>
             <input class="form-control" type="text" name="critere" value="<?php echo $critereAlter[0]["critere"]; ?>">
           </div>
           <div class="form-group">
             <label for="">Description</label>
             <textarea class="form-control" name="definition" rows="3"><?php echo $critereAlter[0]["definition"]; ?></textarea>
           </div>
           <div class="form-group">
             <label for="">Points maximum</label>
             <input class="form-control" type="number" name="pointsMax" value="<?php echo $critereAlter[0]["pointsMax"]; ?>">
           </div>
           <div class="form-group">
            <label for="categorie">Catégorie</label>
            <select class="form-control" name="idCategorie">
              <?php
                foreach (getCategoriesCriteres() as $categorie) {
                  if ($categorie["idCategorie"] == $critereAlter[0]["idCategorie"]) {
                    echo '<option value="'.$categorie["idCategorie"].'" selected>'.$categorie["categorie"].'</option>';
                  }
                  else {
                    echo '<option value="'.$categorie["idCategorie"].'">'.$categorie["categorie"].'</option>';
                  }
                }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=criteres';">Annuler</button>
            <input type="hidden" name="idCritere" value="<?php echo $idCritereAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php } ?>

<!-- Modal d'ajout de critères -->
<div class="modal fade" id="modalAjoutCritereGestion" tabindex="0" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" A>Ajouter un nouveau critère</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="model/addNewCritere.php" method="POST">
          <div class="form-group">
            <input type="text" class="form-control" name="critere" placeholder="Nom du critère">
          </div>
          <div class="form-group">
            <textarea rows="3" class="form-control" name="definition" placeholder="Définition du critère"></textarea>
          </div>
          <div class="form-group">
            <input type="number" class="form-control" name="pointsMax" placeholder="Points maximum">
          </div>
          <div class="form-group">
            <label for="categorie">Catégorie du critère</label>
            <select class="form-control" name="idCategorie">
              <?php foreach (getCategoriesCriteres() as $categorie) {
                echo "<option value=\"".$categorie["idCategorie"]."\">".$categorie["categorie"]."</option>";
              }?>
            </select>
          </div>
         <button type="submit" class="btn btn-primary">Ajouter</button>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>
