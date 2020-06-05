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
elseif ($page == "projets") {
  if (isset($_SESSION["statut"])) {
      switch ($_SESSION["statut"]) {
        case 2:
          include 'views/projetsGestion.php';
          break;
        case 3:
          include 'views/projetsEleve.php';
          break;
        case 1:
          include 'views/admin.php';
          break;
      }
  }
  else {
    header('Location: index.php?page=login');
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
  else {
    header('Location: index.php?page=login');
  }
}
elseif ($page == "projetEvaluation") {
  if (isset($_SESSION["statut"])) {
    if ($_SESSION["statut"] == 2) {
      include 'views/projetEvaluation.php';
    }
  }
  else {
    header('Location: index.php?page=login');
  }
}
elseif ($page == "voirEvaluation") {
  if (isset($_SESSION["statut"])) {
    if ($_SESSION["statut"] == 2) {
      include 'views/voirEvaluation.php';
    }
  }
  else {
    header('Location: index.php?page=login');
  }
}
elseif ($page == "criteres") {
  if (isset($_SESSION["statut"])) {
      switch ($_SESSION["statut"]) {
        case 1:
          include 'views/gestionCriteres.php';
          break;
        case 2:
          include 'views/gestionCriteres.php';
          break;
        case 3:
          include 'views/error.php';
          break;
      }
  }
  else {
    header('Location: index.php?page=login');
  }
}
elseif ($page == "profil") {
  include 'views/profil.php';
}
elseif ($page == "logout") {
  header('Location: model/logout.php');
}
else {
  include 'views/error.php';
}


?>
