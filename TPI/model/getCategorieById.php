<?php

function getCategorieById($idCategorie){
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM categories WHERE idCategorie = ?");
  $query->bindParam(1, $idCategorie);

  if ($query->execute()) {
    $tab = $query->fetch(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
    }
}

?>
