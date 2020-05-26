<?php
session_start();
$idProjet = (isset($_POST["idProjet"]) ? $_POST["idProjet"] : "");
$_SESSION["idProjet"] = $idProjet;
header('Location: ../index.php?page=projetDetail');
 ?>
