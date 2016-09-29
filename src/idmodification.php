<div id='centre' style='height: 250px'>
	<h1>MODIFICATION</h1>
	<?php
		$requete = "SELECT * FROM utilisateurs WHERE Identifiant = '".$_SESSION['Identifiant']."'";
		$data = mysql_fetch_assoc(mysql_query($requete, $connexion));
		
		// Si le formulaire à été soumis, on met à jour les données de l'utilisateur
		if(!empty($_POST)){
			$test = false;
			$nom = mysql_real_escape_string($_POST['nom']);
			$prenom = mysql_real_escape_string($_POST['prenom']);
			$date = $_POST['date'];
			$sexe = $_POST['sexe'];
			$ville = mysql_real_escape_string($_POST['ville']);
			$update = "UPDATE utilisateurs SET Nom = '".$nom."', Prenom = '".$prenom."', Date = '".$date."', Sexe = '".$sexe."', Ville = '".$ville."' WHERE Identifiant = '".$_SESSION['Identifiant']."'";
			$query = mysql_query($update, $connexion);
			
			echo "
				<p>Vos modifications ont bien été prises en compte.</p>
				<p><a href='index.php?id=modification'>Revenir au modification</a></p>
			";
		}
		
		if($test){
			echo "
				<form method='POST'>
					<label>Nom : <input type='text' name='nom' value='".$data['Nom']."'></label>
					<label>Prénom : <input type='text' name='prenom' value='".$data['Prenom']."'></label>
					<label>Date de naissance : <input type='date' name='date' value='".$data['Date']."'></label>
					<label>Sexe : 
						<select name='sexe'>
			";
			
			// Le menu déroulant choisit par défaut le sexe de l'utilisateur pour éviter tout changement de sexe involontaire
			if($data['Sexe'] == ''){
				echo "
							<option value='' selected>                             </option>
							<option value='Homme'>Homme</option>
							<option value='Femme'>Femme</option>
				";
			}
			
			else if($data['Sexe'] == 'Homme'){
				echo "
							<option value=''>                             </option>
							<option value='Homme' selected>Homme</option>
							<option value='Femme'>Femme</option>
				";
			}
			
			else{
				echo "
							<option value=''>                             </option>
							<option value='Homme'>Homme</option>
							<option value='Femme'selected>Femme</option>
				";
			}
			
			echo "
						</select>
					</label>
					<label>Ville : <input type='text' name='ville' value='".$data['Ville']."'></label>
					<label><input type='submit' value='Modifier'></label>
				</form>
			";
		}
	?>
</div>