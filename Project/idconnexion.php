<div id='centre'>
	<h1>CONNEXION</h1>
	<?php
		
		// Si le formulaire est rempli, on recherche l'utilisateur
		if(isset($_POST['identifiant']) && isset($_POST['password'])){
			$select = "SELECT Identifiant, Competence, Password FROM utilisateurs WHERE Identifiant = '".$_POST['identifiant']."'";
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
			
			// Sinon on ouvre une nouvelle session contenant l'identifiant et la compétence de l'utilisateur
			else{
				$test = false;
				$_SESSION['Identifiant'] = $data['Identifiant'];
				$_SESSION['Competence'] = $data['Competence'];
				echo "
					<p>Vous êtes bien connecté</p>
					<p><a href=\"index.php\">Page d'accueil</a></p>
				";
			}
		}
		
		// Si $_POST n'est pas vide mais qu'aucun cas précédent n'a été rencontré, un champ est forcément manquant
		else if(!empty($_POST)){
			echo "<p>Vous avez oublié de remplir un champ</p>";
		}
		
		if($test){
			echo "
				<form method='POST'>
					<dl>
						<dt><input type='text' name='identifiant' placeholder='Nom de compte'></dt>
						<dt><input type='password' name='password' placeholder='Mot de passe'></dt>
						<dt><input type='submit' value='Connexion'></dt>
					</dl>
				</form>
			";
		}
	?>
</div>