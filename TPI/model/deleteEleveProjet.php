<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../db/databaseConnection.php');

//Vérifie que les entrées sont correctement syntaxé
$dataEleveProjet = filter_input_array(INPUT_POST, [
    "idEleve" => FILTER_SANITIZE_STRING,
    "idProjet" => FILTER_SANITIZE_STRING
]);




//Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
if ($_SESSION["statut"] == 2) {
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("DELETE FROM `travaille_pour` WHERE idProjet = ? AND idEleve = ?");
  $query->bindParam(1, $dataEleveProjet["idProjet"]);
  $query->bindParam(2, $dataEleveProjet["idEleve"]);

  if ($query->execute()) {
    header('Location: ../index.php?page=projetDetail');
  }
  else {
    header('Location: ../index.php?page=');
  }
}
else {
  header('Location: ../index.php?page=error');
}



?>
