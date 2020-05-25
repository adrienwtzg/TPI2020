<?php
require_once('db/databaseConnection.php');

function GetProjets()
{
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM projets");

  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
  }
}


?>
