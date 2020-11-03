
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - login form</title>
  <link rel="stylesheet" href="css/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<!-- LOGFORM -->
<h2>Bienvenue dans mon explorateur de fichier </h2>
<img src="logoexplorateur.png" />
    <div class="logForm">
        <div class="chooseForm">
          <a id="connexion">CONNEXION</a>
        </div>
          <div class="loginForm" id="loginForm">
            <?php
if (isset($_POST['pass']) AND $_POST['pass'] == "rajae farhane" AND isset($_POST['pseudo']) AND $_POST['pseudo'] == "rajae19beddi@gmail.com")
{
    header("Location: traitement.php");
}
else
    {

?>
            <form method="post" action="" class="formBloc">
              <label for="pseudo"><i class="fas fa-user"></i> Pseudo</label>
              <input class="pseudo inputText" type="text" name="pseudo">
              <label for="password"><i class="fas fa-lock"></i> Mot de passe</label>
              <input class="password inputText" type="password" name="pass">
              <div class="inputCheckbox">
                <input class="save" type="checkbox" name="save">
                <label for="save">Se souvenir de moi ?</label>
              </div>
              <input class="submit" type="submit" name="submit" value="SE CONNECTER">
            </form>
            <?php

    }
?>
            <a href="#">Mot de passe oublié ?</a>
          </div>
    </div>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
