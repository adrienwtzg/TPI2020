<?php
include 'model/getProjetById.php';
include 'model/getElevesProjet.php';
include 'model/getEleveToAdd.php';

//Récupeère l'id du projet détaillé
if (isset($_SESSION['idProjet']))
{
    $idProjet = $_SESSION['idProjet'];
}
//Message d'erreur du maximum d'élèves atteint
if (isset($_SESSION['maxEleves']))
{
    echo $_SESSION['maxEleves'];
    unset($_SESSION['maxEleves']);
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

</div><br><h3 style="text-align: center;">Gestion du projet</h3>
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
    echo "<form method=\"POST\" action=\"model/deleteEleveProjet.php\" style=\"display: flex;flex-flow: column;  height: 100%;  width: 100%;\">";
    echo "<input type=\"hidden\" name=\"idEleve\" value=\"".$eleve["idUtilisateur"]."\">";
    echo "<input type=\"hidden\" name=\"idProjet\" value=\"".$projet["idProjet"]."\">";
    echo "      <a href=\"#\" style=\"padding-top: 20px;\"  onclick='this.parentNode.submit(); return false;' class=\"list-group-item list-group-item-action\">".$eleve["Prenom"]."  ".$eleve["Nom"]."<button title=\"Supprimer de ce projet\" class=\"cross btn\">&#10060;</button><span style=\"float: right;\" class=\"badge badge-pill badge-secondary\">Non évalué</span></a>";
    echo "</form>";
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
         <form action="model/addEleveToProjet.php" method="POST">
           <div class="form-group">
             <select class="form-control" name="idEleve">
               <?php  foreach (getEleveToAdd($projet["idProjet"]) as $eleve) {
                 echo '<option value="'.$eleve["idUtilisateur"].'">'.$eleve["Prenom"].' '.$eleve["Nom"].'</option>';
               }
               ?>
             </select>
           </div>
           <input type="hidden" name="idProjet" value="<?php echo $projet["idProjet"]; ?>">
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
       </div>
     </div>
   </div>
 </div>

</div>
