<?php
include 'model/getProjetById.php';
include 'model/getElevesProjet.php';
include 'model/getEleveToAdd.php';

//Message d'erreur de connexion
if (isset($_SESSION['idProjet']))
{
    $idProjet = $_SESSION['idProjet'];
}

if (!isset($idProjet)) {
  header('Location: inp');
}

$projet = getProjetById($idProjet);

echo "<div class=\"container\" style=\"padding-top: 20px;\">";
echo "  <div class=\"card\">";
echo "   <div class=\"card-body\">";
echo "     <h5 class=\"card-title\" style=\"display: inline-block;\">".$projet["Titre"]."</h5>";
echo "     <p class=\"card-text\"><small class=\"text-muted\">".$projet["Client"]."</small></p>";
echo "     <p class=\"card-text\">".$projet["Description"]."</p>";
echo "     <p class=\"card-text\"><em>Débute le ".$projet["DateDebut"]." et dure ".$projet["DureePrevue"]." semestre(s)</em></p>";
echo "   </div>";
 ?>

</div><br><h3 style=\"text-align: center;\">Gestion du projet</h3>
 <div class="card">
  <div class="card-body">
    <h5 class="card-title" style="display: inline-block;">Elèves</h5>
    <button type="button" class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#modalAjoutEleve">Ajouter des élèves</button><br><br>
<?php
echo "     <div class=\"list-group\">";
if (empty(getElevesProjet($projet["idProjet"]))) {
  echo "<p>Aucun élève n'a été ajouté à ce projet</p>";
}
else {
  foreach (getElevesProjet($projet["idProjet"]) as $eleve) {
    echo "      <a href=\"#\" class=\"list-group-item list-group-item-action\">".$eleve["Prenom"]."  ".$eleve["Nom"]."</a>";
  }

}
echo "     </div>";
echo "   </div>";
?>

 <!-- Modal d'ajout d'eleves -->
 <div class="modal fade" id="modalAjoutEleve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Ajouter des élèves à <?php echo $projet["Titre"]; ?> </h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <p><em>Cliquez sur l'élève que vous voulez ajouter au projet<em></p>
        <div class="list-group">
          <select name="eleveToAdd">
            <?php  foreach (getEleveToAdd($projet["idProjet"]) as $eleve) {
              echo '<button type="submit" class="list-group-item list-group-item-action"><option value="'.$eleve["idUtilisateur"].'">'.$eleve["Prenom"].' '.$eleve["Nom"].'</option></button>';
            }
            ?>
          </select>
        </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
       </div>
     </div>
   </div>
 </div>

</div>
