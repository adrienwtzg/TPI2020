<?php

function getCritereProjet($idProjet) {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM criteres INNER JOIN criteres_projets ON criteres.idCritere = criteres_projets.idCritere WHERE idProjet = ?");
  $query->bindParam(1, $idProjet);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
