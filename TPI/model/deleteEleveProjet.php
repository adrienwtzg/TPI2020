<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'getEleveByUtilisateur.php';



function deleteEleveProjet($idUtilisateur, $idProjet) {
  //Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
  if ($_SESSION["statut"] == 2) {
    //Connexion à la base données
    $db = connectDB();
    $idEleve = getEleveByUtilisateur($idUtilisateur)[0]["idEleve"];
    $query = $db->prepare("DELETE FROM `travaille_pour` WHERE idProjet = ? AND idEleve = ?");
    $query->bindParam(1, $idProjet);
    $query->bindParam(2, $idEleve);

    if ($query->execute()) {
      header('Location: index.php?page=projetDetail');
    }
    else {
      header('Location: ../index.php?page=');
    }
  }
  else {
    header('Location: ../index.php?page=error');
  }
}





?>
