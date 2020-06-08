<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataEvaluation = filter_input_array(INPUT_POST, [
    "idProjet" => FILTER_SANITIZE_NUMBER_INT,
    "idEleve" => FILTER_SANITIZE_NUMBER_INT

]);




//Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
if ($_SESSION["statut"] == 2) {
  //Connexion à la base données
  $db = connectDB();
  $query = $db->prepare("DELETE FROM evaluations WHERE `idProjet` = ? AND `idEleve` = ?");
  $query->bindParam(1, $dataEvaluation["idProjet"]);
  $query->bindParam(2, $dataEvaluation["idEleve"]);
  $query->execute();
  $query = $db->prepare("UPDATE travaille_pour SET `estEvalue` = 0  WHERE `idProjet` = ? AND `idEleve` = ?");
  $query->bindParam(1, $dataEvaluation["idProjet"]);
  $query->bindParam(2, $dataEvaluation["idEleve"]);
  $query->execute();
  $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">L'évaluation a été supprimée</div>";
  header("Location: ../index.php?page=projetDetail");


}
else {
  header('Location: ../index.php?page=error');
}

?>
