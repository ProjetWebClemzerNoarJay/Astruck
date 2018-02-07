<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Boissons - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<section>
		<?php
			include 'bandeau.php';
		?>
		<h1 id="titreboisson">Nos Boissons</h1>
		<div id="boissonsP">
            <div id="cafe" class="boisson">
                <h2>Café</h2>
                <p>Prix = 1€</p>
                <img src="../img/boissons/café.png" alt="Café" title="Café"/>
            </div>
            <div id="coca-cola" class="boisson">
            <h2>Coca-Cola</h2>
                <p>Prix = 2€</p>
                <img src="../img/boissons/cocaCola.png" alt="Coca-Cola" title="Coca-Cola"/>
            </div>
            <div id="orangina" class="boisson">
                <h2>Orangina</h2>
                <p>Prix = 2€</p>
                <img src="../img/boissons/orangina.png" alt="Orangina" title="Orangina"/>
            </div>
            <div id="liptonicetea" class="boisson">
                <h2>Liptton Ice-Tea</h2>
                <p>Prix = 2€</p>
                <img src="../img/boissons/iceTea.png" alt="Lipton Ice-Tea" title="Lipton Ice-Tea"/>
            </div>
            <div id="the" class="boisson">
                <h2>thé</h2>
                <p>Prix = 1.50€</p>
                <img src="../img/boissons/tea.png" alt="Thé" title="Thé"/>
            </div>
            <div id="minutemaid" class="boisson">
                <h2>Minute Maid</h2>
                <p>Prix = 2€</p>
                <img src="../img/boissons/minuteMaid.png" alt="Minute Maid" title="Minute Maid"/>
            </div>
            <div id="fanta" class="boisson">
                <h2>Fanta</h2>
                <p>Prix = 2€</p>
                <img src="../img/boissons/fanta.png" alt="Fanta" title="Fanta"/>
            </div>
            <div id="breizh-cola" class="boisson">
                <h2>Breizh-Cola</h2>
                <p>Prix = 2€</p>
                <img src="../img/boissons/breizhCola.png" alt="Breizh-Cola" title="Breizh-Cola" id="bCoca"/>
            </div>
            <div id="chocolatchaud" class="boisson">
                <h2>Chocolat Chaud</h2>
                <p>Prix = 1.50€</p>
                <img src="../img/boissons/chocolat.png" alt="Chocolat Chaud" title="Chocolat Chaud"/>
            </div>
        </div>
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>