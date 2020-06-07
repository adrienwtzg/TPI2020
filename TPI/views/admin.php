<?php
include 'model/getCategoriesCriteres.php';
include 'model/getDomaines.php';
include 'model/getUtilisateurs.php';
include 'model/getCategorieById.php';
include 'model/getDomaineById.php';
include 'model/getUtilisateurById.php';
include 'model/getEleveByUtilisateur.php';
include 'model/getInfoEleve.php';

//Redirige vers le login si l'utilisateur n'est pas authentifié
if(!isset($_SESSION["log"])) {
  header('Location: index.php?page=login');
}

//detection ajout/modification/suppression de catégories, domaines et utilisateurs
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'modifierCategorie') {
    $idCategorieAlter = $_POST["idCategorie"];
    $categorieAlter = getCategorieById($idCategorieAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalModifierCategorie').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'supprimerCategorie') {
    $idCategorieAlter = $_POST["idCategorie"];
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalSupprimerCategorie').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'modifierDomaine') {
    $idDomaineAlter = $_POST["idDomaine"];
    $domaineAlter = getDomaineById($idDomaineAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalModifierDomaine').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'supprimerDomaine') {
    $idDomaineAlter = $_POST["idDomaine"];
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalSupprimerDomaine').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'modifierUtilisateur') {
    $idUtilisateurAlter = $_POST["idUtilisateur"];
    $utilisateurAlter = getUtilisateurById($idUtilisateurAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalModifierUtilisateur').modal('show');
          });
          </script>";
  }
  elseif ($_POST['action'] == 'supprimerUtilisateur') {
    $idUtilisateurAlter = $_POST["idUtilisateur"];
    $utilisateurAlter = getUtilisateurById($idUtilisateurAlter);
    echo "<script type='text/javascript'>
          $(document).ready(function(){
          $('#modalSupprimerUtilisateur').modal('show');
          });
          </script>";
  }
}

//Message d'erreur suppression utilisateurs
if (isset($_SESSION["messageErreur"])) {
  echo $_SESSION["messageErreur"];
  unset($_SESSION["messageErreur"]);
}

