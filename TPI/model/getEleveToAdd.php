<?php
require_once('db/databaseConnection.php');

function getEleveToAdd($idProjet){
  //Connexion à la base données
  $db = connectDB();

  //Récupère les utilisateurs pouvant être ajouté au projet
  $query = $db->prepare("SELECT idUtilisateur, nom, prenom FROM utilisateurs WHERE idUtilisateur IN (SELECT idUtilisateur FROM eleves WHERE idEleve NOT IN (SELECT idELeve FROM travaille_pour WHERE idProjet = ?))");
  $query->bindParam(1, $idProjet);

  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
    }
}


?>
