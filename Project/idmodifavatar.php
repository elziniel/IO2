<div id='centre' style='height: 200px'>
	<h1>AVATAR</h1>
	<?php
		if(isset($_POST['avatar'])){
			$test = false;
			
			// Si l'utilisateur ne veut pas d'avatar, on lui choisit l'avatar par défaut
			if($_POST['avatar'] == ''){
				$avatar = 'http://farm4.staticflickr.com/3420/3886237197_b6fda27762_z.jpg';
			}
			
			// Sinon on met à jour son avatar
			else{
				$avatar = mysql_real_escape_string($_POST['avatar']);
			}
			$update = "UPDATE utilisateurs SET Avatar = '".$avatar."' WHERE Identifiant = '".$_SESSION['Identifiant']."'";
			$query = mysql_query($update, $connexion);
			echo "
				<p>Votre avatar a été modifié.</p>
				<p><a href='?id=parametres'>Revenir aux paramètres</a></p>
			";
		}
		
		if($test){
			echo "
				<form method='POST'>
					<label>URL de L'avatar : <input type='text' name='avatar'></label>
					<label><input type='submit' value=\"Modifier l'avatar\"></label>
				</form>
			";
		}
	?>
</div>