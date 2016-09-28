<?php
	// On démarre la session
	session_start();
	
	// Si l'utilisateur change de style CSS, on configure un cookie pour le garder en mémoire
	if(isset($_POST['style'])){
	
		if($_POST['style'] != ''){
		
			setcookie('Style', $_POST['style'], (time() + 3600));
			
			// On rafraichit ensuite la page à l'aide de header pour rendre effectif le nouveau cookie
			if(isset($_GET['page'])){
				header("Location: http://localhost/Projet/index.php?page=".$_GET['page']);
			}
			
			else if(isset($_GET['id'])){
				header("Location: http://localhost/Projet/index.php?id=".$_GET['id']);
			}
			
			else{
				header("Location: http://localhost:8888");
			}
			
			exit;
		}
	}
	
	// La fonction alea qui permet de définir un mot de passe à l'utilisateur mais aussi une ID aux articles et évènements
	function alea($taille){
		$password = "";
		$caractere = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		for($i=0; $i<$taille; $i++){
			$password .= $caractere[array_rand($caractere)];
		}
		return $password;
	}
	
	$test = true;
	// Les informations nécessaires pour la connexion à la base de données
	$server = 'localhost';
	$user = 'root';
    $password = 'root';
	$base = 'projet';
	$connexion = mysql_connect($server, $user, $password);
	mysql_select_db($base, $connexion);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Association</title>
		<link rel='stylesheet' type='text/css' href='style
			<?php
				if(isset($_COOKIE['Style'])){
					echo $_COOKIE['Style'];
				}
				else{
					echo "1";
				}
			?>
		.css'>
	</head>
	<body>
		<div id='topPage'>
			<?php
				if(!empty($_SESSION)){
					include('topnavdeco.php');
				}else{
					include('topnavco.php');
				}
			?>
		</div>
		<div id='page'>
			<div id='leftCol'>
				<?php include('leftcol.php'); ?>
			</div>
			<div id='rightCol'>
				<?php include('rightcol.php'); ?>
			</div>
			<?php
				if(isset($_GET['page'])){
					include($_GET['page'].'.php');
				}
				else if(isset($_GET['id'])){
					include('id'.$_GET['id'].'.php');
				}
				else if(isset($_GET['user'])){
					include('utilisateur.php');
				}
				else{
					include('accueil.php');
				}
			?>
		</div>
		<form method='POST' name='hddn'>
			<input type='hidden' name='modif'>
			<input type='hidden' name='suppr'>
			<input type='hidden' name='style'>
		</form>
	</body>
</html>