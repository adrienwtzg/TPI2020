<?php
include 'model/getProjets.php';

if(!isset($_SESSION["log"])) {
  header('Location: index.php');
}

?>
<button type="button" class="btn btn-success" style=" margin: 20px;" data-toggle="modal" data-target="#modalAjoutProjets">Ajouter un projet</button>

<div class="container">
    <div class="row mt-3">
    <?php
    foreach (GetProjets() as $projet) {
      if (strlen($projet["Description"]) > 32) {
        $projet["Description"] = substr($projet["Description"], 0, 30) . " ...";
      }
      echo "<div class=\"card card-custom mx-2 mb-3\" style=\"width: 18rem;\">";
      echo "<div class=\"card-body\">";
      echo "<h5 class=\"card-title\">".$projet["Titre"]."</h5>";
      echo "<h6 class=\"card-subtitle mb-2 text-muted\">".$projet["Client"]."</h6>";
      echo "<p class=\"card-text\">".$projet["Description"]."</p>";
      echo "<button type=\"button\" class=\"btn btn-primary\">Aller à</button>";
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


<!-- Modal d'ajout d'élèves au projet -->
<div class="modal fade" id="modalAjoutProjets" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter des élèves</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </div>
    </form>
    </div>
  </div>
</div>
