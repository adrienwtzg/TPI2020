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
         <button type="submit" style="float: right;" class="btn btn-danger" name="button">Supprimer l'évaluation</button>
         <h6>Total des points <b style="border: 1px solid black; padding: 5px;"><?php echo $pointsObtenus." / ".$pointsTotal; ?></b></h6>
         <h4>Note <b style="border: 1px solid black; padding-right: 10px;padding-left: 10px;"><?php echo getNote($idEleve, $idProjet); ?></b></h4>
     </div>
   </div>
 </div>
