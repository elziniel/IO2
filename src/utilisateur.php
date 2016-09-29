<div id='centre'>
	<?php
		// On sélectionne les données de l'utilisateur en question pour les afficher
		$select = "SELECT * FROM utilisateurs WHERE Identifiant = '".$_GET['user']."'";
		$query = mysql_query($select, $connexion);
		$data = mysql_fetch_assoc($query);
		echo "
			<h1>".$data['Identifiant']."</h1>
			<div><img src='".$data['Avatar']."' width='200px' height='200px'></div>
			<div>Nom : ".$data['Nom']."</div>
			<div>Prénom : ".$data['Prenom']."</div>
			<div>Date de naissance : ".$data['Date']."</div>
			<div>Ville : ".$data['Ville']."</div>
		";
	?>
</div>