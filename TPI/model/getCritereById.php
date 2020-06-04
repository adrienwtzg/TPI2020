<?php

function getCritereById($idCritere){
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM criteres WHERE idCritere LIKE ?");
  $query->bindParam(1, $idCritere);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
