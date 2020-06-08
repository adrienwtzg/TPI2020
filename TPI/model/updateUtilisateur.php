<?php
include 'getCritereIdByName.php';
include '../db/databaseConnection.php';
include 'getEleveByUtilisateur.php';
session_start();

if (isset($_POST["classe"])) {
  //Vérifie que les entrées sont correctement syntaxé
  $dataUtilisateur = filter_input_array(INPUT_POST, [
      "idUtilisateur" => FILTER_SANITIZE_NUMBER_INT,
      "nom" => FILTER_SANITIZE_STRING,
      "prenom" => FILTER_SANITIZE_STRING,
      "email" => FILTER_SANITIZE_STRING,
      "motDePasse" => FILTER_SANITIZE_STRING,
      "classe" => FILTER_SANITIZE_STRING,
      "annee" => FILTER_SANITIZE_STRING
  ]);

  //Connexion à la base données
  $db = connectDB();

  //Si le mot de passe est à changer
  if ($dataUtilisateur["motDePasse"] != "") {
    $query = $db->prepare("UPDATE `utilisateurs` SET `nom` = ?, `prenom` = ?, `email` = ?, `motDePasse` = ? WHERE `idUtilisateur` = ?");
    $query->bindParam(1, $dataUtilisateur["nom"]);
    $query->bindParam(2, $dataUtilisateur["prenom"]);
    $query->bindParam(3, $dataUtilisateur["email"]);
    $query->bindParam(4, sha1($dataUtilisateur["motDePasse"]));
    $query->bindParam(5, $dataUtilisateur["idUtilisateur"]);
  }
  else {
    $query = $db->prepare("UPDATE `utilisateurs` SET `nom` = ?, `prenom` = ?, `email` = ? WHERE `idUtilisateur` = ?");
    $query->bindParam(1, $dataUtilisateur["nom"]);
    $query->bindParam(2, $dataUtilisateur["prenom"]);
    $query->bindParam(3, $dataUtilisateur["email"]);
    $query->bindParam(4, $dataUtilisateur["idUtilisateur"]);
  }


  //Execute la requête
  if ($query->execute()) {
    $query = $db->prepare("UPDATE `eleves` SET `classe` = ?, `annee` = ? WHERE `idEleve` = ?");
    $query->bindParam(1, $dataUtilisateur["classe"]);
    $query->bindParam(2, $dataUtilisateur["annee"]);
    $query->bindParam(3, getEleveByUtilisateur($dataUtilisateur["idUtilisateur"])[0]["idEleve"]);
    $query->execute();
    $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">L'élève a été modifié</div>";
    header('Location: ../index.php?page=projets');
  }
  else {
    //header('Location: index.php?page=');
  }
}
else {
  //Vérifie que les entrées sont correctement syntaxé
  $dataUtilisateur = filter_input_array(INPUT_POST, [
      "idUtilisateur" => FILTER_SANITIZE_NUMBER_INT,
      "nom" => FILTER_SANITIZE_STRING,
      "prenom" => FILTER_SANITIZE_STRING,
      "email" => FILTER_SANITIZE_STRING,
      "motDePasse" => FILTER_SANITIZE_STRING,
  ]);

  //Connexion à la base données
  $db = connectDB();

  //Si le mot de passe est à changer
  if ($dataUtilisateur["motDePasse"] != "") {
    $query = $db->prepare("UPDATE `utilisateurs` SET `nom` = ?, `prenom` = ?, `email` = ?, `motDePasse` = ? WHERE `idUtilisateur` = ?");
    $query->bindParam(1, $dataUtilisateur["nom"]);
    $query->bindParam(2, $dataUtilisateur["prenom"]);
    $query->bindParam(3, $dataUtilisateur["email"]);
    $query->bindParam(4, sha1($dataUtilisateur["motDePasse"]));
    $query->bindParam(5, $dataUtilisateur["idUtilisateur"]);
  }
  else {
    $query = $db->prepare("UPDATE `utilisateurs` SET `nom` = ?, `prenom` = ?, `email` = ? WHERE `idUtilisateur` = ?");
    $query->bindParam(1, $dataUtilisateur["nom"]);
    $query->bindParam(2, $dataUtilisateur["prenom"]);
    $query->bindParam(3, $dataUtilisateur["email"]);
    $query->bindParam(4, $dataUtilisateur["idUtilisateur"]);
  }


  //Execute la requête
  if ($query->execute()) {
    $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">L'enseignant a été modifié</div>";
    header('Location: ../index.php?page=projets');
  }
  else {
    //header('Location: index.php?page=');
  }
}


 ?>
