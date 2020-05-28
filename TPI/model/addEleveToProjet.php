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




//Vérifie que la personne qui ajoute le projet soit un enseignant
if ($_SESSION["statut"] == 2) {
  //Connexion à la base données
  $db = connectDB();

  $query = $db->prepare("INSERT INTO `travaille_pour`(`idProjet`, `idEleve`) VALUES (?,?)");
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
