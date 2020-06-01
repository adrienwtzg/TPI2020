<?php


function getCriteresToAdd($idProjet, $idCategorie) {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM criteres WHERE idCategorie = ? AND idCritere NOT IN (SELECT criteres.idCritere FROM criteres INNER JOIN criteres_projets ON criteres.idCritere = criteres_projets.idCritere
                        WHERE idProjet = ?)");
  $query->bindParam(1, $idCategorie);
  $query->bindParam(2, $idProjet);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
