<?php
require_once('../db/databaseConnection.php');

function getEleveByUtilisateur($idUtilisateur) {
  $db = connectDB();
  $query = $db->prepare("SELECT idEleve FROM eleves WHERE idUtilisateur = ?");
  $query->bindParam(1, $idUtilisateur);
  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    // code...
  }
}

?>
