<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Carte - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<section>
		<?php
			include 'bandeau.php';
		?>
		<h1 id="titrecarte">La Carte</h1>
		<div id="carteM">
            <div id="cartemenumenus" class="carteMenu">
                <h2><a href="menus.html">Nos Menus</a></h2>
                <img src="../img/menus/maxi.png" alt="Menus" title="Menus"/>
            </div>
            <div id="cartemenuhamburgers" class="carteMenu">
                <h2><a href="hamburgers.html">Nos Hamburgers</a></h2>
                <img src="../img/hamburgers/bacon.png" alt="Hamburgers" title="Hamburgers"/>
            </div>
            <div id="cartemenudesserts" class="carteMenu">
                <h2><a href="desserts.html">Nos Desserts</a></h2>
                <img src="../img/desserts/glaces.png" alt="Desserts" title="Desserts" id="glace"/>
            </div>
            <div id="cartemenuboissons" class="carteMenu">
                <h2><a href="boissons.html">Nos Boissons</a></h2>
                <img src="../img/boissons/cocaCola.png" alt="Boissons" title="Boissons" id="coca"/>
            </div>
        </div>
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>