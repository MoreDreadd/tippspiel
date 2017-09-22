<?php

  require_once 'core/init.php';

  $user = new User();
  if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
  }
?>
<!--

Autoren: Fabian Ferrari (, Philipp Ruland)

-->
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tippspiel</title>
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="javascript/TableSort.js" type="text/javascript"></script> <!-- Das Java-Script zum Sortieren der Tabelle wird eingebunden -->
  </head>
  <body>
      <div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
    <nav class="navbar navbar-fixed-top navbar-inverse">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-inverse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <li><a href="main.php?seite=start">Start</a></li>
          <li><a href="main.php?seite=anleitung">Anleitung</a></li>
          <li><a href="main.php?seite=punkte">Punkte</a></li>
          <li><a href="main.php?seite=spiele">Spiele</a></li>
          <li><a href="main.php?seite=tipps">Tipps</a></li>
        </ul>

        <!-- Das Dropdown Menue rechts -->
        <ul class="nav navbar-right navbar-nav" style="padding-right: 25px;">
          <li id="fat-menu" class="dropdown">
            <a href="#" class="dropdown-toggle" role="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo Session::get('username'); ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <li class="disabled"><a href="#">Mein Profil</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Abmelden</a></li>
            </ul>
          </li>
        </ul>

      </div>
    </nav>
    <div class="container-fluid">
    <div class="jumbotron"> <!--Der Inhalt-->

    <?PHP

      if(isset($_GET['seite'])){ //Wenn die Session "seite" gesetzt ist...
        $seite = $_GET["seite"]; //... wird $seite auf die uebergebene Seite gesetzt
      }
      else {
        $seite = ""; //... ansonsten wird in $seite ein leerer String gespeichert
      }

      switch($seite){ //Hier werden die verschiedenen Seiten eingebunden
      case "": include 'start.php'; break;
      case "start": include 'start.php'; break;
      case "anleitung": include 'anleitung.php'; break;
      case "punkte": include 'punkte.php'; break;
      case "spiele": include 'spiele.php'; break;
      case "tipps": include 'tipps.php'; break;
      }
    ?>

    </div>
    <footer>
      <p class="pull-right"><a href="#" class="body">nach oben</a></p>
      <p>&copy; 2017 Fabian Ferrari &middot; <a href="impressum.php" class="body">Impressum</a></p>
    </footer>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
  </body>
</html>
