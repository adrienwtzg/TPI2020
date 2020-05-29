<?php
require_once('db/databaseConnection.php');

function getEleveToAdd($idProjet){
  //Connexion à la base données
  $db = connectDB();

  //Récupère les utilisateurs pouvant être ajouté au projet
  $query = $db->prepare("SELECT * FROM utilisateurs WHERE statut = 3 AND idUtilisateur NOT IN (SELECT idUtilisateur FROM eleves WHERE eleves.idEleve IN (SELECT idEleve FROM travaille_pour WHERE travaille_pour.idProjet = 2))");
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
