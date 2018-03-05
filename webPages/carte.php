<!DOCTYPE html>
<?php
	session_start();
	include "../php/init.php";
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
		$catList = $typeManager->listTypes();
		foreach ($catList as $key => $value) {
			# code...
		}
	?>
	<section>
		<?php
			include 'bandeau.php';
		?>
		<h1 id="titrecarte">La Carte</h1>
		<?php
			$typesLst = $typeManager->listTypes();
			$adminView->showTypesBoard($typesLst);
		?>
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>