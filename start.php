    <!-- Die Seite, die am Anfang eingebunden wird -->
      <p>
        Willkommen, <?php echo Session::get('username'); ?>, zum Tippspiel zur <?php echo Session::get('meisterschafts_title'); ?>.<br /> <br />
      </p>
      <p>
        Oben k&ouml;nnen Sie die <b>Anleitung</b> lesen, den aktuellen <b>Punktestand</b> nachschauen und die Ergebnisse der einzelnen <b>Spiele</b> tippen.
      </p>
      <!--<br><br>
      <p>
      	Nat&uuml;rlich gibt es f&uuml;r flei&szlig;ige Tipper auch etwas zu gewinnen:<br />
      	1. Platz: Wert von 15 &euro;<br />
      	2. Platz: Wert von 10 &euro;<br />
      	3. Platz: Wert von 5 &euro;
      </p>-->
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
