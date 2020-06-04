<?php
function getUtilisateurs()
{
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM utilisateurs ORDER BY statut ASC");

  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
  }
}


?>
