<?php
require_once('../db/databaseConnection.php');
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Vérifie que les entrées sont correctement syntaxé
$dataLogin = filter_input_array(INPUT_POST, [
    "prenom" => FILTER_SANITIZE_STRING,
    "nom" => FILTER_SANITIZE_STRING,
    "motDePasse" => FILTER_SANITIZE_STRING
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("SELECT MotDePasse, Statut FROM utilisateurs WHERE Prenom LIKE ? AND Nom LIKE ?");
$query->bindParam(1, $dataLogin["prenom"]);
$query->bindParam(2, $dataLogin["nom"]);

  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    $mdpChiffre = $tab[0]["MotDePasse"];
    $statut = $tab[0]["Statut"];

    if ($mdpChiffre == sha1($dataLogin["motDePasse"])) {
      $_SESSION["log"] = true;
      $_SESSION["nom"] = $dataLogin["nom"];
      $_SESSION["prenom"] = $dataLogin["prenom"];
      $_SESSION["statut"] = $statut;
      print_r($_SESSION);
      header('Location: ../index.php?page=projets');
    }
    else {
      $_SESSION["loginError"] = "<div class=\"alert alert-danger\" role=\"alert\">Les identifiants de connexion sont incorrects</div>";
      header('Location: ../index.php?page=login');
    }
  }
  else {
    header('Location: ');
  }

?>
