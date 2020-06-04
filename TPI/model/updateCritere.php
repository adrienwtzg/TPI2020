<?php
include 'getCritereIdByName.php';
include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataCritere = filter_input_array(INPUT_POST, [
    "idCritere" => FILTER_SANITIZE_NUMBER_INT,
    "critere" => FILTER_SANITIZE_STRING,
    "definition" => FILTER_SANITIZE_STRING,
    "pointsMax" => FILTER_SANITIZE_NUMBER_INT,
    "idCategorie" => FILTER_SANITIZE_NUMBER_INT
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("UPDATE `criteres` SET `critere` = ?, `definition` = ?, `pointsMax` = ?, `idCategorie` = ? WHERE `idCritere` = ?");
$query->bindParam(1, $dataCritere["critere"]);
$query->bindParam(2, $dataCritere["definition"]);
$query->bindParam(3, $dataCritere["pointsMax"]);
$query->bindParam(4, $dataCritere["idCategorie"]);
$query->bindParam(5, $dataCritere["idCritere"]);

//Execute la requête
if ($query->execute()) {

  header('Location: ../index.php?page=criteres');
}
else {
  header('Location: ../index.php?page=');
}
 ?>
