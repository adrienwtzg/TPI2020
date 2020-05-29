<?php
//Fonction de récupération des projets de l'enseignant
include 'model/getProjets.php';

//Redirige vers le login si l'utilisateur n'est pas authentifié
if(!isset($_SESSION["log"])) {
  header('Location: index.php');
}

?>
<button type="button" class="btn btn-success" style=" margin: 20px;" data-toggle="modal" data-target="#modalAjoutProjets">Ajouter un projet</button>

<div class="container" style="float:right;">
    <div class="row mt-3">
    <?php
    //Affiche les projets un après l'autre
    foreach (GetProjets() as $projet) {
      //Rogne la description sur la miniature pour n'afficher qu'une ligne
      if (strlen($projet["description"]) > 32) {
        $projet["descritption"] = substr($projet["description"], 0, 30) . " ...";
      }
      echo "<div class=\"card card-custom mx-2 mb-3\" style=\"width: 18rem;\">";
      echo "<div class=\"card-body\">";
      echo "<h5 class=\"card-title\">".$projet["titre"]."</h5>";
      echo "<h6 class=\"card-subtitle mb-2 text-muted\">".$projet["client"]."</h6>";
      echo "<p class=\"card-text\">".$projet["description"]."</p>";
      echo "<form method=\"POST\" action=\"model/afficheDetailGestion.php\">";
      echo "<button type=\"submit\" class=\"btn btn-primary\">Aller à</button>";
      echo '<input type="hidden" name="idProjet" value="'.$projet["idProjet"].'"/>';
      echo "</form>";
      echo "</div>";
      echo "</div>&nbsp;";
    } ?>
  </div>
</div>

<!-- Modal d'ajout de projet -->
<div class="modal fade" id="modalAjoutProjets" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un projet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="model/addProject.php" method="POST">
          <div class="form-group">
            <input type="text" class="form-control" name="Titre" placeholder="Titre du projet">
          </div>
          <div class="form-group">
            <textarea class="form-control" name="Description" rows="4" placeholder="Description du projet"></textarea>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="Client" placeholder="Client du projet">
          </div>
          <div class="form-group">
            <label for="duree">Durée du projet (en semestres)</label>
            <input type="number" min="0.5" max="2" step="0.5" value="0" class="form-control" name="DureePrevue" style="width: 200px;">
          </div>
          <div class="form-group">
              <label for="">Date début</label>
             <input class="form-control" type="date" name="DateDebut">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </div>
    </form>
    </div>
  </div>
</div>
