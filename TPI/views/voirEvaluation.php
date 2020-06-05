<?php
include 'model/getCategoriesCriteres.php';
include 'model/getCriteresByCategories.php';
include 'model/getEleveByUtilisateur.php';
include 'model/getInfoEleve.php';
include 'model/getEvaluations.php';
include 'model/getNote.php';

$idProjet = $_SESSION["idProjetEvaluer"];
$idUtilisateur = $_SESSION["idUtilisateurEvaluer"];
$idEleve = getEleveByUtilisateur($idUtilisateur)[0]["idEleve"];
$infoEleve = getInfoEleve($idEleve);

?>
  <div class="card">
   <div class="card-body">
     <h3 class="card-title text-center">Evaluation de <?php echo $infoEleve["prenom"]. " ".$infoEleve["nom"]; ?></h3><br><br>

     <div class="container">
         <?php
          $pointsObtenus = 0;
          $pointsTotal = 0;
           foreach (getCategoriesCriteres() as $categorie) {
             if (!empty(getCriteresByCategories($categorie["idCategorie"], $idProjet))) {
               echo "<h5>".$categorie["categorie"]."</h5>";
               echo "<ul class=\"list-group\">";
               foreach (getEvaluations($idEleve, $idProjet, $categorie["idCategorie"]) as $evaluation) {
                 $pointsObtenus += $evaluation["pointsObtenus"];
                 $pointsTotal += $evaluation["pointsMax"];

                 echo "<input type=\"hidden\" name=\"idCriteres[]\" value=\"".$evaluation["idCritere"]."\">";
                 echo "<li class=\"list-group-item\"><p style=\"float: right;\">&nbsp;&nbsp;<b>".$evaluation["pointsObtenus"]."</b> / ".$evaluation["pointsMax"]." pt.</p><h6>".$evaluation["critere"]."</h6> <p>".$evaluation["definition"]."<p>";
                 echo "<label><em>Commentaire de l'enseignant</em></label>";
                 echo "<textarea rows=\"3\" name=\"commentaires[]\" class=\"form-control\" readonly>".$evaluation["observation"]."</textarea>";
               }
               echo "</ul><br><br>";
             }
             else {
             }
           }

         ?>
         <button style="float: right;" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteEvaluation">Supprimer l'évaluation</button>
         <button type="submit" name="button"></button>
         <h6>Total des points <b style="border: 1px solid black; padding: 5px;"><?php echo $pointsObtenus." / ".$pointsTotal; ?></b></h6>
         <h4>Note <b style="border: 1px solid black; padding-right: 10px;padding-left: 10px;"><?php echo getNote($idEleve, $idProjet); ?></b></h4>
     </div>
   </div>
 </div>

 <!-- Modal de suppression de l'évaluation-->
 <div class="modal fade" id="modalDeleteEvaluation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer cette évaluation ?</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
        <p>Une fois supprimé l'évaluation ne sera plus récupérable.</p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
         <form action="model/deleteEvaluation.php" method="POST">
           <input type="hidden" name="idProjet" value="<?php echo $idProjet; ?>">
           <input type="hidden" name="idEleve" value="<?php echo $idEleve; ?>">
           <button type="submit" class="btn btn-primary">Supprimer</button>
         </form>
       </div>
     </div>
   </div>
 </div>
