<div id='centre'>
	<h1>ARTICLES</h1>
</div>
<?php
	if(!empty($_POST)){
		// On donne une ID aléatoire à l'article pour éviter tout problème de modification non permise
		// Par auto-incrémentation, un simple membre peut déduire l'ID de l'article précédent dont il n'a pas les droits puis modifier la page source pour procéder à la modification
		$id = alea(6);
		$nom = $_SESSION['Identifiant'];
		$date = date('d')."/".date('m')."/".date('Y');
		$heure = (date('H')).":".date('i');
		
		// Si le formulaire principal est rempli, on ajoute l'article
		if(isset($_POST['titre']) && isset($_POST['article'])){
			$titre = mysql_real_escape_string($_POST['titre']);
			$article = mysql_real_escape_string($_POST['article']);
			$insert = "INSERT INTO articles (ID, Nom, Titre, Article, Date, Heure) VALUES ('".$id."', '".$nom."', '".$titre."', '".$article."', '".$date."', '".$heure."')";
			$query = mysql_query($insert, $connexion);
		}
		
		// Si le formulaire secondaire est rempli, on modifie l'article
		if(isset($_POST['mtitre']) && isset($_POST['marticle'])){
			$id = $_POST['id'];
			$titre = mysql_real_escape_string($_POST['mtitre']);
			$article = mysql_real_escape_string(nl2br($_POST['marticle']));
			$update = "UPDATE articles SET Modif = '".$nom."', Titre = '".$titre."', Article = '".$article."', Mdate = '".$date."', Mheure = '".$heure."' WHERE ID = '".$id."'";
			$query = mysql_query($update, $connexion);
		}
	}
	
	// Si l'utilisateur clique sur 'Supprimer', le champ suppr du formulaire hddn a pris pour valeur l'ID de l'article, puis on supprime l'article par son ID
	if(isset($_POST['suppr'])){
		$delete = "DELETE FROM articles WHERE ID = '".$_POST['suppr']."'";
		$query = mysql_query($delete, $connexion);
	}
	
	$select = "SELECT * FROM articles";
	$query = mysql_query($select, $connexion);
	$nbarticle = mysql_num_rows($query); // Nombre d'éléments de la table articles honorant la requête
	
	// Si la table articles de la base de données contient au moins un élément, on affiche les articles un par un
	if($nbarticle > 0){
		echo "<div id='juste'>";
		while($ligne = mysql_fetch_array($query)){ // Passe à l'élément suivant
			echo "
				<div id='article'>
				<div id='titre'>".$ligne['Titre']= htmlentities($ligne['Titre'])."</div>
				<div id='date'>Par ".$ligne['Nom']." le ".$ligne['Date']." à ".$ligne['Heure']."</div>
			";
			
			// Si un utilisateur à modifié l'article, on l'affiche
			if(!empty($ligne['Modif'])){
				echo "<div id='date'>Modifié par ".$ligne['Modif']." le ".$ligne['Mdate']." à ".$ligne['Mheure']."</div>";
			}
			
			echo "<div id='contenu'>".($ligne['Article'])."</div>";
			
			// Seul le créateur de l'article, les administrateur et les modérateurs peuvent modifier ou supprimer l'article
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
	
	// Si l'utilisateur clique sur 'Modifier', le champ modif du formulaire hddn a pris pour valeur l'ID de l'article, puis on affiche le formulaire secondaire permettant de modifier l'article
	if(isset($_POST['modif'])){
		$test = false;
		$select = "SELECT * FROM articles WHERE ID = '".$_POST['modif']."'";
		$query = mysql_query($select, $connexion);
		$data = mysql_fetch_assoc($query);
		echo "
			<form method='POST'>
				<dl>
					<dt><input type='text' name='mtitre' placeholder=\"Titre de l'article\" value=\"".$data['Titre']."\" style='width: 623px'></dt>
					<dt><textarea name='marticle' cols='75' rows='15'>".$data['Article']."</textarea></dt>
					<input type='hidden' name='id' value=\"".$_POST['modif']."\">
					<dt><input type='submit' value=\"Modifier l'article\"></dt>
				</dl>
			</form>
		";
	}
	
	// Si l'utilisateur n'est ni connecté, ni inscrit, il n'a pas le droit d'ajouter un article
	if(!isset($_SESSION['Identifiant'])){
		echo "
			<p>Vous devez être inscrit pour soumettre un article.</p>
			<p><a href='index.php?id=connexion'>Se connecter</a> | <a href='index.php?id=inscription'>S'inscrire</a></p>
		";
	}
	
	else if($test){
		echo "
			<form method='POST'>
				<dl>
					<dt><input type='text' name='titre' placeholder=\"Titre de l'article\" style='width: 623px'></dt>
					<dt><textarea name='article' cols='75' rows='15'></textarea></dt>
					<dt><input type='submit' value=\"Soumettre l'article\"></dt>
				</dl>
			</form>
		";
	}
	
	echo "</div>";
?>