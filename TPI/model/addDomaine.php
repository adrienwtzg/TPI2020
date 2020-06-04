<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include '../db/databaseConnection.php';
//Vérifie que les entrées sont correctement syntaxé
$dataDomaine = filter_input_array(INPUT_POST, [
    "domaine" => FILTER_SANITIZE_STRING
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("INSERT INTO `domaines`(`domaine`) VALUES (?)");
$query->bindParam(1, $dataDomaine["domaine"]);

  if ($query->execute()) {
    header('Location: ../index.php?page=projets');
  }
  else {
    header('Location: ../index.php?page=');
  }
?>
