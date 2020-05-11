<?php
//Démarre la session si ça n'est pas déja fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//En-tête de page
include 'views/head.php';
//Nom de la page actuelle
$page = (isset($_GET["page"]) ? $_GET["page"] : "");

if ($page == "login") {
  include 'include/login.php';
}
elseif ($page == "") {
  //include 'include/home.php';
}



?>
