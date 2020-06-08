<?php
include '../db/databaseConnection.php';
session_start();

//Vérifie que les entrées sont correctement syntaxé
$dataCategorie = filter_input_array(INPUT_POST, [
    "idCategorie" => FILTER_SANITIZE_NUMBER_INT,
    "categorie" => FILTER_SANITIZE_STRING,
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("UPDATE `categories` SET `categorie` = ? WHERE `idCategorie` = ?");
$query->bindParam(1, $dataCategorie["categorie"]);
$query->bindParam(2, $dataCategorie["idCategorie"]);
//Execute la requête
if ($query->execute()) {
  $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">La catégorie a été modifiée</div>";
  header('Location: ../index.php?page=projets');
}
else {
  header('Location: ../index.php?page=');
}
 ?>
