<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function deleteCritereProjet($idProjet, $idCritere){
  //Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
  if ($_SESSION["statut"] == 2) {
    //Connexion à la base données
    $db = connectDB();
    //Supprime dans chaque table qui contient un idProjet
    $query = $db->prepare("DELETE FROM criteres_projets WHERE `idProjet` = ? AND `idCritere` = ?");
    $query->bindParam(1, $idProjet);
    $query->bindParam(2, $idCritere);
    $query->execute();
    header('Location: index.php?page=projetDetail');
  }
}

?>
