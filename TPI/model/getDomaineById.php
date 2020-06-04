<?php

function getDomaineById($idDomaine){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM domaines WHERE idDomaine = ?");
  $query->bindParam(1, $idDomaine);

  if ($query->execute()) {
    $tab = $query->fetch(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
    }
}

?>
