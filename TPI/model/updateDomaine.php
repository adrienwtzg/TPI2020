<?php
include 'getCritereIdByName.php';
include '../db/databaseConnection.php';
session_start();

//Vérifie que les entrées sont correctement syntaxé
$dataDomaine = filter_input_array(INPUT_POST, [
    "idDomaine" => FILTER_SANITIZE_NUMBER_INT,
    "domaine" => FILTER_SANITIZE_STRING,
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("UPDATE `domaines` SET `domaine` = ? WHERE `idDomaine` = ?");
$query->bindParam(1, $dataDomaine["domaine"]);
$query->bindParam(2, $dataDomaine["idDomaine"]);
//Execute la requête
if ($query->execute()) {
  $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">Le domaine a été modifié</div>";
  header('Location: ../index.php?page=projets');
}
else {
  header('Location: ../index.php?page=');
}
 ?>
