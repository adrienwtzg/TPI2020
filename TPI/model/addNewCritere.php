<?php
include 'getCritereIdByName.php';
include '../db/databaseConnection.php';
session_start();

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

$query = $db->prepare("SELECT idCritere FROM criteres WHERE critere LIKE ?");
$query->bindParam(1, $dataCritere["critere"]);
$query->execute();
$tab = $query->fetchAll(PDO::FETCH_ASSOC);
if (empty($tab)) {
  $query = $db->prepare("INSERT INTO `criteres`(`critere`, `definition`, `pointsMax`, `idCategorie`) VALUES (?,?,?,?)");
  $query->bindParam(1, $dataCritere["critere"]);
  $query->bindParam(2, $dataCritere["definition"]);
  $query->bindParam(3, $dataCritere["pointsMax"]);
  $query->bindParam(4, $dataCritere["idCategorie"]);

  //Execute la requête
  if ($query->execute()) {
    $_SESSION["messageMemeNomCritere"] = "<div class=\"alert alert-success\" role=\"alert\">Le critère a été ajouté</div>";
    header('Location: ../index.php?page=criteres');
  }
  else {
    header('Location: ../index.php?page=');
  }
}
else {
  $_SESSION["messageMemeNomCritere"] = '<div class="alert alert-danger" role="alert">Le critère existe déja</div>';
  header("Location: ../index.php?page=criteres");
}


 ?>
