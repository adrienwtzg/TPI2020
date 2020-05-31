<?php
require_once('../db/databaseConnection.php');

function getCritereIdByName($nomCritere) {
  $db = connectDB();
  $query = $db->prepare("SELECT idCritere FROM criteres WHERE critere LIKE ?");
  $query->bindParam(1, $nomCritere);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab[0]["idCritere"];
  }
  else {
    // code...
  }
}

?>
