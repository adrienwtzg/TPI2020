  <?php
  include 'model/getProjetById.php';
  include 'model/getElevesProjet.php';
  include 'model/getEleveToAdd.php';
  include 'model/checkProjetExist.php';
  include 'model/getCategoriesCriteres.php';
  include 'model/getCriteresByCategories.php';
  include 'model/getCriteresToAdd.php';
  include 'model/deleteEleveProjet.php';
  include 'model/estEvalue.php';
  include 'model/getNote.php';
  include 'model/getDomaines.php';
  include 'model/getDomaineById.php';
  include 'model/deleteCritereProjet.php';

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'evaluer') {
      $_SESSION['idProjetEvaluer'] = $_POST['idProjet'];
      $_SESSION['idUtilisateurEvaluer'] = $_POST['idUtilisateur'];
      header('Location: index.php?page=projetEvaluation');
  } else if ($_POST['action'] == 'supprimer') {
      deleteEleveProjet($_POST['idUtilisateur'], $_POST['idProjet']);
  } else if ($_POST['action'] == 'voirEvaluation') {
    $_SESSION['idProjetEvaluer'] = $_POST['idProjet'];
    $_SESSION['idUtilisateurEvaluer'] = $_POST['idUtilisateur'];
    header('Location: index.php?page=voirEvaluation');
  }
  else if ($_POST['action'] == 'enlever') {
    deleteCritereProjet($_POST['idProjet'], $_POST['idCritere']);
  }
  else {
    //invalid action!
  }
}

  //Récupère l'id du projet détaillé
  if (isset($_SESSION['idProjet']))
  {
    $idProjet = $_SESSION['idProjet'];
    //Vérifie si le projet existe
    if (!checkProjetExist($idProjet)) {
      //envoie sur la page des projets
      header('Location: index.php?page=projets');
    }

  }
  else {

  }
  //Message d'erreur du maximum d'élèves atteint
  if (isset($_SESSION['maxEleves']))
  {
      echo $_SESSION['maxEleves'];
      unset($_SESSION['maxEleves']);
  }

  $projet = getProjetById($idProjet);

  echo "<div class=\"container\" style=\"padding-top: 20px;\">";
  echo "  <div class=\"card\">";
  echo "   <div class=\"card-body\">";
  echo "     <h5 class=\"card-title\" style=\"display: inline-block;\">".$projet["titre"]."</h5>";
  echo "     <button type=\"button\" title=\"Domaine du projet\" style=\"float: right;\" class=\"btn btn-outline-primary\" disabled>".getDomaineById($projet["idDomaine"])["domaine"]."</button>";
  echo "     <p class=\"card-text\"><small class=\"text-muted\">".$projet["client"]."</small></p>";
  echo "     <p class=\"card-text\">".$projet["description"]."</p>";
  echo "     <p class=\"card-text\"><em>Débute le ".$projet["dateDebut"]." et dure ".$projet["dureePrevue"]." semestre(s)</em></p>";
  echo "     <button class=\"btn btn-secondary\" data-toggle=\"modal\" data-target=\"#modalAlterProjet\">Modifier le projet</button>";
  echo "     <button class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#modalDeleteProjet\">Supprimer le projet</button>";
  echo "   </div>";
   ?>

  </div><br><h3 style="text-align: center;">Gestion du projet</h3>
   <div class="card">
    <div class="card-body">
      <h5 class="card-title" style="display: inline-block;">Elèves</h5>
      <button type="button" class="btn btn-link" style="float: right;" data-toggle="modal" data-target="#modalAjoutEleve">Ajouter des élèves</button><br><br>
  <?php
  echo "     <div class=\"list-group\">";
  if (empty(getElevesProjet($projet["idProjet"]))) {
    echo "<p>Aucun élève n'a été ajouté à ce projet</p>";
  }
  else {
    foreach (getElevesProjet($projet["idProjet"]) as $eleve) {
      echo "<form method=\"POST\" action=\"index.php?page=projetDetail\" style=\"display: flex;flex-flow: column;  height: 100%;  width: 100%;\">";
      echo "<input type=\"hidden\" name=\"idUtilisateur\" value=\"".$eleve["idUtilisateur"]."\">";
      echo "<input type=\"hidden\" name=\"idProjet\" value=\"".$projet["idProjet"]."\">";
      echo "      <a href=\"#\" style=\"padding-top: 20px;\" class=\"list-group-item list-group-item-action\">".$eleve["prenom"]."  ".$eleve["nom"]."";
      if (!estEvalue($eleve["idEleve"], $idProjet)) {
        echo "<button title=\"Supprimer de ce projet\" name=\"action\" value=\"supprimer\" class=\"cross btn\">&#10060;</button><button style=\"float: right;\" type=\"submit\" name=\"action\" value=\"evaluer\" class=\"btn btn-success\">Evaluer</button><p class=\"text-danger\">Non évalué</p>   </a>";
      }
      else {
        $critereBloque = true;
        echo "<button style=\"float: right;\" type=\"submit\" name=\"action\" value=\"voirEvaluation\" class=\"btn btn-primary\">Voir évaluation</button><button class=\"btn btn-outline-dark\" style=\"float: right; margin-right: 10px;\" disabled>Note: ".getNote($eleve["idEleve"], $idProjet)."</button><p class=\"text-success\">Evalué</p>   </a>";
      }

      echo "</form>";
    }
  }
  echo "     </div>";
  echo "   </div></div>";
  ?>
  <br>
  <div class="card">
   <div class="card-body">
     <h5 class="card-title" style="display: inline-block;">Critères</h5>
     <?php
      if (!isset($critereBloque)) {
        echo '<button type="button" class="btn btn-link" style="float: right;" data-toggle="modal" data-target="#modalAjoutCritereExistant">Ajouter un critère existant</button><br><br>';
      }
     ?>
     <div class="container">
       <?php foreach (getCategoriesCriteres() as $categorie) {
         echo "<h5>".$categorie["categorie"]."</h5>";

         if (!empty(getCriteresByCategories($categorie["idCategorie"], $idProjet))) {
           echo "<ul class=\"list-group\">";
           foreach (getCriteresByCategories($categorie["idCategorie"], $idProjet) as $critere) {
             echo '';
             if (!isset($critereBloque)) {
               $critereBouton = "<form action=\"#\" method=\"POST\"><input type=\"hidden\" name=\"idCritere\" value=\"".$critere["idCritere"]."\"><input type=\"hidden\" name=\"idProjet\" value=\"".$projet["idProjet"]."\"><button style=\"float: right;\" title=\"Supprimer de ce projet\" name=\"action\" value=\"enlever\" class=\"cross btn\">&#10060;</button></form>";
             }
             else {
               $critereBouton = "";
             }
             echo "<li class=\"list-group-item\"> <small style=\"float: right;\">/ ".$critere["pointsMax"]." pt.</small><h6>".$critere["critere"]."</h6> <p style=\"margin-bottom: 0px;\">".$critere["definition"]."<p>".$critereBouton."</li>";
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

   <!-- Modal d'ajout d'eleves -->
   <div class="modal fade" id="modalAjoutEleve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Ajouter des élèves à <?php echo $projet["titre"]; ?> </h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <form action="model/addEleveToProjet.php" method="POST">
             <div class="form-group">
               <select class="form-control" name="idUtilisateur">
                 <?php  foreach (getEleveToAdd($projet["idProjet"]) as $eleve) {
                   echo '<option value="'.$eleve["idUtilisateur"].'">'.$eleve["prenom"].' '.$eleve["nom"].'</option>';
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

   <!-- Modal de suppression de projet-->
   <div class="modal fade" id="modalDeleteProjet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer ce projet ?</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
          <p>Une fois supprimé le projet ne sera plus récupérable ainsi que toutes les informations relatant du projet (évaluations, critères associés, etc ...)</p>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
           <form action="model/deleteProjet.php" method="POST">
             <input type="hidden" name="idProjet" value="<?php echo $projet["idProjet"]; ?>">
             <button type="submit" class="btn btn-primary">Supprimer</button>
           </form>
         </div>
       </div>
     </div>
   </div>

   <!-- Modal de modification de projet-->
   <div class="modal fade" id="modalAlterProjet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <form action="model/updateProjet.php" method="POST">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Modification de <?php echo $projet["titre"]; ?></h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
            <div class="form-group">
              <label for="">Titre</label>
              <input class="form-control" type="text" name="titre" value="<?php echo $projet["titre"]; ?>" required>
            </div>
            <div class="form-group">
              <label for="">Description</label>
              <textarea class="form-control" name="description" rows="3" required><?php echo $projet["description"]; ?></textarea>
            </div>
            <div class="form-group">
              <label for="">Client</label>
              <input class="form-control" type="text" name="client" value="<?php echo $projet["client"]; ?>" required>
            </div>
            <div class="form-group">
              <label for="duree">Durée du projet</label>
                <?php if ($projet["dureePrevue"] == 1) {  ?>
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
               <input class="form-control" type="date" value="<?php echo $projet["dateDebut"]; ?>" name="dateDebut">
            </div>
            <div class="form-group">
             <label for="categorie">Domaine</label>
             <select class="form-control" name="idDomaine">
               <?php
                 foreach (getDomaines() as $domaine) {
                   if ($domaine["idDomaine"] == $projet["idDomaine"]) {
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
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
             <input type="hidden" name="idProjet" value="<?php echo $idProjet; ?>">
             <button type="submit" class="btn btn-primary">Enregistrer</button>

           </div>
         </form>
       </div>
     </div>
   </div></div>



 <!-- Modal d'ajout d'un critère existant -->
 <div class="modal fade" id="modalAjoutCritereExistant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Ajouter des critères à <?php echo $projet["titre"]; ?> </h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <form action="model/addCritereToProjet.php" method="POST">
           <div class="form-group">
             <?php foreach (getCategoriesCriteres() as $categorie) {
               echo "<h5>".$categorie["categorie"]."</h5><br>";
               echo "<div class=\"list-group\">";
               foreach (getCriteresToAdd($idProjet, $categorie["idCategorie"]) as $critere) {
                 echo " <div class=\"form-check\">";
                 echo "  <input class=\"form-check-input\" style=\"margin-top: 37px;\" type=\"checkbox\" value=\"".$critere["idCritere"]."\" name=\"idCritere[]\">";
                 echo "  <li class=\"list-group-item\"><small style=\"float: right;\">".$critere["pointsMax"]."</small><h6>".$critere["critere"]."</h6> <p>".$critere["definition"]."<p></li>";
                 echo " </div>";
               }
               echo "</div>";
               echo "<br><br>";
             } ?>
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
