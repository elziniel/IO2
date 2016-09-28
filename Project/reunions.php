<div id='centre'>
	<h1>RÉUNIONS</h1>
</div>
<?php
	if(!empty($_POST)){
		// On donne une ID aléatoire à la réunion pour éviter tout problème de suppression non permise
		// Par auto-incrémentation, n'importe qui peut déduire l'ID de l'évènement précédent dont il n'a pas les droits puis modifier la page source pour procéder à la suppression
		$id = alea(6);
		$nom = $_SESSION['Identifiant'];
		$date = date('d')."/".date('m')."/".date('Y');
		$heure = (date('H')+2).":".date('i');
		
		// Si le formulaire principal est rempli, on ajoute la réunion
		if(isset($_POST['titre']) && isset($_POST['reunion'])){
			$titre = mysql_real_escape_string($_POST['titre']);
			$reunion = mysql_real_escape_string($_POST['reunion']);
			$insert = "INSERT INTO reunions (ID, Nom, Titre, Reunion, Date, Heure) VALUES ('".$id."', '".$nom."', '".$titre."', '".$reunion."', '".$date."', '".$heure."')";
			$query = mysql_query($insert, $connexion);
		}
	}
	
	// Si l'utilisateur clique sur 'Supprimer', le champ suppr du formulaire hddn a pris pour valeur l'ID de l'évènement, puis on supprime la réunion par son ID
	if(isset($_POST['suppr'])){
		$delete = "DELETE FROM reunions WHERE ID = '".$_POST['suppr']."'";
		$query = mysql_query($delete, $connexion);
	}
	
	$select = "SELECT * FROM reunions";
	$query = mysql_query($select, $connexion);
	$nbevenement = mysql_num_rows($query); // Nombre d'éléments de la table reunions honorant la requête
	
	// Si la table reunions de la base de données contient au moins un élément, on affiche les réunions une par une
	if($nbevenement > 0){
		echo "<div id='juste'>";
		while($ligne = mysql_fetch_array($query)){ // Passe à l'élément suivant
			echo "
				<div id='article'>
				<div id='titre'>".$ligne['Titre']."</div>
				<div id='date'>Par ".$ligne['Nom']." le ".$ligne['Date']." à ".$ligne['Heure']."</div>
				<div id='contenu'>".$ligne['Reunion']."</div>
			";
			
			// Seul le créateur de la réunion supprimer la réunion
			if(isset($_SESSION['Identifiant'])){
				if($_SESSION['Identifiant'] == $ligne['Nom']){
					echo "<div id='date'><a href='#' onclick=\"document.hddn.suppr.value='".$ligne['ID']."'; document.hddn.submit()\">Supprimer</a></div>";
				}
			}
			
			echo "</div>";
		}
		
		echo "</div>";
	}
	
	echo "<div id='centre'>";
	
	// Si l'utilisateur n'est ni connecté, ni inscrit, il n'a pas le droit d'ajouter une réunion
	if(!isset($_SESSION['Identifiant'])){
		echo "
			<p>Vous devez être inscrit pour organiser une réunion.</p>
			<p><a href='index.php?id=connexion'>Se connecter</a> | <a href='index.php?id=inscription'>S'inscrire</a></p>
		";
	}
	
	// Si l'utilisateur n'est ni administrateur, ni modérateur, il n'a pas le droit d'ajouter une réunion
	else if($_SESSION['Competence'] != 'Administrateur' && $_SESSION['Competence'] != 'Moderateur'){
		echo "
			<p>Seuls les administrateurs et modérateurs peuvent organiser une réunion.</p>
		";
	}
	
	else if($test){
		echo "
			<form method='POST'>
				<dl>
					<dt><input type='text' name='titre' placeholder=\"Titre de la réunion\" style='width: 623px'></dt>
					<dt><textarea name='reunion' cols='75' rows='15'></textarea></dt>
					<dt><input type='submit' value=\"Ajouter la réunion\"></dt>
				</dl>
			</form>
		";
	}
	echo "</div>";
?>