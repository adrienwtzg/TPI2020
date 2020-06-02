<?php

function estEvalue($idEleve, $idProjet) {
  $db = connectDB();
  $query = $db->prepare("SELECT estEvalue FROM travaille_pour WHERE idEleve = ? AND idProjet = ?");
  $query->bindParam(1, $idEleve);
  $query->bindParam(2, $idProjet);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    if ($tab[0]["estEvalue"] == "1") {
      return true;
    }
    else {
      return false;
    }
  }
  else {
    // code...
  }
}

?>
