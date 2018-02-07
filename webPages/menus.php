<!DOCTYPE html>
<?php
    session_start();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Menus - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<section>
		<?php
			include 'bandeau.php';
		?>
		<h1 id="titremenus">Nos Menus</h1>
        <div id="listemenu">
            <div id="menu1" class="menuP">
                <h2>Classique</h2>
                <p>1 burger et 1 accompagnement (frites ou potatoes ou salade) + 1 boisson OU un dessert</p>
                <p>Prix = 8€50</p>
                <img src="../img/menus/complet.png" alt="Menu N°1" title="Menu N°1"/>
            </div>
            <div id="menu2" class="menuP">
                <h2>Maxi</h2>
                <p>1 burger et 1 accompagnement (frites ou potatoes ou salade) + 1 boisson ET un dessert</p>
                <p>Prix = 9€50</p>
                <img src="../img/menus/maxi.png" alt="Menu N°2" title="Menu N°2"/>
            </div>
            <div id="menu3" class="menuP">
                <h2>Original</h2>
                <p>1 burger et 1 boisson</p><br/>
                <p>Prix = 7€50</p>
                <img src="../img/menus/petitB.png" alt="Menu N°3" title="Menu N°3"/>
            </div>
            <div id="menu4" class="menuP">
                <h2>Mini</h2>
                <p>1 burger et 1 accompagnement (fites ou potatoes ou salade)</p>
                <p>Prix = 7€</p>
                 <img src="../img/menus/petitF.png" alt="Menu N°4" title="Menu N°4"/>
            </div>
        </div>
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>