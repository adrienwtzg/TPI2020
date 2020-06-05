<?php
include 'model/getProjetsEleve.php';

//Redirige vers le login si l'utilisateur n'est pas authentifié
if(!isset($_SESSION["log"])) {
  header('Location: index.php');
}
?>
<div class="container" style="float:right;">
    <div class="row mt-3">
    <?php
    //Affiche les projets un après l'autre
    foreach (GetProjetsEleve() as $projet) {
      //Rogne la description sur la miniature pour n'afficher qu'une ligne
      if (strlen($projet["description"]) > 32) {
        $projet["description"] = substr($projet["description"], 0, 30) . " ...";
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
