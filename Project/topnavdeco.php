<div id='topBar'>
	<div id='topColor'>
		<img src='blanc.png' onclick="document.hddn.style.value='1'; document.hddn.submit()">  
		<img src='noir.png' onclick="document.hddn.style.value='2'; document.hddn.submit()">
	</div>
	<div id='topMenu'>
		<a href='index.php?id=deconnexion' style='width: 90px'>Déconnexion</a>
		<?php echo "<a href='index.php?id=parametres' style='width: ".(strlen($_SESSION['Identifiant'])/1.5)."em'>".$_SESSION['Identifiant']."</a>"; ?>
	</div>
	<div id='topTitle'>
		<a href='index.php'>Association</a>
	</div>
</div>