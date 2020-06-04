<?php
include '../db/databaseConnection.php';
session_start();
//Vérifie que les entrées sont correctement syntaxé
$dataMotDePasse = filter_input_array(INPUT_POST, [
    "idUtilisateur" => FILTER_SANITIZE_NUMBER_INT,
    "oldMdp" => FILTER_SANITIZE_STRING,
    "newMdp" => FILTER_SANITIZE_STRING,
    "newMdp2" => FILTER_SANITIZE_STRING

]);

//Connexion à la base données
$db = connectDB();
if ($dataMotDePasse["newMdp"] == $dataMotDePasse["newMdp2"]) {
  $query = $db->prepare("SELECT MotDePasse FROM utilisateurs WHERE idUtilisateur = ?");
  $query->bindParam(1, $dataMotDePasse["idUtilisateur"]);

  if ($query->execute()) {
    $tab = $query->fetchAll(PDO::FETCH_ASSOC);
    $mdpChiffre = $tab[0]["MotDePasse"];

    if ($mdpChiffre == sha1($dataMotDePasse["oldMdp"])) {
      $newMdpChiffre = sha1($dataMotDePasse["newMdp"]);
      $query = $db->prepare('UPDATE utilisateurs SET MotDePasse = ? WHERE idUtilisateur = ?');
      $query->bindParam(1, $newMdpChiffre);
      $query->bindParam(2, $dataMotDePasse["idUtilisateur"]);
      $query->execute();
      $_SESSION["messageChangementMotDePasse"] = "<div class=\"alert alert-success\" role=\"alert\">Le mot de passe a été changé</div>";
      header('Location: ../index.php?page=profil');
    }
    else {
      //Si l'ancien mot de passe n'est pas juste
      $_SESSION["messageChangementMotDePasse"] = "<div class=\"alert alert-danger\" role=\"alert\">L'ancien mot de passe n'est pas correct</div>";
      header('Location: ../index.php?page=profil');
    }
  }
}
else {
  //Si les nouveau mots de passes sont différents
  $_SESSION["messageChangementMotDePasse"] = "<div class=\"alert alert-danger\" role=\"alert\">Les mots de passes ne sont pas identiques</div>";
  header('Location: ../index.php?page=profil');
}


?>
