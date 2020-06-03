<?php
include 'model/getCategoriesCriteres.php';
include 'model/getCriteresByCategories.php';
include 'model/getEleveByUtilisateur.php';
include 'model/getInfoEleve.php';

$idProjet = $_SESSION["idProjetEvaluer"];
$idUtilisateur = $_SESSION["idUtilisateurEvaluer"];
$idEleve = getEleveByUtilisateur($idUtilisateur)[0]["idEleve"];
$infoEleve = getInfoEleve($idEleve);

?>
  <div class="card">
   <div class="card-body">
     <h3 class="card-title text-center">Evaluation de <?php echo $infoEleve["prenom"]. " ".$infoEleve["nom"]; ?></h3><br><br>

     <div class="container">
       <form class="" action="model/evaluer.php" method="post">
         <input type="hidden" name="idProjet" value="<?php echo $idProjet; ?>">
         <input type="hidden" name="idEleve" value="<?php echo $idEleve;?>">
         <?php
           foreach (getCategoriesCriteres() as $categorie) {
             if (!empty(getCriteresByCategories($categorie["idCategorie"], $idProjet))) {
               echo "<h5>".$categorie["categorie"]."</h5>";
               echo "<ul class=\"list-group\">";
               foreach (getCriteresByCategories($categorie["idCategorie"], $idProjet) as $critere) {
                 echo "<input type=\"hidden\" name=\"idCriteres[]\" value=\"".$critere["idCritere"]."\">";
                 echo "<li class=\"list-group-item\"><small style=\"float: right;\">&nbsp;&nbsp;/ ".$critere["pointsMax"]." pt.</small><input name=\"pointsObtenus[]\" style=\"float: right;\" type=\"number\" onKeyPress=\"if(this.value.length==2) return false;\" min=\"0\" max=\"".$critere["pointsMax"]."\" required><h6>".$critere["critere"]."</h6> <p>".$critere["definition"]."<p>";
                 echo "<textarea rows=\"3\" name=\"commentaires[]\" class=\"form-control\" placeholder=\"Commentaire\"></textarea>";
               }
               echo "</ul><br><br>";
             }
             else {
             }
           }

         ?>
         <button type="submit" class="btn btn-success">Valider</button>
       </form>
     </div>
   </div>
 </div>
