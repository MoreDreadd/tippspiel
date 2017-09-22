<?PHP

    require_once('core/init.php');
    
    //Die ueber POST uebergebenen Werte werden gespeichert
    $tippA = escape($_POST['tippA']);

    $tippB = escape($_POST['tippB']);

    $spielID = escape($_POST['spielID']);

    

    mysql_connect(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'));
    mysql_select_db(Config::get('mysql/db'));

    

    $result = mysql_query("SELECT Beginn FROM spiel WHERE ID = ".$spielID); //Der Beginn des getippten Spiels wird abgefragt.

    $row = mysql_fetch_assoc($result);

    if ($row['Beginn'] > date("Y-m-d H:i:s")){ //Nur wenn das Spiel noch nicht begonnen hat, wird der Tipp verarbeitet. Hierdurch wird eine Umgehung der Datumsabfrage in der spiel.php durch direktes Aufrufen von tippen.php umgangen.

      $sql = "REPLACE tipp ";

      $sql .= "(SpielID, User, ToreA, ToreB) VALUES (";

      $sql .= "{$spielID}, \"" . Session::get('username') . "\", {$tippA}, {$tippB})";

      mysql_query($sql); //Der Tipp wird in die Datenbank eingetragen.

      Session::flash('spiele', '<div class="alert alert-success" role="alert">Ihr Tipp wurde verarbeitet!</div>');

    } else {
      Session::flash('spiele', '<div class="alert alert-danger" role="alert">Es gab ein Problem mit Ihrem Tipp!</div>');
    }

    

    mysql_close();

    Redirect::to("main.php?seite=spiele&meisterschaft=".$_REQUEST['meisterschaft']."&gruppe=".$_REQUEST['gruppe']);

?>

<!--

  In dieser Datei werden die Tipps ausgewertet.

-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>

  <head>

    <title>Tipp wird verarbeitet...</title>

    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

  </head>

  <body>
    Die Verarbeitung Ihres Tipps dauert l&auml;nger als &uuml;blich. Bitte haben Sie einen Moment Geduld!<br />
    Bei Problemen wenden Sie sich bitte an <a href='mailto:ferrarif97@gmail.com'>ferrarif97@gmail.com</a>.
  </body>

</html>