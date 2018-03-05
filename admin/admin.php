<?php
	session_start();
	//Vérification si la variable de session est bien définie et valide, si elle ne l'est pas, redirection immédiate vers la page index
	include "../php/init.php";
	define('include', NULL);
	//Définition d'un mot de passe superAdmin permettant d'acceder à la seconde partie de l'interface d'administration affiché crypté pour plus de sécurité (mdp : root)
	$passwd = "395e2b3e7156653f56364e58629fc9e745291c1e7e6a478540996ddfedabfe52";

	//Gestion des evenements supression sur la page d'index
	if (isset($_GET["del"]) && isset($_GET["cat"]))
	{
		$id = (int)$_GET["del"];
		$success = false;
		switch ($_GET["cat"])
		{
			case "commande":
				if ($purchaseManager->delPurchase($id))
				{
					$orderManager->delOrder($id);
					$success = true;
				}
				break;
			case "planning":
				if ($arch->delLog($_GET["cat"], $_SESSION["idA"]))
				{
					$planningManager->delPlanning($id);
					$success = true;
				}
				break;
			case "type":
				if ($arch->delLog($_GET["cat"], $_SESSION["idA"]))
				{
					$typeManager->delType($id);
					$success = true;
				}
				break;
			case "produit":
				if ($arch->delLog($_GET["cat"], $_SESSION["idA"]))
				{
					$productManager->delProduct($id);
					$success = true;
				}
				break;
			case "user":
				$arch->delUserLogs($id);
				if ($userManager->isAdmin($id))
				{
					//Afin de ne pas avoir de soucis de contraites de clefs étrangères à la suppression, si l'user est admin, on supprime ses logs associés et son id dans la table admin
					$arch->delLogs($admMgr->idUsrToIdAdm($id));
					$admMgr->delAdmin($admMgr->idUsrToIdAdm($id));
				}
				if ($userManager->delUser($id))
				{
					$success = true;
				}
				break;
		}
		//Redirection en cas d'erreur/success
		if (!$success)
		{
			header("Location: admin.php?errorDel=1");
		}
		else
		{
			header("Location: admin.php?deleted=1");
		}
	}
	//Sécurisation de la page en cas d'utilisateur non authentifié en tant qu'admin => redirection sur la page index
	if (!isset($_SESSION["auth"]) || $_SESSION["auth"] != $userManager->getUserField($_SESSION["id"], "mdp"))
	{
		header("Location: ../webPages/index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/admin.css"/>
	<title>Admin Astruck.miam</title>
</head>
<body>
	<header>
		<h1>Page d'administration Astruck.miam</h1>
		<a href="../webPages/index.php" title="Aller sur Astruck.miam" id="astruck"><img src="../img/icones/arrow.png" alt="image de flèche vers la gauche" width="70" height="60"></a>
		<div id="errorBlock">
		<?php
			//Zone d'affichage des messages d'information (validation ou erreurs)
			$adminView->showValidateMessage($_GET);
			$adminView->showErrorMessage($_GET);
		?>
		</div>
	</header>
	<!--Chaque section contient les listing des données en bdd de leur id associé, apellant les methodes d'affichage de la classe AdminViewManager pour le formatage/intéractions de modification/supression/ajout, la supression, l'affichage des formulaires d'ajout ou de modification passe via des données get transitant via l'url. Seul la section #commandes diffère pour sa methode d'affichage car elle travaille avec une classe FullOrder, extension de deux classes distinctes (Order/Purchase) en bdd pour un affichage plus complet et pratique-->
	<section id="commandes">
		<h2>Commandes</h2>
		<div id="commandesListe">
		<?php
		$cat = "commande";
			if ($orderList = $orderManager->listCurrOrders())
			{
				foreach ($orderList as $value) 
				{
					$curr = new FullOrder($value["id_commande"], $db);
					$fullOrderList[] = $curr->toArray(1);
				}
				$adminView->showAdminFullOrderPannel($fullOrderList);
			}
			else
			{
				echo "<p>Aucune commande à afficher.</p>";
			}
			if (isset($_GET["validate"]))
			{
				if ($arch->archiveOrder(new FullOrder($_GET["validate"], $db), $_SESSION["idA"]))
				{
					header("Location: admin.php?validated=1");
				}
				else
				{
					echo '<META HTTP-EQUIV="refresh" CONTENT="0; URL=admin.php?errorValidate=1"/>';
				}
			}
			if (isset($_GET["setup"]) && $_GET["cat"] == $cat)
			{
				$adminView->showModifyFullOrderPannel($orderManager, $purchaseManager, $_GET["setup"]);
			}
			if (isset($_GET["add"]) && $_GET["cat"] == $cat)
			{
				$adminView->showAddItemPannel($purchaseManager, $_GET["add"]);
			}
		?>
		</div>
	</section>
	<?php
		//Vérification du mot de passe => super admin => affichage du super admin pannel
		if (isset($_SESSION["s"]))
		{
			if ($userManager->saltAndCrypt($_SESSION["s"]) == $passwd) 
			{
				include "superAdminPannels.php";
			}
			else
			{
				include "adminForm.php";
			}
		}
		else
		{
			include "adminForm.php";
		}
	?>
</body>
</html>