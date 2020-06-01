<?php

function checkProjetExist($idProjet) {
  $db = connectDB();
  $query = $db->prepare("SELECT * FROM projets WHERE idProjet = ?");
  $query->bindParam(1, $idProjet);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($tab)) {
      return false;
    }
    else {
      return true;
    }
  }
  else {
    // code...
  }
}

?>
