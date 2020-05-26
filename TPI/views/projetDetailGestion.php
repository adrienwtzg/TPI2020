<?php
//Message d'erreur de connexion
if (isset($_SESSION['idProjet']))
{
    $idProjet = $_SESSION['idProjet'];
}

if (!isset($idProjet)) {
  header('Location: inp');
}

echo "<div class=\"container\" style=\"padding-top: 20px;\">";
echo "  <div class="card">";
echo "   <div class="card-body">";
echo "     <h5 class="card-title">Card title</h5>";
echo "     <p class="card-text"></p>";
echo "     <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>";
echo "   </div>";
echo " </div>";
echo "</div>";

 ?>
