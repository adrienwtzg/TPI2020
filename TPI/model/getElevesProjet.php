<?php
require_once('db/databaseConnection.php');

function getElevesProjet($idProjet){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM utilisateurs LEFT JOIN travaille_pour ON idUtilisateur = idEleve WHERE idProjet = ?");
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
