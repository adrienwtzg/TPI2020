<?php

function getNote($idEleve, $idProjet) {
  $db = connectDB();
  $query = $db->prepare("SELECT SUM(pointsObtenus) as currentPt, SUM(criteres.pointsMax) as totalPt FROM evaluations INNER JOIN criteres ON evaluations.idCritere = criteres.idCritere WHERE idEleve = ? AND idProjet = ?");
  $query->bindParam(1, $idEleve);
  $query->bindParam(2, $idProjet);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    $note = round($tab[0]["currentPt"] / $tab[0]["totalPt"] * 5 + 1, 1);
    return $note;
  }
  else {
    // code...
  }
}

?>
