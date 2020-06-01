<?php

function getCriteresByCategories($idCategorie, $idProjet) {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM criteres INNER JOIN criteres_projets ON criteres.idCritere = criteres_projets.idCritere WHERE idProjet = ? AND idCategorie = ?");
  $query->bindParam(1, $idProjet);
  $query->bindParam(2, $idCategorie);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
