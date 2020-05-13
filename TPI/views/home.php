<?php
//Renvoie au login si l'utilisateur n'est pas connecté
if (!isset($_SESSION["log"])) {
  header('Location: index.php?page=login');
}
?>
<p>Logged IN !!!</p>
