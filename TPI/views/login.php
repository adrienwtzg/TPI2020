<?php
//Message d'erreur de connexion
if (isset($_SESSION['loginError']))
{
    echo $_SESSION['loginError'];
    unset($_SESSION['loginError']);
}
?>
    <div class="marge"></div>
    <div class="container">
      <div class="row justify-content-center">

      <div class="col-md-6">
        <form action="./model/checkLogin.php" method="POST" class="loginForm">
          <h2 class="text-center title">Connexion</h2>
          <div class="alert alert-primary" role="alert">
            Vous n'avez pas de compte ? Inscrivez-vous <a href="index.php?page=inscription">ici</a>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Prénom" name="prenom" required>
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Nom" name="nom" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Mot de passe" name="motDePasse" required>
          </div>
          <button type="submit" class="btn btn-info btn-block">Se connecter</button><br>
        </form>
      </div>
    </div>
    </div>
  </body>
</html>
