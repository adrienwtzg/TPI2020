<?php
require_once('db/databaseConnection.php');

function getElevesProjet($idProjet){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT utilisateurs.idUtilisateur, utilisateurs.nom, utilisateurs.prenom FROM travaille_pour LEFT JOIN eleves ON travaille_pour.idEleve = eleves.idEleve LEFT JOIN utilisateurs ON eleves.idUtilisateur = utilisateurs.idUtilisateur WHERE travaille_pour.idProjet = ?
");
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
