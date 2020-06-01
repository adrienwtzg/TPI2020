<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataProjet = filter_input_array(INPUT_POST, [
    "idProjet" => FILTER_SANITIZE_STRING
]);




//Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
if ($_SESSION["statut"] == 2) {
  //Connexion à la base données
  $db = connectDB();
  //Supprime dans chaque table qui contient un idProjet
  $tablesIdProjet = array("travaille_pour", "criteres_projets", "evaluations", "projets");
  foreach ($tablesIdProjet as $table) {
    $query = $db->prepare("DELETE FROM $table WHERE `idProjet` = ? ");
    $query->bindParam(1, $dataProjet["idProjet"]);
    $query->execute();
  }
  header("Location: ../index.php?page=projets");


}
else {
  header('Location: ../index.php?page=error');
}

?>
