<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Nous Trouver - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<section>
		<?php
			include 'bandeau.php';
			echo '<script>var week = ' . json_encode($planningManager->returnWeekLatLon()) .  '</script>';
		?>
		<h1>Où nous trouver ?</h1>
		<div id="ou">
			<div id="infoMap">
				<noscript>Merci d'activer javascript pour bénéficier de la minicarte de position de notre food-truck.</noscript>
				<div id="map2"></div>
			</div>
			<hr/>
        	<div id="semaine">
    	        <h2>La semaine</h2>
        	    <ul id="endroit">
            	    <li><a href="#" id="1">Lundi</a></li>
        	        <li><a href="#" id="2">Mardi</a></li>
            	    <li><a href="#" id="3">Mercredi</a></li>
            	    <li><a href="#" id="4">Jeudi</a></li>
            	    <li><a href="#" id="5">Vendredi</a></li>
            	</ul>
        	</div>
        	<hr/>
        	<div id="horaire">
            	<h2>Les horaires</h2>
            	<p>11h30 à 14h00 et 19h00 à 22h30 !</p>
        	</div>
        </div>
        <script type="text/javascript" src="../js/script.js"></script>
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>