<div id='centre' style='height: 225px'>
	<h1>MOT DE PASSE</h1>
	<?php
		
		// Si le formulaire est rempli, on procède à quelques vérifications
		if(isset($_POST['password']) && isset($_POST['npassword']) && isset($_POST['cpassword'])){
			$requete = "SELECT Password FROM utilisateurs WHERE Identifiant = '".$_SESSION['Identifiant']."'";
			$data = mysql_fetch_assoc(mysql_query($requete));
			
			if($data['Password'] != md5($_POST['password'])){
				echo "<p>Ancien mot de passe incorrecte.</p>";
			}
			
			else if($_POST['npassword'] != $_POST['cpassword']){
				echo "<p>Confirmation du mot de passe incorrecte.</p>";
			}
			
			// Si tout est en règle, on modifie le mot de passe de l'utilisateur
			else{
				$test = false;
				$password = md5(mysql_real_escape_string($_POST['npassword']));
				$update = "UPDATE utilisateurs SET Password = '".$password."' WHERE Identifiant = '".$_SESSION['Identifiant']."'";
				$query = mysql_query($update, $connexion);
				echo "
					<p>Votre mot de passe a été modifié.</p>
					<p><a href='?id=parametres'>Revenir aux paramètres</a></p>
				";
			}
		}
		if($test){
			echo "
				<form method='POST'>
					<label>Ancien mot de passe : <input type='password' name='password'></label>
					<label>Nouveau mot de passe : <input type='password' name='npassword'></label>
					<label>Confirmer le nouveau mot de passe : <input type='password' name='cpassword'></label>
					<label><input type='submit' value='Modifier'></label>
				</form>
			";
		}
	?>
</div>