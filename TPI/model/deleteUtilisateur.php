<?php
include 'getEleveByUtilisateur.php';
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataUtilisateur = filter_input_array(INPUT_POST, [
    "idUtilisateur" => FILTER_SANITIZE_NUMBER_INT,
    "statut" => FILTER_SANITIZE_NUMBER_INT
]);




//Vérifie que la personne qui supprime un utilisateur d'un projet soit un elüve
if ($dataUtilisateur["statut"] == 3) {
  //Connexion à la base données
  $db = connectDB();
  //Supprime dans chaque table qui contient un idProjet
  $tablesIdProjet = array("travaille_pour", "evaluations");
  $idEleve = getEleveByUtilisateur($dataUtilisateur["idUtilisateur"])[0]["idEleve"];
  foreach ($tablesIdProjet as $table) {
    $query = $db->prepare("DELETE FROM $table WHERE `idEleve` = ? ");
    $query->bindParam(1, $idEleve);
    $query->execute();
  }
  //Supprime dans chaque table qui contient un idProjet
  $tablesIdProjet = array("eleves", "utilisateurs");
  foreach ($tablesIdProjet as $table) {
    $query = $db->prepare("DELETE FROM $table WHERE `idUtilisateur` = ? ");
    $query->bindParam(1, $dataUtilisateur["idUtilisateur"]);
    $query->execute();
  }
  $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">L'utilisateur a bien été supprimé</div>";
  header("Location: ../index.php?page=projets");


}
else {
  //Connexion à la base données
  $db = connectDB();
  //Connexion à la base données
  $db = connectDB();
  $query = $db->prepare('SELECT * FROM projets WHERE idUtilisateur = ?');
  $query->bindParam(1, $dataUtilisateur["idUtilisateur"]);
  $query->execute();
  $tab = $query->fetch(PDO::FETCH_ASSOC);
  if (empty($tab)) {
    //Supprime dans chaque table qui contient un idProjet
    $tablesIdProjet = array("projets", "utilisateurs");
    foreach ($tablesIdProjet as $table) {
      $query = $db->prepare("DELETE FROM $table WHERE `idUtilisateur` = ? ");
      $query->bindParam(1, $dataUtilisateur["idUtilisateur"]);
      $query->execute();
      header("Location: ../index.php?page=projets");
    }
  }
  else {
    $_SESSION["messageErreur"] = "<div class=\"alert alert-danger\" role=\"alert\">L'enseignant possède des projets, il n'est donc pas possible de le supprimer !</div>";
    header('Location: ../index.php?page=projets');
  }
}

?>
