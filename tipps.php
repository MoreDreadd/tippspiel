<?php 

	$db = DB::getInstance();
	//if($db->query("SELECT * FROM spiel WHERE Beginn < " . date('Y-m-d H:i:s') . "AND spiel.MeisterschaftsID = ".Config::get('meisterschaft/meisterschafts_id')." ORDER BY ID")) {
	if($db->query("SELECT * FROM spiel WHERE MeisterschaftsID = ".Config::get('meisterschaft/meisterschafts_id')." ORDER BY ID")) {
		$spiele = $db->results();
	} else {
		die("Es gab ein Problem!");
	}

	$teamA = array();
	$teamB = array();
	$toreA = array();
	$toreB = array();
	$spielID = array();
	$anzahlSpiele = 0;

	foreach ($spiele as $spiel) {
		if($spiel->Beginn < date("Y-m-d H:i:s")) {
			array_push($teamA, $spiel->TeamA);
			array_push($teamB, $spiel->TeamB);
			array_push($toreA, $spiel->ToreA);
			array_push($toreB, $spiel->ToreB);
			array_push($spielID, $spiel->ID);
			$anzahlSpiele++;
		}
	}

	if($db->query("SELECT DISTINCT tipp.User FROM tipp, spiel, users WHERE tipp.SpielID = spiel.ID AND spiel.MeisterschaftsID = ".Config::get('meisterschaft/meisterschafts_id')." AND tipp.User = users.name AND users.showData = 1")) {
		$names = $db->results();
	} else {
		die("Es gab ein Problem!");
	}

	$users = array();

	foreach ($names as $name) {
		array_push($users, $name->User);
	}

?>

<div>
	<p>
		Hier sehen Sie eine &Uuml;bersicht &uuml;ber alle abgegebenen Tipps.<br />
		Angezeigt werden nur Nutzer, die dem Anzeigen ihrer Daten zugestimmt haben.
	</p>
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>Begegnung</th>
				<th>Ergebnis</th>
				<?php
					foreach ($users as $user) {
						echo "<th>".$user."</th>";
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php

				for($i = 0; $i < $anzahlSpiele; $i++) {
					echo "<tr>";
					echo "<td>".$teamA[$i]." : ".$teamB[$i]."</td>";
					echo "<td>".$toreA[$i].":".$toreB[$i]."</td>";
					foreach ($users as $user) {
						$db->query("SELECT ToreA, ToreB FROM tipp WHERE SpielID = ".$spielID[$i]." AND User = '".$user."'");
						if($db->count() != 0) {
							$tipp = $db->first();
							echo "<td>".$tipp->ToreA.":".$tipp->ToreB."</td>";
						} else {
							echo "<td>-</td>";
						}
					}
					echo "</tr>";
				}

			?>
		</tbody>
	</table>
</div>