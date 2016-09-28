<div id='centre'>
	<h1>ORGANIGRAMME</h1>
	<?php
		// On sélectionne les administrateurs pour les afficher
		$select = "SELECT * FROM utilisateurs WHERE Competence = 'Administrateur'";
		$query = mysql_query($select, $connexion);
		echo "<p>ADMINISTRATEUR</p>";
		
		while($ligne = mysql_fetch_array($query)){ // Passe à l'élément suivant
			echo "<div><a href='index.php?user=".$ligne['Identifiant']."'>".$ligne['Identifiant']."</a></div>";
		}
		
		// On sélectionne les modérateurs pour les afficher
		$select = "SELECT * FROM utilisateurs WHERE Competence = 'Moderateur'";
		$query = mysql_query($select, $connexion);
		echo "<p>MODÉRATEUR</p>";
		
		while($ligne = mysql_fetch_array($query)){ // Passe à l'élément suivant
			echo "<div><a href='index.php?user=".$ligne['Identifiant']."'>".$ligne['Identifiant']."</a></div>";
		}
		
		// On sélectionne les membres pour les afficher
		$select = "SELECT * FROM utilisateurs WHERE Competence = 'Membre'";
		$query = mysql_query($select, $connexion);
		echo "<p>MEMBRES</p>";
		
		while($ligne = mysql_fetch_array($query)){ // Passe à l'élément suivant
			echo "<div><a href='index.php?user=".$ligne['Identifiant']."'>".$ligne['Identifiant']."</a></div>";
		}
	?>
</div>