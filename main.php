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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <!--<link rel="shortcut icon" type="image/x-icon" href="icon.ico">-->
    <meta charset="utf-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EM Tippspiel</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">-->
    <!--<link rel="stylesheet" type="text/css" href="style.css">-->
    <!--<link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tippspiel</title>
	<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body style="padding: 40px">
    <div class="container-fluid"> <!--Hier steht alles drin-->
      <div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
      <div class="navbar navbar-fixed-top navbar-inverse"> <!--Die Navigationsleiste oben auf der Seite-->
      <div class="navbar-inner">
        <ul class="nav navbar-nav">
          <li><a href="main.php?seite=start">Start</a></li>
          <li><a href="main.php?seite=anleitung">Anleitung</a></li>
          <li><a href="main.php?seite=punkte">Punkte</a></li>
          <li><a href="main.php?seite=spiele">Spiele</a></li>
        </ul>

        <!-- Hier muss das Dropdown Menu noch eingebaut werden! -->
        <ul class="nav pull-right navbar-nav">
          <li class="dropdown"><a href="#" class="dropdown-toggle" date-toggle="dropdown"><?php echo Session::get('username'); ?> <b class="caret"></b></a>
          <ul class="dropdown-menu"><li>Not implemented yet</li></ul>
          </li>
          <li><a href="logout.php">Abmelden</a></li>
        </ul>

      </div>
    </div>
    <div class="jumbotron"> <!--Der Inhalt-->
    
    <?PHP
    
      //require_once('konfig.php'); //Die Konfigurationsdatei wird eingebunden
      
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
      }
    ?>
    
    </div>
    <footer>
      <p class="pull-right"><a href="#">nach oben</a></p>
      <p>&copy; 2016 Fabian Ferrari &middot; <a href="impressum.php">Impressum</a></p>
    </footer>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>