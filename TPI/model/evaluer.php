<?php
session_start();
require_once("../db/databaseConnection.php");
//Vérifie que les entrées sont correctement syntaxé
$dataEvaluation = filter_input_array(INPUT_POST, [
    "idProjet" => FILTER_SANITIZE_NUMBER_INT,
    "idEleve" => FILTER_SANITIZE_NUMBER_INT
]);

$idCriteres = $_POST["idCriteres"];
$pointsObtenus = $_POST["pointsObtenus"];
$commentaires = $_POST["commentaires"];

$date = date('Y-m-d');

$db = connectDB();

foreach($idCriteres as $key => $idCritere) {
  $query = $db->prepare("INSERT INTO `evaluations`(`observation`, `date`, `pointsObtenus`, `idEleve`, `idProjet`, `idCritere`) VALUES(?,?,?,?,?,?)");
  $query->bindParam(1, $commentaires[$key]);
  $query->bindParam(2, $date);
  $query->bindParam(3, $pointsObtenus[$key]);
  $query->bindParam(4, $dataEvaluation["idEleve"]);
  $query->bindParam(5, $dataEvaluation["idProjet"]);
  $query->bindParam(6, $idCritere);
  $query->execute();
}

$query = $db->prepare("UPDATE `travaille_pour` SET `estEvalue`= 1 WHERE idProjet = ? AND idEleve = ?");
$query->bindParam(1, $dataEvaluation["idProjet"]);
$query->bindParam(2, $dataEvaluation["idEleve"]);
$query->execute();
$_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">L'évaluation a été faite</div>";
header('Location: ../index.php?page=projetDetail');


?>
