<?php
include '../db/databaseConnection.php';
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Vérifie que les entrées sont correctement syntaxé
$dataCritereProjet = filter_input_array(INPUT_POST, [
    "idCritere" => FILTER_SANITIZE_NUMBER_INT,
    "idProjet" => FILTER_SANITIZE_NUMBER_INT
]);
$idCritere = $dataCritereProjet["idCritere"];
$idProjet = $dataCritereProjet["idProjet"];
//Vérifie que la personne qui supprime un util
  //Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
  if ($_SESSION["statut"] == 2) {
    //Connexion à la base données
    $db = connectDB();
    //Supprime dans chaque table qui contient un idProjet
    $query = $db->prepare("DELETE FROM criteres_projets WHERE `idProjet` = ? AND `idCritere` = ?");
    $query->bindParam(1, $idProjet);
    $query->bindParam(2, $idCritere);
    $query->execute();
    $_SESSION["messageErreur"] = '<div class="alert alert-success" role="alert">Le critère a été enlevé du projet</div>';
    header('Location: ../index.php?page=projetDetail');
  }

?>
