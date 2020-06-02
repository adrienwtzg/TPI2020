<?php

function getInfoEleve($idEleve){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM utilisateurs INNER JOIN eleves ON utilisateurs.idUtilisateur = eleves.idUtilisateur WHERE idEleve = ?");
  $query->bindParam(1, $idEleve);

  if ($query->execute()) {
    $tab = $query->fetch(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
    }
}



?>
