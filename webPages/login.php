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
		<h1>Me connecter</h1>
		<fieldset>
			<legend>Connexion</legend>
			<div id="errorBlock">
			<?php
				if (isset($_GET["uEMsg"]))
				{
					$adminView->showErrorMessage($_GET, true);
				}
			?>
			</div>
			<form method="POST" action="traitement.php">
				<input type="hidden" name="form" value="login"/>
				<label for="email">E-mail : </label><input type="email" name="email" id="email" required/>
				<label for"mdp">Mot de passe : </label><input type="password" name="mdp" id="mdp" required/>
				<input type="submit" value="Connexion"/>
			</form>
		</fieldset>
		
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>