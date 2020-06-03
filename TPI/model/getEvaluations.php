<?php

function getEvaluations($idEleve, $idProjet, $idCategorie) {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM evaluations INNER JOIN criteres ON evaluations.idCritere = criteres.idCritere WHERE idEleve = ? AND idProjet = ? AND idCategorie = ?");
  $query->bindParam(1, $idEleve);
  $query->bindParam(2, $idProjet);
  $query->bindParam(3, $idCategorie);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
