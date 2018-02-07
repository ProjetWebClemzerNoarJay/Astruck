<nav id="bandeau">
	<h2 id="titlePos">Position en temps réel</h2>
	<div id="map" width="150" height="150"></div>
	<?php
		//Récupération de la latitude et longitude du jour courrant de notre bdd et transmission à js via element du DOM sous format JSON
		$val = json_encode($planningManager->returnCurrLatLon());
		echo '<script>var pos = ' . $val . '</script>';
	?>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCauZ_bhI-nz6vJdf2fS7skFOMCwGkkw_o&callback=initMap">
	</script>
	<script type="text/javascript" src="../js/script.js"></script>
	<noscript>Merci d'activer javascript pour bénéficier de la minicarte de position de notre food-truck.</noscript>
</nav>
<div id="fleche"></div>