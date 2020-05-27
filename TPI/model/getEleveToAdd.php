<?php
require_once('db/databaseConnection.php');

function getEleveToAdd($idProjet){
  //Connexion à la base données
  $db = connectDB();

  //Récupère les utilisateurs pouvant être ajouté au projet
  $query = $db->prepare("SELECT * FROM utilisateurs WHERE Statut = 3 AND idUtilisateur NOT IN
                       (SELECT idUtilisateur FROM travaille_pour LEFT JOIN utilisateurs ON idUtilisateur = idEleve WHERE idProjet = ?)");
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
