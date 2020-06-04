<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- END BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>Evaluation des projets en école entreprise</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <nav>
      <ul id="navigation">
        <li id="titlenav"><a>Evaluation projets EE</a></li>
        <?php
          if(isset($_SESSION["log"])) {
            switch ($_SESSION["statut"]) {
              //Administrateur
              case 1:
                echo '<li class="pages"><a href="index.php?page=projets">Gestion administrateur</a></li>';
                echo '<li class="pages"><a href="index.php?page=criteres">Gestion des Critères</a></li>';
                echo '<li class="pages" style="float: right;"><a href="index.php?page=logout">Déconnexion</a></li>';
                echo '<li class="pages" style="float: right;"><a href="index.php?page=profil">Profil</a></li>';
                echo '<button type="button" style="float: right; margin-top: 6px;;" class="btn btn-outline-dark" disabled>Administrateur</button>';
                break;
              //Enseignant
              case 2:
                echo '<li class="pages"><a href="index.php?page=projets">Gestion de projets</a></li>';
                echo '<li class="pages"><a href="index.php?page=criteres">Gestion des Critères</a></li>';
                echo '<li class="pages" style="float: right;"><a href="index.php?page=logout">Déconnexion</a></li>';
                echo '<li class="pages" style="float: right;"><a href="index.php?page=profil">Profil</a></li>';
                break;
              //Elève
              case 3:
                echo '<li class="pages"><a href="index.php?page=projets">Mes projets</a></li>';
                echo '<li class="pages" style="float: right;"><a href="index.php?page=logout">Déconnexion</a></li>';
                echo '<li class="pages" style="float: right;"><a href="index.php?page=profil">Profil</a></li>';
                break;
            }
          }
       ?>
      </ul>
    </nav>
