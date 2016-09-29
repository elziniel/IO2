<div id='centre'>
	<h1>PARAMÈTRES DU COMPTE</h1>
	<?php
		//On collecte les données de l'utilisateur pour les lui afficher
		$select = "SELECT * FROM utilisateurs WHERE Identifiant = '".$_SESSION['Identifiant']."'";
		$data = mysql_fetch_assoc(mysql_query($select, $connexion));
		echo "
			<div><img src='".$data['Avatar']."' width='200px' height='200px'></div>
			<div>Nom : ".$data['Nom']."</div>
			<div>Prénom : ".$data['Prenom']."</div>
			<div>Date de naissance : ".$data['Date']."</div>
			<div>Ville : ".$data['Ville']."</div>
		";
	?>
	<p><a href='index.php?id=modification'>Modifier le profil</a></p>
	<div><a href='index.php?id=modifavatar'>Modifier l'avatar</a></div>
	<div><a href='index.php?id=modifmdp'>Modifier le mot de passe</a></div>
	<p><a href='index.php?id=desinscription'>Désinscription</a></p>
</div>