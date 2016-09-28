<div id='centre'>
	<h1>INSCRIPTION</h1>
	<?php
		
		// Si le formulaire est rempli, on procède à quelques vérifications
		if(!empty($_POST)){
			$mailselect = "SELECT Email, Identifiant FROM utilisateurs WHERE Email = '".$_POST['email']."'";
			$mailquery = mysql_query($mailselect, $connexion);
			$mailtest = mysql_num_rows($mailquery); // Nombre d'éléments de la table utilisateurs honorant la requête
			$idselect = "SELECT Identifiant FROM utilisateurs WHERE Identifiant = '".$_POST['identifiant']."'";
			$idquery = mysql_query($idselect, $connexion);
			$idtest = mysql_num_rows($idquery); // Nombre d'éléments de la table utilisateurs honorant la requête
			
			// Permet de vérifier si l'adresse email est unique (évite les multi-comptes)
			if($mailtest > 0){
				echo "<p>Adresse e-mail déjà utilisée, veuillez en choisir une autre</p>";
			}
			
			// Permet de vérifier si l'identifiant est unique (remplace l'ID par auto-incrémentation)
			else if($idtest > 0){
				echo "<p>Identifiant déjà utilisée, veuillez en choisir une autre</p>";
			}
			
			else{
			
				// Tous les champs sont requis pour éviter toutes confusion
				if(!isset($_POST['identifiant']) || !isset($_POST['email'])){
					echo "<p>Vous devez remplir tous les champs</p>";
				}
				
				// Si tout est en règle, on procède à l'enregistrement de l'utilisateur en lui fournissant un mot de passe créé par la fonction alea de la page index.php
				else{
					$test = false;
					$identifiant = mysql_real_escape_string (htmlentities($_POST['identifiant']));
					$email = mysql_real_escape_string($_POST['email']);
					$password = alea(8);
					echo "
						<div>Bonjour ".$_POST['identifiant'].".</div>
						<div>Votre mot de passe est : <b><font color='red'>".$password."</b></font>. Gardez-le en mémoire, il ne sera plus jamais affiché.</div>
						<p><a href='index.php?id=parametres'>Accéder au paramètre du compte</a></p>
					";
					$password = md5($password);
					$insert = "INSERT INTO utilisateurs (Identifiant, Email, Password) VALUES ('".$identifiant."', '".$email."', '".$password."')";
					$query = mysql_query($insert, $connexion);
					$select = "SELECT Identifiant, Competence FROM utilisateurs WHERE Identifiant = '".$_POST['identifiant']."'";
					$query = mysql_query($select, $connexion);
					$data = mysql_fetch_assoc($query);
					// On ouvre automatiquement la session de l'utilisateur
					$_SESSION['Identifiant'] = $data['Identifiant'];
					$_SESSION['Competence'] = $data['Competence'];
				}
			}
		}
		
		if($test){
			echo "
				<form method='POST'>
					<dl>
						<dt><input type='text' name='identifiant' placeholder='Nom de compte'></dt>
						<dt><input type='email' name='email' placeholder='Adresse e-mail'></dt>
						<dt><input type='submit' value='Inscription'></dt>
					</dl>
				</form>
			";
		}
	?>
</div>