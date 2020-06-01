<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include '/db/databaseConnection.php';

//En-tête de page
include 'views/head.php';

//Nom de la page actuelle
$page = (isset($_GET["page"]) ? $_GET["page"] : "");

if ($page == "" || $page == "login") {
  include 'views/login.php';
}
elseif ($page == "inscription") {
  include 'views/inscription.php';
}
elseif ($page == "projets") {
  if (isset($_SESSION["statut"])) {
      switch ($_SESSION["statut"]) {
        case 2:
          include 'views/projetsGestion.php';
          break;
        case 3:
          include 'views/projetsEleve.php';
          break;
      }
  }
}
elseif ($page == "projetDetail") {
  if (isset($_SESSION["statut"])) {
      switch ($_SESSION["statut"]) {
        case 2:
          include 'views/projetDetailGestion.php';
          break;
        case 3:
          include 'views/projetDetailEleve.php';
          break;
      }
  }
}
elseif ($page == "logout") {
  header('Location: model/logout.php');
}
else {
  include 'views/error.php';
}


?>
