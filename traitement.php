<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>File Explorer2</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
  </head>

  <body>
    <h2>Bienvenue Mme farhane rajae dans ton explorateur de fichier </h2>
    <img src="logoexplorateur.png" class="image" />
    <img src="images.png" class="image1" />
    <a  class="lien1" href="index.php">Déconnexion</a>
    <div class="backimage"></div>
      <div class="backimage1"></div>
    <?php
    session_start();
      // Ouvrir start au lancement du site
      if(!is_dir('start')) {  // si dossier start n'existe pas
      mkdir('start'); // le créer
      }

    // variable contenant le current work directory
    if(!isset($_GET['cwd'])) {
      $cwd = getcwd().DIRECTORY_SEPARATOR. 'start';
    } else {
      $cwd = $_GET['cwd'];
    }

    $start = getcwd().DIRECTORY_SEPARATOR. 'start';
    ?>
    <p class="chemin">
        <?php
    echo $cwd."<br>";  // affiche le répertoire en cours
    ?>
    </p>
    <?php
    $ariane = (explode(DIRECTORY_SEPARATOR,$cwd));
    $path = "";

    //  navbar et affichage  du traitement de dossier
    echo"<section id='menu'><label for='create_dir'></label>
    <input type='hidden' name='cwd' form='ch_cwd' value='".$cwd."'>
    <input type='text' placeholder= 'votre nouveau dossier'  class='createdossier' name='create_dir' form='ch_cwd'>
    <button type='submit' form='ch_cwd' class='create1'>add</button><br>
    <input type='text' placeholder= 'votre nouveau fichier' class='createfichier' name='create_file' form='ch_cwd'>
    <button type='submit' form='ch_cwd' class='create'>add</button><br>
    <div id='r-actions'>
    <button type='submit'  form='ch_cwd' name='cacher' class='ok'>cacher/affciher fichier cacher</button>
    <button type='submit' class='coller' form='ch_cwd' name='action' id='coller' value='paste'>coller</button>
    ";

    // la variable du fichier cacher
    $hidden_files = NULL;
    $hidden_files = isset($_GET['cacher']);

    // la creation d'un nouveau dossier
      if(isset($_GET['create_dir']) && $_GET['create_dir']!=NULL){
        $new_dir = $_GET['create_dir'];
        $wheretocreate = $_GET['cwd'];
        if (!is_dir($new_dir)) {
          mkdir($wheretocreate.DIRECTORY_SEPARATOR.$new_dir, 0777);
        } else {
          echo "<p class='rien'>Ce dossier existe déjà</p>";
        }
      }

      // la creation d'un nouveau fichier
      if(isset($_GET['create_file']) && $_GET['create_file']!=NULL){
        $new_dir = $_GET['create_file'];
        $wheretocreate = $_GET['cwd'];
        chdir($wheretocreate);
        if (!is_file($new_dir)) {
          fopen($new_dir, 'c+b');
        } else {
          echo "<p class='rien'>Ce fichier existe déjà</p>";
        }
      }



      //la variable de session de fichier copier
      if(isset($_GET['item_to_copy'])){
        $_SESSION['copied'] = $_GET['item_to_copy'];
      }

      // copier et coller d'un fichier
      if (isset($_GET['action'])) {
        if(!empty($_SESSION['copied'])){
        $lire = $_SESSION['copied'];
        $lire1 = explode(DIRECTORY_SEPARATOR,$lire);
        $lire1 = end($lire1);
        $file_copy = $cwd.DIRECTORY_SEPARATOR.$lire1."(copie)";
        copy($lire, $file_copy);
        session_destroy();
        }
        else{
          echo "<p class='rien'>Rien à coller</p>";
        }
      }

      // cacher un fichier
      if (isset($_GET['item_to_hide'])) {
        $lire = $_GET['item_to_hide'];
        $hide_item = explode(DIRECTORY_SEPARATOR, $lire);
        $editing_name = "." . end($hide_item);
        if ($editing_name == ".TRASH") {
          echo "<p class='rien'>Vous ne pouvez pas masquer cet élément</p>";
        } else {
        rename($lire, $cwd.DIRECTORY_SEPARATOR.$editing_name);
      }
    }

    // supprimer un fichier
    if (isset($_GET ['item_to_delete'])) {
      $lire = $_GET['item_to_delete'];
      $lire1 = explode(DIRECTORY_SEPARATOR,$lire);
      $lire1 = end($lire1);
      $trash = $start.DIRECTORY_SEPARATOR.'TRASH'.DIRECTORY_SEPARATOR.$lire1;
      if (filetype($lire) == "file") {
        copy($lire, $trash);
        unlink($lire);
        echo "<p class='rien'>L'élément a bien été supprimé !</p>";
      } else {
        echo "<p class='rien'>impossible de supprimer un dossier pour le moment</p>";
      }
    }

    // restaurer
    if (isset($_GET['item_to_restore'])) {
      $lire = $_GET['item_to_restore'];
      $lire1 = explode(DIRECTORY_SEPARATOR,$lire);
      $lire1 = end($lire1);
        if (filetype($lire) == "file") {
        copy($lire, $start.DIRECTORY_SEPARATOR.$lire1);
        unlink($lire);
        echo "<p class='rien'>L'élément a bien été restauré dans start! :)</p>";
      } else {
        echo "<p class='rien'>impossible de restaurer un dossier pour le moment :(</p>";
      }
    }
    // upload fichier
    echo "<form method='POST' enctype='multipart/form-data'>
    <input type='file' name='upload_file' class='upload'>
    <button type='submit' id='upload' id='upload'>Upload</button><br>
    </form></div></section>";

     if (isset($_POST['upload'])) {
       move_uploaded_file($_FILES['upload_file']['tmp_name'], $cwd.DIRECTORY_SEPARATOR.$_FILES['upload_file']['name']);
      }
    //form
    echo "<form method='GET' id='ch_cwd'><section id='content'>";

    // fil d'ariane

    foreach ($ariane as $value) {
    $path .= $value.DIRECTORY_SEPARATOR;
    if(strstr($path, 'start')){ // afficher chemin à partir de start
    echo "<button type='submit' form='ch_cwd' class='fileariane' name='cwd' value='". substr($path, 0, -1) ."'>"; // echo path sous forme de btn
    echo $value." /";
    echo "</button>";
    }
  } // la fin de la boucle de fil d'ariane
