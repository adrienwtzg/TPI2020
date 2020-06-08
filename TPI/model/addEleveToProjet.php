<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'getEleveByUtilisateur.php';
include '../db/databaseConnection.php';

//Nombre d'élèves maximum
define("NB_ELEVES", 4);

//Connexion à la base données
$db = connectDB();

//Vérifie que les entrées sont correctement syntaxé
$dataEleveProjet = filter_input_array(INPUT_POST, [
    "idUtilisateur" => FILTER_SANITIZE_STRING,
    "idProjet" => FILTER_SANITIZE_STRING
]);

//Vérifie que le projet ne contient pas déja 4 élèves
$query = $db->prepare("SELECT COUNT(*) FROM travaille_pour WHERE idProjet = ?");
$query->bindParam(1, $dataEleveProjet["idProjet"]);

if ($query->execute()) {
  $tab = $query->fetchAll(PDO::FETCH_ASSOC);
  $nbEleve = $tab[0]["COUNT(*)"];
  if ($nbEleve < NB_ELEVES) {
    //Vérifie que la personne qui ajoute le projet soit un enseignant
    if ($_SESSION["statut"] == 2) {
      $query = $db->prepare("INSERT INTO travaille_pour (idProjet, idEleve) VALUES (?,?)");
      $query->bindParam(1, $dataEleveProjet["idProjet"]);
      $query->bindParam(2, getEleveByUtilisateur($dataEleveProjet["idUtilisateur"])[0]["idEleve"]);

      if ($query->execute()) {
        $_SESSION["messageErreur"] = '<div class="alert alert-success" role="alert">L\'élève a été ajouté au projet</div>';
        header('Location: ../index.php?page=projetDetail');
      }
      else {
        header('Location: ../index.php?page=projetDetail');
      }
    }
    else {
      header('Location: ../index.php?page=projetDetail');
    }

  }
  else {
    $_SESSION["maxEleves"] = "<div class=\"alert alert-danger\" role=\"alert\">Le nombre maximum par projet est de 4 élèves !</div>";
    header('Location: ../index.php?page=projetDetail');
  }
}
else {
  header('Location: ');
}






?>
