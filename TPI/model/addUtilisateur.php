<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db/databaseConnection.php';
include 'getIdByName.php';

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("SELECT * FROM utilisateurs WHERE nom = ? AND prenom = ?");
$query->bindParam(1, $_POST["nom"]);
$query->bindParam(2, $_POST["prenom"]);
$query->execute();
$tab = $query->fetchAll(PDO::FETCH_ASSOC);
if (!empty($tab)) {
  $_SESSION["messageMemeNomUtilisateur"] = '<div class="alert alert-danger" role="alert">Deux utilisateurs ne peuvent pas avoir le même prénom et nom</div>';
  header("Location: ../index.php?page=projets");
}

if (isset($_POST["classe"])) {
  //Vérifie que les entrées sont correctement syntaxé
  $dataUtilisateur = filter_input_array(INPUT_POST, [
      "nom" => FILTER_SANITIZE_STRING,
      "prenom" => FILTER_SANITIZE_STRING,
      "email" => FILTER_SANITIZE_STRING,
      "motDePasse" => FILTER_SANITIZE_STRING,
      "statut" => FILTER_SANITIZE_STRING,
      "classe" => FILTER_SANITIZE_STRING,
      "annee" => FILTER_SANITIZE_NUMBER_INT
  ]);
  $mdpChiffre = sha1($dataUtilisateur["motDePasse"]);



  if ($dataUtilisateur["statut"] == 3) {
    $query = $db->prepare("INSERT INTO `utilisateurs`(`nom`, `prenom`, `email`, `motDePasse`, `statut`) VALUES (?,?,?,?,?)");
    $query->bindParam(1, $dataUtilisateur["nom"]);
    $query->bindParam(2, $dataUtilisateur["prenom"]);
    $query->bindParam(3, $dataUtilisateur["email"]);
    $query->bindParam(4, $mdpChiffre);
    $query->bindParam(5, $dataUtilisateur["statut"]);

      if ($query->execute()) {
        $idUtilisateur = GetIdByName($dataUtilisateur["prenom"], $dataUtilisateur["nom"])["idUtilisateur"];
        $query = $db->prepare("INSERT INTO `eleves` (`classe`, `annee`, `idUtilisateur`) VALUES (?,?,?)");
        $query->bindParam(1, $dataUtilisateur["classe"]);
        $query->bindParam(2, $dataUtilisateur["annee"]);
        $query->bindParam(3, $idUtilisateur);
        $query->execute();
        $_SESSION["messageErreur"] = '<div class="alert alert-success" role="alert">L\'élève à bien été créé</div>';
        header('Location: ../index.php?page=projets');
      }
      else {
        header('Location: ../index.php?page=projets');
      }

  }
  else {
    // code...
  }
}
else {
  //Vérifie que les entrées sont correctement syntaxé
  $dataUtilisateur = filter_input_array(INPUT_POST, [
      "nom" => FILTER_SANITIZE_STRING,
      "prenom" => FILTER_SANITIZE_STRING,
      "email" => FILTER_SANITIZE_STRING,
      "motDePasse" => FILTER_SANITIZE_STRING,
      "statut" => FILTER_SANITIZE_STRING,
  ]);
  $mdpChiffre = sha1($dataUtilisateur["motDePasse"]);

  //Connexion à la base données
  $db = connectDB();
  $query = $db->prepare("INSERT INTO `utilisateurs`(`nom`, `prenom`, `email`, `motDePasse`, `statut`) VALUES (?,?,?,?,?)");
  $query->bindParam(1, $dataUtilisateur["nom"]);
  $query->bindParam(2, $dataUtilisateur["prenom"]);
  $query->bindParam(3, $dataUtilisateur["email"]);
  $query->bindParam(4, $mdpChiffre);
  $query->bindParam(5, $dataUtilisateur["statut"]);

    if ($query->execute()) {
      $_SESSION["messageErreur"] = '<div class="alert alert-success" role="alert">L\'enseignant à bien été créé</div>';
      header('Location: ../index.php?page=projets');
    }
}


?>
