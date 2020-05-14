<div class="marge"></div>
<div class="container">
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      <form action="./model/checkLogin.php" method="POST" class="loginForm">
        <h2 class="text-center title">Inscription</h2>
        <div class="alert alert-primary" role="alert">
          Vous avez déja un compte ? Connectez-vous <a href="index.php?page=login">ici</a>
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
          <input type="email" class="form-control" placeholder="Adresse E-mail" name="email" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Mot de passe" name="motDePasse" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Répétez le Mot de passe" name="motDePasseRepete" required>
        </div>
        <button type="submit" class="btn btn-info btn-block">S'inscrire</button><br>
      </form>
    </div>
    <div class="col-3"></div>
  </div>
</div>
</body>
</html>
