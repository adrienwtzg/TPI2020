<?php
include 'model/getProjetById.php';

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
echo "     <button type=\"button\" class=\"btn btn-success\" style=\"float: right;\">Ajouter des élèves</button>";
echo "     <p class=\"card-text\"><small class=\"text-muted\">".$projet["Client"]."</small></p>";
echo "     <p class=\"card-text\">".$projet["Description"]."</p>";
echo "     <p class=\"card-text\"><em>Débute le ".$projet["DateDebut"]." et dure ".$projet["DureePrevue"]." semestre(s)</em></p>";
echo "   </div>";
echo " </div><br>";
echo "  <div class=\"card\">";
echo "   <div class=\"card-body\">";
echo "     <h5 class=\"card-title\" style=\"display: inline-block;\">Elèves du projet</h5>";
echo "     <div class=\"list-group\">";
echo "       <a href=\"#\" class=\"list-group-item list-group-item-action\">Adrien Witzig</a>";
echo "     </div>";
echo "   </div>";
echo " </div>";
echo "</div>";

 ?>
