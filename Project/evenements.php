<div id='centre'>
	<h1>ÉVÈNEMENTS</h1>
</div>
<?php
	if(!empty($_POST)){
		// On donne une ID aléatoire à l'évènement pour éviter tout problème de modification non permise
		// Par auto-incrémentation, un simple membre peut déduire l'ID de l'évènement précédent dont il n'a pas les droits puis modifier la page source pour procéder à la modification
		$id = alea(6);
		$nom = $_SESSION['Identifiant'];
		$date = date('d')."/".date('m')."/".date('Y');
		$heure = (date('H')+2).":".date('i');
		
		// Si le formulaire principal est rempli, on ajoute l'évènement
		if(isset($_POST['titre']) && isset($_POST['evenement'])){
			$titre = mysql_real_escape_string($_POST['titre']);
			$evenement = mysql_real_escape_string($_POST['evenement']);
			$insert = "INSERT INTO evenements (ID, Nom, Titre, Evenement, Date, Heure) VALUES ('".$id."', '".$nom."', '".$titre."', '".$evenement."', '".$date."', '".$heure."')";
			$query = mysql_query($insert, $connexion);
		}
		
		// Si le formulaire secondaire est rempli, on modifie l'évènement
		if(isset($_POST['mtitre']) && isset($_POST['mevenement'])){
			$id = $_POST['id'];
			$titre = mysql_real_escape_string($_POST['mtitre']);
			$evenement = mysql_real_escape_string(nl2br($_POST['mevenement']));
			$update = "UPDATE evenements SET Modif = '".$nom."', Titre = '".$titre."', evenement = '".$evenement."', Mdate = '".$date."', Mheure = '".$heure."' WHERE ID = '".$id."'";
			$query = mysql_query($update, $connexion);
		}
	}
	
	// Si l'utilisateur clique sur 'Supprimer', le champ suppr du formulaire hddn a pris pour valeur l'ID de l'évènement, puis on supprime l'évènement par son ID
	if(isset($_POST['suppr'])){
		$delete = "DELETE FROM evenements WHERE ID = '".$_POST['suppr']."'";
		$query = mysql_query($delete, $connexion);
	}
	
	$select = "SELECT * FROM evenements";
	$query = mysql_query($select, $connexion);
	$nbevenement = mysql_num_rows($query); // Nombre d'éléments de la table evenements honorant la requête
	
	// Si la table evenements de la base de données contient au moins un élément, on affiche les évènements un par un
	if($nbevenement > 0){
		echo "<div id='juste'>";
		while($ligne = mysql_fetch_array($query)){ // Passe à l'élément suivant
			echo "
				<div id='article'>
				<div id='titre'>".$ligne['Titre']."</div>
				<div id='date'>Par ".$ligne['Nom']." le ".$ligne['Date']." à ".$ligne['Heure']."</div>
			";
			
			// Si un utilisateur à modifié l'évènement, on l'affiche
			if(!empty($ligne['Modif'])){
				echo "<div id='date'>Modifié par ".$ligne['Modif']." le ".$ligne['Mdate']." à ".$ligne['Mheure']."</div>";
			}
			
			echo "<div id='contenu'>".$ligne['Evenement']."</div>";
			
			// Seul le créateur de l'évènement, les administrateur et les modérateurs peuvent modifier ou supprimer l'évènement
			if(isset($_SESSION['Identifiant']) && isset($_SESSION['Competence'])){
				if($_SESSION['Identifiant'] == $ligne['Nom'] || $_SESSION['Competence'] == 'Administrateur' || $_SESSION['Competence'] == 'Moderateur'){
					echo "<div id='date'><a href='#' onclick=\"document.hddn.modif.value='".$ligne['ID']."'; document.hddn.submit()\">Modifier</a> | <a href='#' onclick=\"document.hddn.suppr.value='".$ligne['ID']."'; document.hddn.submit()\">Supprimer</a></div>";
				}
			}
			
			echo "</div>";
		}
		
		echo "</div>";
	}
	
	echo "<div id='centre'>";
	
	// Si l'utilisateur clique sur 'Modifier', le champ modif du formulaire hddn a pris pour valeur l'ID de l'évènement, puis on affiche le formulaire secondaire permettant de modifier l'évènement
	if(isset($_POST['modif'])){
		$test = false;
		$select = "SELECT * FROM evenements WHERE ID = '".$_POST['modif']."'";
		$query = mysql_query($select, $connexion);
		$data = mysql_fetch_assoc($query);
		echo "
			<form method='POST'>
				<dl>
					<dt><input type='text' name='mtitre' placeholder=\"Titre de l'évènement\" value=\"".$data['Titre']."\" style='width: 623px'></dt>
					<dt><textarea name='mevenement' cols='75' rows='15'>".$data['Evenement']."</textarea></dt>
					<input type='hidden' name='id' value=\"".$_POST['modif']."\">
					<dt><input type='submit' value=\"Modifier l'évènement\"></dt>
				</dl>
			</form>
		";
	}
	
	// Si l'utilisateur n'est ni connecté, ni inscrit, il n'a pas le droit d'ajouter un évènement
	if(!isset($_SESSION['Identifiant'])){
		echo "
			<p>Vous devez être inscrit pour organiser un évènement.</p>
			<p><a href='index.php?id=connexion'>Se connecter</a> | <a href='index.php?id=inscription'>S'inscrire</a></p>
		";
	}
	
	else if($test){
		echo "
			<form method='POST'>
				<dl>
					<dt><input type='text' name='titre' placeholder=\"Titre de l'évènement\" style='width: 623px'></dt>
					<dt><textarea name='evenement' cols='75' rows='15'></textarea></dt>
					<dt><input type='submit' value=\"Ajouter l'évènement\"></dt>
				</dl>
			</form>
		";
	}
	echo "</div>";
?>