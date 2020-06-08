<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../db/databaseConnection.php';
include 'getEleveByUtilisateur.php';

//Vérifie que les entrées sont correctement syntaxé
$dataEleveProjet = filter_input_array(INPUT_POST, [
    "idUtilisateur" => FILTER_SANITIZE_NUMBER_INT,
    "idProjet" => FILTER_SANITIZE_NUMBER_INT
]);
$idUtilisateur = $dataEleveProjet["idUtilisateur"];
$idProjet = $dataEleveProjet["idProjet"];
//Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
if ($_SESSION["statut"] == 2) {
  //Connexion à la base données
  $db = connectDB();
  $idEleve = getEleveByUtilisateur($idUtilisateur)[0]["idEleve"];
  $query = $db->prepare("DELETE FROM `travaille_pour` WHERE idProjet = ? AND idEleve = ?");
  $query->bindParam(1, $idProjet);
  $query->bindParam(2, $idEleve);

  if ($query->execute()) {
    $_SESSION["messageErreur"] = "<div class=\"alert alert-success\" role=\"alert\">L'élève a été enlevé du projet</div>";
    header('Location: ../index.php?page=projetDetail');
  }
  else {
    //header('Location: ../index.php?page=');
  }
}
else {
  //header('Location: ../index.php?page=error');
}
?>




?>
