<?php
include 'getCritereIdByName.php';
include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataCritere = filter_input_array(INPUT_POST, [
    "critere" => FILTER_SANITIZE_STRING,
    "definition" => FILTER_SANITIZE_STRING,
    "pointsMax" => FILTER_SANITIZE_NUMBER_INT,
    "idCategorie" => FILTER_SANITIZE_NUMBER_INT,
    "idProjet" => FILTER_SANITIZE_NUMBER_INT
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("INSERT INTO `criteres`(`critere`, `definition`, `pointsMax`, `idCategorie`) VALUES (?,?,?,?)");
$query->bindParam(1, $dataCritere["critere"]);
$query->bindParam(2, $dataCritere["definition"]);
$query->bindParam(3, $dataCritere["pointsMax"]);
$query->bindParam(4, $dataCritere["idCategorie"]);

//Execute la requête
if ($query->execute()) {
  $query = $db->prepare("INSERT INTO `criteres_projets`(`idProjet`, `idCritere`) VALUES (?,?)");
  $query->bindParam(1, $dataCritere["idProjet"]);
  $query->bindParam(2, getCritereIdByName($dataCritere["critere"]));
  $query->execute();
  header('Location: ../index.php?page=projetsDetail');
}
else {
  header('Location: ../index.php?page=');
}
 ?>
