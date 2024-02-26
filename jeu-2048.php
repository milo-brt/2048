<!-- jeu-2048.php -->
<?php
$score;
$grille;
require_once 'fonctions-2048.php';
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Le jeu 2048</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="styles2048.css">
</head>

<?php
if (isset($_GET['action-joueur'])) {
	write_log($_GET['action-joueur']);
	if ($_GET['action-joueur'] == "new") {
		nouvelle_partie();
	} else {
		fichier_vers_matrice();
		fichier_vers_score();
		for ($i = 0; $i < 4; $i++) {
			switch ($_GET['action-joueur']) {
				case "left":
					decale_ligne_gauche($i);
					fusion_ligne_gauche($i);
					decale_ligne_gauche($i);
					break;
				case "right":
					decale_ligne_droite($i);
					fusion_ligne_droite($i);
					decale_ligne_droite($i);
					break;
				case "up":
					decale_col_haut($i);
					fusion_col_haut($i);
					decale_col_haut($i);
					break;
				case "down":
					decale_col_bas($i);
					fusion_col_bas($i);
					decale_col_bas($i);
					break;
			}
		}
		if (!grille_pleine()) {
			place_nouveau_nb();
		} else {
			echo "<div class='lost'>Perdu...</div>";
		}
	}
} else {
	fichier_vers_matrice();
	fichier_vers_score();
}
?>

<body>
	<h1>Le jeu 2048</h1>
	<form action="jeu-2048.php" id="leform">
		<button type="submit" name="action-joueur" value="new">Nouvelle partie</button>
		<p>Votre score :
			<?= affiche_score() ?>
		</p>
		<table>
			<?php
			for ($i = 0; $i < 4; $i++) {
				echo "<tr>";
				for ($j = 0; $j < 4; $j++) {
					affiche_case($i, $j);
				}
				echo "</tr>";
			}
			?>
		</table>
		<div class="controles">
			<button type="submit" name="action-joueur" value="left" id="left">
				<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-left"
					viewBox="0 0 16 16">
					<path fill-rule="evenodd"
						d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
				</svg>
			</button>
			<div class="hb">
				<button type="submit" name="action-joueur" value="up" id="up">
					<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-up"
						viewBox="0 0 16 16">
						<path fill-rule="evenodd"
							d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5" />
					</svg>
				</button>
				<button type="submit" name="action-joueur" value="down" id="down">
					<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-down"
						viewBox="0 0 16 16">
						<path fill-rule="evenodd"
							d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1" />
					</svg>
				</button>
			</div>
			<button type="submit" name="action-joueur" value="right" id="right">
				<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right"
					viewBox="0 0 16 16">
					<path fill-rule="evenodd"
						d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
				</svg>
			</button>
		</div>
	</form>
	<div class="regles">
		<p>Le but du jeu est de faire glisser des tuiles sur une grille, pour combiner les tuiles de mêmes valeurs et
			créer ainsi une tuile portant le nombre 2048. Au début de la partie, deux cases contiennent un chiffre (2 ou
			4).
			Les nombres peuvent se déplacer à droite, à gauche, en haut ou en bas. Quand deux cases de même valeur se
			rencontrent,
			elles fusionnent en une case qui vaut la somme des 2. Après chacune de vos actions, une nouvelle case
			apparaît avec pour
			valeur 2 ou 4. Le but est donc d'obtenir une case valant 2048 avant que la grille ne soit pleine et qu'aucun
			mouvement ne soit plus possible.
		</p>
	</div>
	<footer>
		<a href="index.html">Relancer le jeu</a>
		<br />
		<a href="affiche-logs.php" target="_blank">Afficher les logs</a>
		<br />
		<a href="http://perso.univ-lyon1.fr/olivier.gluck/supports_enseig.html#LIFRW" target="_blank">Page du cours</a>
	</footer>

	<script>
		document.addEventListener(
			"keydown",
			(event) => {
				switch (event.key) {
					case "ArrowUp":
						event.preventDefault();
						document.getElementById("leform").requestSubmit(document.getElementById("up"));
						break;
					case "ArrowDown":
						event.preventDefault();
						document.getElementById("leform").requestSubmit(document.getElementById("down"));
						break;
					case "ArrowLeft":
						event.preventDefault();
						document.getElementById("leform").requestSubmit(document.getElementById("left"));
						break;
					case "ArrowRight":
						event.preventDefault();
						document.getElementById("leform").requestSubmit(document.getElementById("right"));
						break;
					default:
						break;
				}
			},
			false
		);
	</script>
</body>

</html>

<?php
matrice_vers_fichier();
score_vers_fichier();
?>