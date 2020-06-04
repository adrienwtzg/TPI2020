<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include '../db/databaseConnection.php';
include 'getIdByName.php';
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

if ($dataUtilisateur["statut"] == 3) {
  $query = $db->prepare("INSERT INTO `utilisateurs`(`nom`, `prenom`, `email`, `motDePasse`, `statut`) VALUES (?,?,?,?,?)");
  $query->bindParam(1, $dataUtilisateur["nom"]);
  $query->bindParam(2, $dataUtilisateur["prenom"]);
  $query->bindParam(3, $dataUtilisateur["email"]);
  $query->bindParam(4, $mdpChiffre);
  $query->bindParam(5, $dataUtilisateur["statut"]);

    if ($query->execute()) {
      $idUtilisateur = GetIdByName($dataUtilisateur["prenom"], $dataUtilisateur["nom"])["idUtilisateur"];
      $class = "I-DA-P3C";
      $annee = "3";
      $query = $db->prepare("INSERT INTO `eleves` (`classe`, `annee`, `idUtilisateur`) VALUES (?,?,?)");
      $query->bindParam(1, $class);
      $query->bindParam(2, $annee);
      $query->bindParam(3, $idUtilisateur);
      $query->execute();
      header('Location: ../index.php?page=projets');
    }
    else {
      header('Location: ../index.php?page=projets');
    }

}
else {
  // code...
}
?>
