<?php
include 'model/getUtilisateurById.php';
include 'model/getInfoEleve.php';
include 'model/getEleveByUtilisateur.php';
if (!isset($_SESSION["log"])) {
  header('Location: index.php?page=login');
}

//Messages d'erreurs du changement de mot de passe
if (isset($_SESSION['messageChangementMotDePasse']))
{
    echo $_SESSION['messageChangementMotDePasse'];
    unset($_SESSION['messageChangementMotDePasse']);
}

if ($_SESSION["statut"] == 3) {
  $eleve = getInfoEleve(getEleveByUtilisateur($_SESSION["id"])[0]["idEleve"]);
}

$utilisateur = getUtilisateurById($_SESSION["id"]);

?>
    <div class="marge">

    </div>
    <div class="container">
      <div class="card-deck">
        <div class="card" style="width: 18rem;">

          <div class="card-body">
            <?php
              switch ($_SESSION["statut"]) {
                case 1:
                  echo '<button type="button" style="float: right;" class="btn btn-outline-dark" disabled>Administrateur</button>';
                  break;
                case 2:
                  echo '<button type="button" style="float: right;" class="btn btn-outline-dark" disabled>Enseignant</button>';
                  break;
                case 3:
                  echo '<button type="button" style="float: right;" class="btn btn-outline-dark" disabled>Elève</button>';
                  break;
              }
            ?>

            <h5 class="card-title"><?php echo $utilisateur["prenom"]." ".$utilisateur["nom"]; ?></h5>
            <?php
              if ($_SESSION["statut"] == 3) {
                echo '<h6 class="card-subtitle mb-2 text-muted">'.$eleve["classe"].'</h6>';
              }
            ?>

            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalChangeMotDePasse">Changer le mot de passe</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<!-- Modal pour changer le mot de passe-->
<div class="modal fade" id="modalChangeMotDePasse" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form class="" action="model/changeMotDePasse.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Changer le mot de passe</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="password" class="form-control" name="oldMdp" aria-describedby="emailHelp" placeholder="Ancien mot de passe">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="newMdp" aria-describedby="emailHelp" placeholder="Nouveau mot de passe">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="newMdp2" aria-describedby="emailHelp" placeholder="Répéter nouveau mot de passe">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <input type="hidden" name="idUtilisateur" value="<?php echo $_SESSION["id"]; ?>">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
