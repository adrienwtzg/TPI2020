<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../db/databaseConnection.php';

//Vérifie que les entrées sont correctement syntaxé
$dataEvaluation = filter_input_array(INPUT_POST, [
    "idCategorie" => FILTER_SANITIZE_NUMBER_INT

]);




//Vérifie que la personne qui supprime un utilisateur d'un projet soit un enseignant
if ($_SESSION["statut"] == 1) {
  //Connexion à la base données
  $db = connectDB();
  $query = $db->prepare('SELECT * FROM criteres WHERE idCategorie = ?');
  $query->bindParam(1, $dataEvaluation["idCategorie"]);
  $query->execute();
  $tab = $query->fetch(PDO::FETCH_ASSOC);
  if (empty($tab)) {
    $query = $db->prepare("DELETE FROM categories WHERE `idCategorie` = ?");
    $query->bindParam(1, $dataEvaluation["idCategorie"]);
    $query->execute();
    header("Location: ../index.php?page=projets");
  }
  else {
    $_SESSION["messageErreur"] = "<div class=\"alert alert-danger\" role=\"alert\">La catégorie possède des critères, il n'est donc pas possible de la supprimer !</div>";
    header("Location: ../index.php?page=projets");
  }


  header("Location: ../index.php?page=projets");


}
else {
  header('Location: ../index.php?page=error');
}

?>
