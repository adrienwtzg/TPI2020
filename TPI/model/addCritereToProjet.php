<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../db/databaseConnection.php';

//Connexion à la base données
$db = connectDB();
$idProjet = $_POST['idProjet'];
if(isset($_POST['idCritere'])){
        $idCriteres = $_POST['idCritere'];
      foreach ($idCriteres as $idCritere) {
        $query = $db->prepare("INSERT INTO criteres_projets (idProjet, idCritere) VALUES (?,?)");
        $query->bindParam(1, $idProjet);
        $query->bindParam(2, $idCritere);
        $query->execute();
        }
        $_SESSION["messageErreur"] = '<div class="alert alert-success" role="alert">Le critère a été ajouté au projet</div>';
        header('Location: ../index.php?page=projetDetail');
    }



?>
