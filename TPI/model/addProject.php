<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include '../db/databaseConnection.php';
//Vérifie que les entrées sont correctement syntaxé
$dataProjet = filter_input_array(INPUT_POST, [
    "Titre" => FILTER_SANITIZE_STRING,
    "Description" => FILTER_SANITIZE_STRING,
    "Client" => FILTER_SANITIZE_STRING,
    "DureePrevue" => FILTER_SANITIZE_NUMBER_INT,
    "DateDebut" => FILTER_SANITIZE_STRING,
    "idDomaine" => FILTER_SANITIZE_STRING
]);

//Connexion à la base données
$db = connectDB();

$query = $db->prepare("SELECT idProjet FROM projets WHERE titre = ?");
$query->bindParam(1, $dataProjet["Titre"]);
$query->execute();
$tab = $query->fetchAll(PDO::FETCH_ASSOC);
if (empty($tab)) {
  $query = $db->prepare("INSERT INTO `projets`(`titre`, `description`, `client`, `dureePrevue`, `dateDebut`, `idDomaine`, `idUtilisateur`) VALUES (?,?,?,?,?,?,?)");
  $query->bindParam(1, $dataProjet["Titre"]);
  $query->bindParam(2, $dataProjet["Description"]);
  $query->bindParam(3, $dataProjet["Client"]);
  $query->bindParam(4, $dataProjet["DureePrevue"]);
  $query->bindParam(5, $dataProjet["DateDebut"]);
  $query->bindParam(6, $dataProjet["idDomaine"]);
  //Vérifie que la personne qui ajoute le projet soit un enseignant
  if ($_SESSION["statut"] == 2) {
    $query->bindParam(7, $_SESSION["id"]);
  }
  else {
    header('Location: ../index.php?page=error');
  }


    if ($query->execute()) {
      $_SESSION["messageMemeNomProjet"] = "<div class=\"alert alert-success\" role=\"alert\">Le projet a été créé</div>";
      header('Location: ../index.php?page=projets');
    }
    else {
      header('Location: ../index.php?page=');
    }
}
else {
  $_SESSION["messageMemeNomProjet"] = "<div class=\"alert alert-danger\" role=\"alert\">Le nom de projet existe déja</div>";
  header("Location: ../index.php?page=projets");
}

?>
