  <?php
  include 'model/getProjetById.php';
  include 'model/getElevesProjet.php';
  include 'model/getEleveToAdd.php';
  include 'model/checkProjetExist.php';
  include 'model/getCategoriesCriteres.php';
  include 'model/getCriteresByCategories.php';

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
  echo "     <button type=\"button\" title=\"Domaine du projet\" style=\"float: right;\" class=\"btn btn-outline-primary\" disabled>Web</button>";
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
      echo "<form method=\"POST\" action=\"model/deleteEleveProjet.php\" style=\"display: flex;flex-flow: column;  height: 100%;  width: 100%;\">";
      echo "<input type=\"hidden\" name=\"idUtilisateur\" value=\"".$eleve["idUtilisateur"]."\">";
      echo "<input type=\"hidden\" name=\"idProjet\" value=\"".$projet["idProjet"]."\">";
      echo "      <a href=\"#\" style=\"padding-top: 20px;\"  onclick='this.parentNode.submit(); return false;' class=\"list-group-item list-group-item-action\">".$eleve["prenom"]."  ".$eleve["nom"]."<button title=\"Supprimer de ce projet\" class=\"cross btn\">&#10060;</button><button style=\"float: right;\" class=\"btn btn-success\">Evaluer</button><p class=\"text-danger\">Non évalué</p></a>";
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
     <button type="button" class="btn btn-link" style="float: right;" data-toggle="modal" data-target="#modalAjoutCritere">Ajouter un  nouveau critère</button>
     <button type="button" class="btn btn-link" style="float: right;" data-toggle="modal" data-target="#modalAjoutEleve">Ajouter un critère existant</button><br><br>
     <div class="container">
       <?php foreach (getCategoriesCriteres() as $categorie) {
         echo "<h5>".$categorie["categorie"]."</h5>";
         echo "<ul class=\"list-group\">";
         foreach (getCriteresByCategories($categorie["idCategorie"]) as $critere) {
           echo "<li class=\"list-group-item\"> <small style=\"float: right;\">".$critere["pointsMax"]." points maximum</small><h6>".$critere["critere"]."</h6> <p>".$critere["definition"]."<p></li>";
         }
         echo "</ul><br><br>";
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
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel"><?php echo $projet["titre"]; ?></h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
          <div class="form-group">
            <label for="">Titre</label>
            <input class="form-control" type="text" name="Titre" value="<?php echo $projet["titre"]; ?>">
          </div>
          <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" name="Description" rows="3"><?php echo $projet["description"]; ?></textarea>
          </div>
          <div class="form-group">
            <label for="">Client</label>
            <input class="form-control" type="text" name="Client" value="<?php echo $projet["client"]; ?>">
          </div>
          <div class="form-group">

          </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>

         </div>
       </div>
     </div>
   </div>

   <!-- Modal d'ajout de critères -->
   <div class="modal fade" id="modalAjoutCritere" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau critère à <?php echo $projet["titre"]; ?> </h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <form action="model/addNewCritere.php" method="POST">
             <div class="form-group">
               <input type="text" class="form-control" placeholder="Nom du critère">
             </div>
             <div class="form-group">
               <textarea rows="3" class="form-control" placeholder="Définition du critère"></textarea>
             </div>
             <div class="form-group">
               <input type="number" class="form-control" placeholder="Points maximum">
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
