<div id='centre'>
	<h1>DÉSINSCRIPTION</h1>
	<?php
	
		// Si le formulaire est rempli, on recherche l'utilisateur
		if(isset($_POST['identifiant']) && isset($_POST['password'])){
			$select = "SELECT Password FROM utilisateurs WHERE Identifiant = '".$_POST['identifiant']."'";
			$query = mysql_query($select, $connexion);
			$data = mysql_fetch_assoc($query);
			
			// Si la recherche n'abouti pas, le nom de compte est forcément faux
			if(!$data){
				echo "<p>Nom de compte incorrecte.</p>";
			}
			
			// Si le mot de passe est faux, on le signal à l'utilisateur
			else if($data['Password'] != md5($_POST['password'])){
				echo "<p>Mot de passe incorrecte.</p>";
			}
			
			// Sinon on désinscrit l'utilisateur
			else{
				$test = false;
				$delete = "DELETE FROM utilisateurs WHERE Identifiant = '".$_POST['identifiant']."'";
				$query = mysql_query($delete, $connexion);
				session_destroy();
				echo "
					<p>Vous avez été désinscrit de ce site.</p>
					<p><a href='index.php'>Page d'accueil</a></p>
				";
			}
		}
		
		// Si $_POST n'est pas vide mais qu'aucun cas précédent n'a été rencontré, un champ est forcément manquant
		else if(!empty($_POST)){
			echo "<p>Vous avez oublié de remplir un champ</p>";
		}
		
		if($test){
			echo "
				<p>Pour vous désinscrire, veuillez entrer votre nom de compte et votre mot de passe.</p>
				<form method='POST'>
					<dl>
						<dt><input type='text' name='identifiant' placeholder='Nom de compte'></dt>
						<dt><input type='password' name='password' placeholder='Mot de passe'></dt>
						<dt><input type='submit' value='Désinscription'></dt>
					</dl>
				</form>
			";
		}
	?>
</div>