<?php

function getUtilisateurById($idUtilisateur){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM utilisateurs WHERE idUtilisateur = ?");
  $query->bindParam(1, $idUtilisateur);

  if ($query->execute()) {
    $tab = $query->fetch(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
    }
}

?>
