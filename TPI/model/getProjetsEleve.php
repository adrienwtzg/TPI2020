<?php

function GetProjetsEleve()
{
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("SELECT * FROM projets INNER JOIN travaille_pour ON projets.idProjet = travaille_pour.idProjet INNER JOIN eleves ON travaille_pour.idEleve = eleves.idEleve WHERE eleves.idUtilisateur = ?");
  $query->bindParam(1, $_SESSION["id"]);

  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    return $tab;
  }
  else {
    header('Location: ');
  }
}


?>
