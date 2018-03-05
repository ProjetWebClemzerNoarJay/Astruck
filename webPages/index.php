<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Accueil - Astruck</title>
</head>

	<?php 
		include 'header.php';
	?>
	<section id="index">
		<div id="banniere"><h1 id="titlePrinc">Astruck</h1></div>
			<!--Element map via Api de google pour generer la minicarte de position en temps réel-->
		<?php
			include 'bandeau.php';
		?>
		<article id="presentations">
			<h1>Qui sommes nous ?</h1>
			<video src="../video/#" controls autoload>Merci de mettre votre navigateur à jour.</video>
			<p>Anne-Sophie et Nicolas sont un jeune couple avec 5 enfants, qui ont décidé de se lancer dans un projet de foodtruck spécialisé dans les hamburgers, Astruck vit le jour.<br/>
			Nous vous proposons nos délicieuses spécialités (hamburgers/boissons/desserts) à l'unité ou en menu,disponibles dans tout l'Ille et Vilaine (voir rubrique "Nous Trouver").
			</p>
		</article>
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>