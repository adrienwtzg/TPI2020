<?php
require_once('db/databaseConnection.php');

function GetProjets()
{
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM projets WHERE idEnseignant = ?");
  $query->bindParam(1, $_SESSION["id"]);

  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
  }
}


?>
