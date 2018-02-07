<!DOCTYPE html>
<?php
    session_start();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Evenements - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<section>
        <?php
            include 'bandeau.php';
        ?>
		<h1>Evenements</h1>
        <div id="fete">
            <div id="nomFete">
            <h2>Venez donc pour les fêtes !</h2>
                <ul>
                    <li><a href="#" id="stVal">La saint Valentin</a></li>
                    <li><a href="#" id="avril">Poisson d'Avril</a></li>
                    <li><a href="#" id="paques">Pâques</a></li>
                    <li><a href="#" id="ftMusique">La fête de la musique</a></li>
                    <li><a href="#" id="halloween">Halloween</a></li>
                    <li><a href="#" id="noel">Noël</a></li>
                </ul>
            </div>
            <hr/>
            <div id="planning">
            <h2>Planning</h2>
            <noscript>Merci d'activer javascript pour profiter de l'affichage de nos burgers spéciaux.</noscript>
            <div id="infoFete"></div>
        	<!--description en Javascript? pour le burger -->
        	</div>
        </div>
        <script type="text/javascript" src="../js/script.js"></script>
	</section>
    <?php
        include 'footer.php';
    ?>
</body>
</html>