echo "<div id='display'>";
  // navigation et affichage
    $content = scandir($cwd); // afficher le contenu du dossier (ordre asendant par défaut)
    foreach ($content as &$value) {  // masquer . et ..
      // masquer et afficher
      if($value == '.' || $value == '..') { //si nom du fichier = . ou ..
        echo ' ';
      } elseif($hidden_files == NULL && $value[0] == '.') { // si checkbox pas cochée et fichier commence par un .
        echo '';  //n'affiche pas le fichier caché
      } else {
        $lire = $cwd.DIRECTORY_SEPARATOR.$value ; // récupère le cwd
        // AFFICHAGE DOSSIERS/FICHIERS
        if(filetype($lire) == "file") { //FICHIERS
          echo "<br>"."<li class='links'><a href='contenu.php?file_name=".$lire."' target='blank'><img src='file.png'><br>".$value."</a>";
        } elseif ($value === "TRASH") { //CORBEILLE
          echo "<br>" . "<button id='trash' type='submit' name='cwd' value='".$cwd.DIRECTORY_SEPARATOR.$value."'><img src='trash.png'><br>" . $value. "</button>";
        } else { //DOSSIERS
        echo "<br>" . "<li class='links'><button class='dir' type='submit' name='cwd' value='".$cwd.DIRECTORY_SEPARATOR.$value."'><img src='dir.png'><br>" . $value. "</button>";
      }
      // AFFICHAGE ACTIONS
      if ($value === "TRASH") {
        echo '';
      } else {
        if ($cwd !== $start.DIRECTORY_SEPARATOR.'TRASH') {
        echo "<div id='traitement'><button type='submit' name='item_to_copy' value='".$lire."' form='ch_cwd' class='action'>copy</button>
        <button type='submit' name='item_to_rename' value='".$lire."'
        form='ch_cwd' class='action'>rename</button>
        <button type='submit' name='item_to_hide' value='".$lire."' form='ch_cwd' class='action'>hide</button>
        <button type='submit' name='item_to_delete' value='".$lire."' form='ch_cwd' class='action'>delete</button></div>";
      } else { // RESTAURER
        echo "<button type='submit' name='item_to_restore' value='".$lire."' form='ch_cwd' id='restore'>restore</button>";
        }
      }
    }
    } //END OF FOREACH
    echo "</form></div></section>";

    // RENOMMER
    if(isset($_GET['item_to_rename'])) { // si lien rename est cliqué
      echo "<div id='rename'><form method='POST'>";
      echo "<input type='text' placeholder='new name' name='renaming'>";
      echo "<button type='submit' class='ok'>Ok</button>";
      echo "</form></div>";
    }
      if (isset($_POST['renaming']) ) { // si input validé
        $lire = $_GET['item_to_rename'];
        $rename_file = $_POST['renaming']; // récupère la valeur de l'input
        rename($lire, $cwd.DIRECTORY_SEPARATOR.$rename_file);
      }


     ?>
  </body>
</html>
