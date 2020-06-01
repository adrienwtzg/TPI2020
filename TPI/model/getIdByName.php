<?php

function GetIdByName($prenom, $nom){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT idUtilisateur FROM utilisateurs WHERE Prenom LIKE ? AND Nom LIKE ?");
  $query->bindParam(1, $prenom);
  $query->bindParam(2, $nom);

  if ($query->execute()) {
    $tab = $query->fetch(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
    }
}



?>
