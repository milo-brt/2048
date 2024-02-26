<?php require_once 'fonctions-2048.php'; ?>
<html>
 <head>
 	<meta charset="utf-8" />
 	<meta http-equiv="refresh" content="5" />
 	<title>Logs du jeu 2048</title>
 	<style>
		.new {
			font-weight: bold;
		}
		
		.left {
			color: #FF6542;
		}
		
		.up {
			color: #9000B3;
		}
		
		.right {
			color: #4A4A4A;
		}
		
		.down {
			color: #0090C1;
		}
 	</style>
 </head>
 <body>
 	<h2>Logs du jeu 2048</h2>
 	<?php
		affiche_logs(10);
 	?>
 </body>
</html>	
