<?php
//Page de traitement des formulaires de connexion et d'enregistrement
session_start();
include '../php/init.php';
if ($_POST["form"] == "login")
{

	$adminView->wash($_POST);
	$id = $userManager->logIn($_POST);
	if ($id)
	{
		$_SESSION["id"] = $id;
		if($userManager->isAdmin($id))
		{
			$_SESSION["auth"] = $userManager->saltAndCrypt($_POST["mdp"]);
			header("Location: ../admin/admin.php");
		}
		else
		{
			header("Location: index.php");
		}
	}
	else
	{
		header("Location: login.php?uEMsg=Mot de passe et/ou adresse email invalide.");
	}
	

}
else if ($_POST["form"] == "signin")
{
	$usr = new User($_POST);
	$msg = $userManager->validateUserFields($usr);
	$msg = ($_POST["mdp"] != $_POST["mdp2"]) ? "Les mots de passe saisis sont différents. " . $msg : $msg;
	if (is_int($msg))
	{
		$userManager->addUser($usr);
		header("Location: carte.php");
	}
	else
	{
		header("Location: signin.php?uEMsg=" . $msg);
	}
}