//Message d'erreur si le nom et le prénom de l'utilisateur à ajouter existe déja
if (isset($_SESSION["messageMemeNomUtilisateur"])) {
  echo $_SESSION["messageMemeNomUtilisateur"];
  unset($_SESSION["messageMemeNomUtilisateur"]);
}
?>
<div class="container"><br>
  <div class="row">
    <div class="col-sm">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="text-center">Catégories des critères <button style="float: right; padding: 0;" class="btn btn-link" data-toggle="modal" data-target="#modalAjoutCategorie">Ajouter une catégorie de critères</button></th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach (getCategoriesCriteres() as $categorie) {
            echo "<form action=\"#\" method=\"POST\">";
            echo '<tr>';
            echo '  <td>'.$categorie["categorie"].'';
            echo "<input type=\"hidden\" name=\"idCategorie\" value=\"".$categorie["idCategorie"]."\">";
            echo ' <button title="Supprimer cette catégorie" name="action" type="submit" name="action" value="supprimerCategorie" class="cross btn">&#10060;</button><button name="action" value="modifierCategorie" style="float: right;" class="btn btn-secondary">Modifier</button> </td>';
            echo '</tr>';
            echo '</form>';
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="text-center">Domaines des projets <button data-toggle="modal" data-target="#modalAjoutDomaine" style="float: right; padding: 0;" class="btn btn-link">Ajouter un domaine de projet</button></th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach (getDomaines() as $domaine) {
            echo "<form action=\"#\" method=\"POST\">";
            echo '<tr>';
            echo '  <td>'.$domaine["domaine"].'';
            echo "<input type=\"hidden\" name=\"idDomaine\" value=\"".$domaine["idDomaine"]."\">";
            echo ' <button title="Supprimer ce domaine" name="action" value="supprimerDomaine" type="submit" class="cross btn">&#10060;</button><button style="float: right;" type="submit" name="action" value="modifierDomaine" class="btn btn-secondary">Modifier</button> </td>';
            echo '</tr>';
            echo '</form>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br>
  <div style="text-align: center;">
    <h3>Gestion des utilisateurs</h3>
  </div>
  <div class="row">
    <table class="table table-hover">
      <thead>
        <tr>
          <th class="text-center">Prénom</th>
          <th class="text-center">Nom </th>
          <th class="text-center">Email </th>
          <th class="text-center">Statut </th>
          <th class="text-center"><button style="float: right;" class="btn btn-link" data-toggle="modal" data-target="#modalAjoutUtilisateur">Ajouter un utilisateur</button></th>
        </tr>
      </thead>
      <tbody>
        <?php  foreach (getUtilisateurs() as $utilisateur) {
          if ($utilisateur["idUtilisateur"] != $_SESSION["id"]) {
            echo "<form action=\"#\" method=\"POST\">";
            echo '<tr>';
            echo '  <td class="text-center">'.$utilisateur["prenom"].'</td>';
            echo '  <td class="text-center">'.$utilisateur["nom"].'</td>';
            echo '  <td class="text-center">'.$utilisateur["email"].'</td>';
            switch ($utilisateur["statut"]) {
              case 1:
                echo '  <td class="text-center">Administrateur</td>';
                break;
              case 2:
                echo '  <td class="text-center">Enseignant</td>';
                break;
              case 3:
                echo '  <td class="text-center">Elève</td>';
                break;
            }
            echo '<input type="hidden" name="idUtilisateur" value="'.$utilisateur["idUtilisateur"].'">';
            echo '  <td class="text-center"><button style="margin-right: 0px;" title="Supprimer cet utilisateur" name="action" value="supprimerUtilisateur" type="submit" class="cross btn">&#10060;</button><button type="submit" name="action" value="modifierUtilisateur" class="btn btn-secondary">Modifier</button> </td>';
            echo '</tr>';
            echo '</form>';
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php if (isset($idCategorieAlter)) { ?>
  <!-- Modal de modification d'une catégorie-->
  <div class="modal fade" id="modalModifierCategorie" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateCategorie.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'une catégorie de critère</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Nom de la catégorie</label>
             <input class="form-control" type="text" name="categorie" value="<?php echo $categorieAlter["categorie"]; ?>" required>
           </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
            <input type="hidden" name="idCategorie" value="<?php echo $idCategorieAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
  <!-- Modal de suppression de la catégorie-->
  <div class="modal fade" id="modalSupprimerCategorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer cette catégorie ?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <p>Une fois supprimé la catégorie ne sera plus récupérable. De plus, si un critère appartient à la catégorie elle ne sera pas supprimée.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <form action="model/deleteCategorie.php" method="POST">
            <input type="hidden" name="idCategorie" value="<?php echo $idCategorieAlter; ?>">
            <button type="submit" class="btn btn-primary">Supprimer</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php if (isset($idDomaineAlter)) { ?>
  <!-- Modal de modification d'un domaine-->
  <div class="modal fade" id="modalModifierDomaine" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateDomaine.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'une catégorie de critère</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Nom de la catégorie</label>
             <input class="form-control" type="text" name="domaine" value="<?php echo $domaineAlter["domaine"]; ?>" required>
           </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
            <input type="hidden" name="idDomaine" value="<?php echo $idDomaineAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
  <!-- Modal de suppression d'un domaine-->
  <div class="modal fade" id="modalSupprimerDomaine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer ce domaine ?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <p>Une fois supprimé le domaine ne sera plus récupérable. De plus, si un projet appartient à ce domaine il ne sera pas supprimé.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <form action="model/deleteDomaine.php" method="POST">
            <input type="hidden" name="idDomaine" value="<?php echo $idDomaineAlter; ?>">
            <button type="submit" class="btn btn-primary">Supprimer</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php if (isset($idUtilisateurAlter)) { ?>
  <!-- Modal de modification d'un utilisateur-->
  <div class="modal fade" id="modalModifierUtilisateur" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="model/updateUtilisateur.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modification d'un utilisateur</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <div class="form-group">
             <label for="">Nom</label>
             <input class="form-control" type="text" name="nom" value="<?php echo $utilisateurAlter["nom"]; ?>" required>
           </div>
           <div class="form-group">
             <label for="">Prénom</label>
             <input class="form-control" type="text" name="prenom" value="<?php echo $utilisateurAlter["prenom"]; ?>" required>
           </div>
           <div class="form-group">
             <label for="">Email</label>
             <input class="form-control" type="text" name="email" value="<?php echo $utilisateurAlter["email"]; ?>" required>
           </div>
           <div class="form-group">
             <label for="">Mot de passe (laissez vide pour ne pas le changer)</label>
             <input class="form-control" type="password" name="motDePasse">
           </div>
           <?php if($utilisateurAlter["statut"] == 3) { //Si l'utilisateur est un élève?>
           <div class="form-group">
             <label for="classe">Classe</label>
             <input class="form-control" type="text" name="classe" value="<?php echo getInfoEleve(getEleveByUtilisateur($utilisateurAlter["idUtilisateur"])[0]["idEleve"])["classe"]; ?>" required>
           </div>
           <div class="form-group">
             <label for="annee">Année</label>
             <input class="form-control" type="number" name="annee" value="<?php echo getInfoEleve(getEleveByUtilisateur($utilisateurAlter["idUtilisateur"])[0]["idEleve"])["annee"]; ?>" required>
           </div>
           <?php } ?>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
            <input type="hidden" name="idUtilisateur" value="<?php echo $idUtilisateurAlter; ?>">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal de suppression d'un utilisateur-->
<div class="modal fade" id="modalSupprimerUtilisateur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer cet utilisateur ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <p>Une fois supprimé l'utilisateur ne sera plus récupérable. De plus, si c'est un élève toutes ces evaluations seront supprimée. Si c'est un enseignants et qu'il possède des projets, l'utilisateur ne sera pas supprimé</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <form action="model/deleteUtilisateur.php" method="POST">
          <input type="hidden" name="idUtilisateur" value="<?php echo $idUtilisateurAlter; ?>">
          <input type="hidden" name="statut" value="<?php echo $utilisateurAlter["statut"]; ?>">
          <button type="submit" class="btn btn-primary">Supprimer</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<!-- Modal d'ajout d'une catégorie-->
<div class="modal fade" id="modalAjoutCategorie" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="model/addCategorie.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajout d'une catégorie de critère</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <div class="form-group">
           <label for="">Nom de la catégorie</label>
           <input class="form-control" type="text" name="categorie" required>
         </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
<!-- Modal d'ajout d'un domaine-->
<div class="modal fade" id="modalAjoutDomaine" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="model/addDomaine.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajout d'un domaine de projets</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <div class="form-group">
           <label for="">Nom du domaine</label>
           <input class="form-control" type="text" name="domaine" required>
         </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
<!-- Modal d'ajout d'un utilisateur-->
<div class="modal fade" id="modalAjoutUtilisateur" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="model/addUtilisateur.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ajout d'un utilisateur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info">&#x26a0; Si deux utilisateurs ont le même nom et prénom, rajouter le deuxième prénom ou la date de naissance dans le prénom</div>
         <div class="form-group">
           <label for="">Nom</label>
           <input class="form-control" type="text" name="nom" required>
         </div>
         <div class="form-group">
           <label for="">Prénom</label>
           <input class="form-control" type="text" name="prenom" required>
         </div>
         <div class="form-group">
           <label for="">Email</label>
           <input class="form-control" type="email" name="email" required>
         </div>
         <div class="form-group">
           <label for="">Mot de passe</label>
           <input class="form-control" type="password" name="motDePasse" required>
         </div>
         <div class="form-group">
           <label>Statut</label>
           <select class="form-control" name="statut" id="statut">
             <option value="1">Administrateur</option>
             <option value="2" selected>Enseignant</option>
             <option value="3">Elève</option>
           </select>
         </div>
         <div class="eleveContent"><!-- input de Classe et Année si élève choisit plus haut --></div>
         <script type="text/javascript">
         $(document).ready(function() {
            $('#statut').change(function(){
                if ($(this).find("option:selected").attr('value') == 3) {
                  $(".eleveContent").append("<label>Classe</label><input class=\"form-control\" name=\"classe\" type=\"text\" ><br><label>Année</label><input class=\"form-control\" name=\"annee\" type=\"number\" ><br>");
                }
                else {
                  $(".eleveContent").empty();
                }
            });
         });
         </script>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="location.href ='index.php?page=projets';">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
