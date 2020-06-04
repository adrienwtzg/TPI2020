<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataDomaine = filter_input_array(INPUT_POST, [
    "idDomaine" => FILTER_SANITIZE_NUMBER_INT

]);




//Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
if ($_SESSION["statut"] == 1) {
  //Connexion à la base données
  $db = connectDB();
  $query = $db->prepare('SELECT * FROM projets WHERE idDomaine = ?');
  $query->bindParam(1, $dataDomaine["idDomaine"]);
  $query->execute();
  $tab = $query->fetch(PDO::FETCH_ASSOC);
  if (empty($tab)) {
    $query = $db->prepare("DELETE FROM domaines WHERE `idDomaine` = ?");
    $query->bindParam(1, $dataDomaine["idDomaine"]);
    $query->execute();
    header("Location: ../index.php?page=projets");
  }
  else {
    header("Location: ../index.php?page=projets");
  }


  header("Location: ../index.php?page=projets");


}
else {
  header('Location: ../index.php?page=error');
}

?>
