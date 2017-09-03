<html>
  <head>
  <meta charset="utf-8">
	<script src="javascript/TableSort.js" type="text/javascript"></script> <!-- Das Java-Script zum Sortieren der Tabelle wird eingebunden -->
  </head>
  <body>
  
  <p>
    Hier sehen Sie eine &Uuml;bersicht der aktuellen Punkte.
    <br />
    <br />
    Anmerkung: Durch einen Klick auf die Tabellen&uuml;berschriften l&auml;sst sich die Tabelle ordnen.
  </p>
  <table>
  <tr>
  <td>
  <table class="table table-striped sortierbar"> <!-- Wichtig ist hier, dass die class "sortierbar" angegeben wird, genau wie bei den Tabellen&uuml;berschriften. Dadurch wird die Tabelle sortierbar -->
   <thead>
    <tr>
      <th class="sortierbar">Name</th>
      <th class="sortierbar">Richtige Tipps</th>
      <th class="sortierbar">Richtige Tendenz</th>
	 <th class="sortierbar">Richtiger Gewinner</th>
	 <th class="sortierbar">Fehltipps</th>
	 <th class="sortierbar">Punkte</th>
    </tr>
   </thead>
   <tbody>
  <?php
  
  
  /*
    Diese Funktion ueberprueft, ob ein User schon in einem Array vorhanden ist
    Parameter:  $user - der User, der in dem Array gesucht werden soll
                $array - das Array, in dem der User gesucht werden soll
    Return: true - wenn der User im Array schon vorhanden ist
            false - wenn der User im Array nicht vorhanden ist
  */
	function userInArray($user, $array){
    for($i=0;$i<count($array);$i++){
				if($user == $array[$i]){
          return(true);
        }
			}
	  return(false);
  }
		
    
	$user = array(); //Der Array, in dem jeder User einmal gespeichert wird
	$toreA = array(); //Der Array, in dem die geschossenen Tore von Team A gespeichert werden
	$toreB = array(); //Der Array, in dem die geschossenen Tore von Team B gespeichert werden
  $userS = array(); //Der Array, in dem die User in Abhaengigkeit von den getippten Spielen gespeichert werden (--> $userS[3] hat $tippA[3] und $tippB[3] getippt)
	//Spiel Tabellen
	$tippA = array(); //Der Array, in dem die getippten Tore von Team A gespeichert werden
	$tippB = array(); //Der Array, in dem die getippten Tore von Team B gespeichert werden
  
  
	mysql_connect(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'));
	mysql_select_db(Config::get('mysql/db'));

  //SQL-Abfrage: Es werden der Username, die geschossenen Tore der beiden Teams und die getippten Tore von Spielen, deren Endstand in der Datenbank eingetragen ist, abgerufen.
	$abfrage = "SELECT tipp.User, spiel.ToreA, spiel.ToreB, tipp.ToreA AS TippA, tipp.ToreB AS
              TippB
              FROM spiel, tipp
              WHERE spiel.ID = tipp.SpielID
              AND spiel.MeisterschaftsID = ".Config::get('meisterschaft/meisterschafts_id')."
              AND spiel.ToreA IS NOT NULL
              AND spiel.ToreB IS NOT NULL";
	$result = mysql_query($abfrage);
  
	if (mysql_num_rows($result)==0) { //Es wird ueberprueft, ob die Abfrage Ergebnisse wiedergegeben hat
    echo "</tbody> <tfoot><tr><td colspan='6' align='center'>Noch keine Tipps f&uuml;r beendete Spiele abgegeben.</td></tr></tfoot><tbody>";  //Falls noch keine Tipps fuer beendete Spiele abgegeben wurden, wird dies wiedergegeben
  }
  else{
    while($row = mysql_fetch_assoc($result)){ //Die Ergebnisse der Abfrage werden sortiert in die Arrays eingetragen
      array_push($toreA,  $row['TippA']);
      array_push($toreB,  $row['TippB']);
      array_push($tippA,  $row['ToreA']);
      array_push($tippB,  $row['ToreB']);
      array_push($userS,  $row['User']);
      if(!userInArray($row['User'], $user)){
        array_push($user, $row['User']);
      }
    }
    
  
	  for($i=0; $i<count($user); $i++){ //Der Array mit den Usern wird durchlaufen, sodass die folgenden Schritte fuer jeden User durchgefuehrt werden
      $richtigesErg = 0; //Die Anzahl der richtigen Tipps
      $richtigeTen = 0; //Die Anzahl der richtigen Tendenzen
      $richtigerGew = 0; //Die Anzahl der Tipps mit dem richtigen Gewinner des Spiels
      $fehltipp = 0; //Die Anzahl der Fehltipps
      $punkte = 0; //Die Punkte der Users
      //Diese Angaben werden fuer jeden User neu gesetzt, ausgegeben und dann fuer den naechsten User neu gesetzt
      
      for($k=0; $k<count($tippA); $k++){ //Alle Tipps werden durchlaufen
        
        if($userS[$k] == $user[$i]){ //Es wird ueberprueft, ob der aktuelle User auch den aktuellen Tipp abgegeben hat
          
          //richtiges Ergebnis
          if($tippA[$k] == $toreA[$k] && $tippB[$k] == $toreB[$k]){
            $richtigesErg++;
            $punkte += 3;
          }
          //richtige Tendenz
          elseif(($tippA[$k] - $tippB[$k]) == ($toreA[$k] - $toreB[$k])){
            $richtigeTen++;
            $punkte += 2;
          }
          //richtiger Gewinner
          elseif(($tippA[$k] > $tippB[$k]) && ($toreA[$k] > $toreB[$k]) || ($tippA[$k] < $tippB[$k]) && ($toreA[$k] < $toreB[$k])){
            $richtigerGew++;
            $punkte += 1;
          }
          //Fehltipp
          else{
            $fehltipp++;
          }
          
        }
        
      }
      
      //Die Daten des aktuellen Users (der angemeldet ist) werden rot angezeigt.
      if($user[$i] == Session::get('username')){
        $farbe = "red";
      }
      else{
        $farbe = "black";
      }
      
      //Ausgeben der Punkte fuer den aktuellen User
      echo "<tr style='color:".$farbe."'>";
      //echo "<td>".htmlentities($user[$i], ENT_QUOTES, 'UTF-8')."</td>";
      echo "<td>".$user[$i]."</td>";
			echo "<td>".$richtigesErg."</td>";
			echo "<td>".$richtigeTen."</td>";
			echo "<td>".$richtigerGew."</td>";
			echo "<td>".$fehltipp."</td>";
			echo "<td>".$punkte."</td>";
			echo "</tr>";
      
      
    }
		
	} 
  
	?>
   </tbody>

  </table>
  </td>
  
  <!--
  <td>
  <table border="8" style="float: right">  In dieser Tabelle werden die Platzierungen fest angezeigt 
    <thead>
      <tr>
      <th>Platzierung</th>
      </tr>
    </thead>
  <?PHP
    
    $platz = 1; //Die Platzierung des Spielers
    
    for($i=0; $i<count($user); $i++){
      echo "<tr>";
      echo "<td>";
      echo $platz;
      echo "</td>";
      echo "</tr>";
      
      $platz++;
    }
    
  ?>
  </table>
  </td>
  -->
  </tr>
  </table>
  
    <br />
    <br />
    
  </body>
</html>
