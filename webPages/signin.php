<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Login - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<section id="logForm">
		<?php
			include 'bandeau.php';
		?>
		<h1>M'inscrire</h1>
		<fieldset>
			<legend>Inscription</legend>
			<div id="errorBlock">
			<?php
				if (isset($_GET["uEMsg"]))
				{
					$adminView->showErrorMessage($_GET, true);
				}
			?>
			</div>
			<form method="POST" action="traitement.php">
				<input type="hidden" name="form" value="signin"/>
				<label for="nom">Nom : </label><input type="text" name="nom" id="nom" maxlength="15" required/>
				<label for="prenom">Prenom : </label><input type="text" name="prenom" id="prenom" maxlength="15" required/>
				<label for="email">E-mail : </label><input type="email" name="email" id="email" required/>
				<label for"mdp">Mot de passe : </label><input type="password" name="mdp" id="mdp" required/>
				<label for"mdp2">Retapez : </label><input type="password" name="mdp2" id="mdp2" required/>
				<label for"tel">Numéro de téléphone : </label><input type="tel" name="tel" id="tel" required/>
				<input type="submit" value="Connexion"/>
			</form>
		</fieldset>
		
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>