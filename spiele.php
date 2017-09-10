  <div class="row">
    <div class="col-xs-3">
      <div class="sidebar-nav"> <!-- Der Container mit der Navigation fuer die Spiele -->
        <ul class="nav nav-list">
          <li><a href="main.php?seite=spiele&meisterschaft=1">&Uuml;bersicht</a></li>
          <!--<li class="nav-header">Gruppen</li>
          <li><a href="main.php?seite=spiele&gruppe=A">Gruppe A</a></li>
          <li><a href="main.php?seite=spiele&gruppe=B">Gruppe B</a></li>
          <li><a href="main.php?seite=spiele&gruppe=C">Gruppe C</a></li>
          <li><a href="main.php?seite=spiele&gruppe=D">Gruppe D</a></li>
          <li><a href="main.php?seite=spiele&gruppe=E">Gruppe E</a></li>
          <li><a href="main.php?seite=spiele&gruppe=F">Gruppe F</a></li>
          <li><a href="main.php?seite=spiele&gruppe=G">Gruppe G</a></li>
          <li><a href="main.php?seite=spiele&gruppe=H">Gruppe H</a></li>
          <li><a href="main.php?seite=spiele&gruppe=achtel">Achtelfinale</a></li>
          <li><a href="main.php?seite=spiele&gruppe=viertel">Viertelfinale</a></li>
          <li><a href="main.php?seite=spiele&gruppe=halb">Halbfinale</a></li>
          <li><a href="main.php?seite=spiele&gruppe=finale">Finale</a></li>-->
          <li class="nav-header">Spieltage</li>
          <li><a href="main.php?seite=spiele&gruppe=1">1. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=2">2. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=3">3. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=4">4. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=5">5. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=6">6. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=7">7. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=8">8. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=9">9. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=10">10. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=11">11. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=12">12. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=13">13. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=14">14. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=15">15. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=16">16. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=17">17. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=18">18. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=19">19. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=20">20. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=21">21. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=22">22. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=23">23. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=24">24. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=25">25. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=26">26. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=27">27. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=28">28. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=29">29. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=30">30. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=31">31. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=32">32. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=33">33. Spieltag</a></li>
          <li><a href="main.php?seite=spiele&gruppe=34">34. Spieltag</a></li>
        </ul>
      </div>
    </div>
    <div class="col-xs-6"> 
    
  <?php
      
      if(Session::exists('spiele')) {
        echo Session::flash('spiele');
      }

      $meisterschaft = Config::get('meisterschaft/meisterschafts_id');
      
      if(isset($_GET["gruppe"])){ //Die Gruppe wird festgelegt.
        $gruppe = $_GET["gruppe"];}
      else {$gruppe = "";}

        mysql_connect(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'));
        mysql_select_db(Config::get('mysql/db'));

        switch($gruppe){// Wenn keine Gruppe angegeben ist, werden alle Spiele der aktuellen Meisterschaft abgefragt, ansonsten nur die der aktuellen Gruppe
        case "": $abfrage = "SELECT spiel.ID, TeamA, TeamB, Beginn, spiel.ToreA, spiel.ToreB, tipp.ToreA AS TippA, tipp.ToreB AS TippB, Gruppe, Beginn FROM spiel LEFT JOIN tipp ON (spiel.ID = tipp.SpielID AND User = '".Session::get('username')."') WHERE MeisterschaftsID = ".$meisterschaft ." ORDER BY Beginn";
        break;
        default:  $abfrage = "SELECT spiel.ID, TeamA, TeamB, Beginn, spiel.ToreA, spiel.ToreB, tipp.ToreA AS TippA, tipp.ToreB AS TippB, Gruppe, Beginn FROM spiel LEFT JOIN tipp ON (spiel.ID = tipp.SpielID AND User = '".Session::get('username')."') WHERE spiel.Gruppe = \"".$gruppe."\" AND MeisterschaftsID = ".$meisterschaft ." ORDER BY Beginn";
        break;
        }
               
        $result = mysql_query($abfrage);
        $datum = date("Y-m-d H:i:s"); //Das aktuelle Datum und Uhrzeit wird gespeichert
        //$datum = "2014-09-01 00:00:00";
        if($gruppe==""){ //Die Ueberschrift, wenn alle Spiele ausgegeben werden
          echo "<u>Alle Spiele im &Uuml;berblick:</u><br /><br />";
        }
        echo "<table class='table table-striped table-responsive'>";
        if($gruppe == "") {
          echo "<tr><th>Ansto&szlig;</th><th>Team 1</th><th>Team 2</th><th>Endstand</th></tr>";
        } else {
          echo "<tr><th>Ansto&szlig;</th><th>Team 1</th><th>Tipp 1</th><th>Tipp 2</th><th>Team 2</th><th>Endstand</th></tr>";
        }
        while($row = mysql_fetch_assoc($result)){ //Die Ergebnisse der Abfrage werden Zeile fuer Zeile durchgegangen

                //Das Datum wird in ein Array gebracht, um es spaeter schoener ausgeben zu koennen
                $beginn = explode(" ", $row['Beginn']);
                $date = explode("-", $beginn[0]);
                $time = explode(":", $beginn[1]);

                $beginnAusgabe = $date[2] . "." . $date[1] . "." . $date[0] . "<br />" . $time[0] . ":" . $time[1];

                if($datum < $row['Beginn']){ //Wenn das Spiel noch nicht begonnen hat, ...
                  $endstand = "-"; //... bleibt der Endstand leer, ...
                }
                else{
                  $endstand = $row['ToreA']." : ".$row['ToreB']; //... ansonsten wird er auf das Ergebnis des Spiels gesetzt
                }
              if($gruppe==""){ //Wenn keine Gruppe angegeben ist, ...
                echo "<tr><td>" . $beginnAusgabe . "</td><td>" . $row['TeamA']."</td><td>".$row['TeamB']."</td><td>".$endstand."</td></tr>"; //... wird die Uebersicht aller Spiele ausgegeben, ...
                }
              else { //... ansonsten wird das Formular zum Tippen der Spiele der angegebenen Gruppe angezeigt:
                $tippA = $row['TippA'];
                $tippB = $row['TippB'];
               
                if($datum < $row['Beginn']){ //Wenn das Spiel noch nicht begonnen hat, wird das Fromular angezeigt und der Tipp des Spielers in die Felder eingetragen, ...
                  
                  echo "<tr><form action='tippen.php?gruppe=".$_GET['gruppe']."' method='POST'><td>" . $beginnAusgabe . "</td><td class='teamA'>"
                        .$row['TeamA'].
                        "</td><td><input type='text' name='tippA' id='tippA' maxlength='2' size='5' style='text-align:center' value='".$tippA."'>
                        </td><td>
                        <input type='text' name='tippB' id='tippB' maxlength='2' size='5' style='text-align:center' value='".$tippB."'></td><td>"
                        .$row['TeamB']."
                        </td><td><input type='submit' class='btn' value='tippen' /><input type='hidden' name='spielID' id='spielID' value='".$row['ID']."'></td>
                        </form></tr>";
              
                }
                else{ //... ansonsten wird das Formular angezeigt, die Textfelder werden gesperrt ("readonly") und statt des Buttons wird das Endergebnis angezeigt
                
                  echo "<tr><form><td>" . $beginnAusgabe . "</td><td class='teamA'>"
                        .$row['TeamA'].
                        "</td><td><input type='text' name='tippA' id='tippA' maxlength='2' size='5' style='text-align:center' value='".$tippA."' readonly>
                        </td><td>
                        <input type='text' name='tippB' id='tippB' maxlength='2' size='5' style='text-align:center' value='".$tippB."' readonly></td><td>"
                        .$row['TeamB']."
                        </td><td>" . $endstand . "</td>
                        </td>
                        </form></tr>";
                
                }

              }
        }
        echo "</table>";

        mysql_close();
  ?>
    </div>
  </div>
