<?php
require_once('db/databaseConnection.php');

function getProjetById($id){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM projets WHERE idProjet = ?");
  $query->bindParam(1, $id);

  if ($query->execute()) {
    $tab = $query->fetch(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
    }
}

?>
