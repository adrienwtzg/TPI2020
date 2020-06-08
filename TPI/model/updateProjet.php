<?php
include 'getCritereIdByName.php';
include '../db/databaseConnection.php';
session_start();

//Vérifie que les entrées sont correctement syntaxé
$dataProjet = filter_input_array(INPUT_POST, [
    "idProjet" => FILTER_SANITIZE_NUMBER_INT,
    "titre" => FILTER_SANITIZE_STRING,
    "description" => FILTER_SANITIZE_STRING,
    "client" => FILTER_SANITIZE_STRING,
    "dureePrevue" => FILTER_SANITIZE_NUMBER_INT,
    "dateDebut" => FILTER_SANITIZE_STRING,
    "idDomaine" => FILTER_SANITIZE_NUMBER_INT
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("UPDATE `projets` SET `titre` = ?, `description` = ?, `client` = ?, `dureePrevue` = ?, `dateDebut` = ?, `idDomaine` = ? WHERE `idProjet` = ?");
$query->bindParam(1, $dataProjet["titre"]);
$query->bindParam(2, $dataProjet["description"]);
$query->bindParam(3, $dataProjet["client"]);
$query->bindParam(4, $dataProjet["dureePrevue"]);
$query->bindParam(5, $dataProjet["dateDebut"]);
$query->bindParam(6, $dataProjet["idDomaine"]);
$query->bindParam(7, $dataProjet["idProjet"]);

//Execute la requête
if ($query->execute()) {
  $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">Le projet a été modifié</div>";
  header('Location: ../index.php?page=projetDetail');
}
else {
  header('Location: ../index.php?page=');
}
 ?>
