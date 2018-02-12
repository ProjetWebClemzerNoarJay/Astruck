<fieldset>
	<legend>Accès Super Admin</legend>
	<form method="POST" action="adminTraitement.php">
		<input type="hidden" name="form" value="superAdmin"/>
		<label for="psswd">Mot de passe Super Admin: </label><input type="password" name="psswd" id="psswd" required/>
		<input type="submit" value="Connexion"/>
	</form>
</fieldset>