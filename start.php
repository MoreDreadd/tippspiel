    <!-- Die Seite, die am Anfang eingebunden wird -->
      <p>
        Willkommen, <?php echo Session::get('username'); ?>, zum Tippspiel zur <?php echo Session::get('meisterschafts_title'); ?>.<br /> <br />
      </p>
      <p>
        Oben k&ouml;nnen Sie die <b>Anleitung</b> lesen, den aktuellen <b>Punktestand</b> nachschauen und die Ergebnisse der einzelnen <b>Spiele</b> tippen.<br />
        Au&szlig;erdem finden Sie unter <b>Tipps</b> eine &Uuml;bersicht &uuml;ber die Tipps zu bereits begonnenen Spielen.
      </p>
      <br /><br />
      <p>
      <?php
	//mysql_connect($dbziel, $dbname, $dbpass);
	//mysql_select_db($db);
    
        $db = DB::getInstance();
        $db->query("SELECT COUNT(*) AS Anzahl FROM (SELECT DISTINCT tipp.User FROM tipp, spiel WHERE tipp.SpielID = spiel.ID AND spiel.MeisterschaftsID = '" . Config::get('meisterschaft/meisterschafts_id') . "') AS Tipper"); //Die Abfrage gibt die Anzahl der Spieler aus, die bisher Tipps abgegeben haben
	      //$result = $db->results();
	      //$row = mysql_fetch_assoc($result);

        echo "Es haben schon ".$db->first()->Anzahl." Personen Tipps abgegeben!";
      ?>
      </p>
      <br />
      <br />
      <p>
        <h3>Neuigkeiten:</h3>
        <?php

          $user = new User();
          $id = Session::get(Config::get('session/session_name'));
          if($user->find($id)) {
            if($user->hasPermission(2)) {
              include 'inputForm.php';
            }
          }

        ?>

        <?php
        
          $db->query("SELECT * FROM news ORDER BY date DESC");
          $news = $db->results();
          foreach ($news as $row) {
            $db->query('SELECT name FROM users WHERE id = ' . $row->author);
            $author = $db->first()->name;
            echo "<p>";
            echo "<blockquote><p>";
            echo "<h4>" . $row->title . "</h4>";
            echo $row->text . "</p>";
            echo "<footer>" . $author . ", " . $row->date . "</footer>";
            echo "</blockquote>";
            echo "</p>";
          }

        ?>
      </p>