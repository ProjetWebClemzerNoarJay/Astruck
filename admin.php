<!--
Log:
Voir solution pour stocker l'id de l'admin courrant pour le passer en parametre de a fonction archiveOrder()
($idAdm) = > init.php
Voir solution pour l'enregistrement des modifications (logs ...) / suppression => foreign key
Voir modification type rzenvoie une erreur
-->

<?php
	error_reporting(E_ALL);
	ini_set("display_errors","On");
	include "init.php";

	if (isset($_GET["del"]) && isset($_GET["cat"]))
	{
		$id = (int)$_GET["del"];
		$success = false;
		switch ($_GET["cat"])
		{
			case "commande":
				if ($orderManager->delOrder($id))
				{
					$success = true;
				}
			case "planning":
				if ($planningManager->delPlanning($id))
				{
					$success = true;
				}
				break;
			case "type":
				if ($typeManager->delType($id))
				{
					$success = true;
				}
				break;
			case "produit":
				if ($productManager->delProduct($id))
				{
					$success = true;
				}
				break;
			case "user":
				if ($userManager->delUser($id))
				{
					$success = true;
				}
				break;
		}
		if (!$success)
		{
			header("Location: admin.php?errorDel=1");
		}
		else
		{
			header("Location: admin.php?deleted=1");
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="admin.css"/>
	<title>Admin Astruck.miam</title>
</head>
<body>
	<h1>Page d'administration Astruck.miam</h1>
	<?php
		$adminView->showValidateMessage($_GET);
		$adminView->showErrorMessage($_GET);
	?>
	<section id="commandes">
		<h2>Commandes</h2>
		<div id="commandesListe">
		<?php
		$cat = "commande";
			$orderList = $orderManager->listCurrOrders();
			foreach ($orderList as $value) 
			{
				$curr = new FullOrder($value["id_commande"], $db);
				$fullOrderList[] = $curr->toArray(1);
			}
			if (isset($_GET["validate"]))
			{
				if ($arch->archiveOrder(new FullOrder($_GET["validate"], $db), $idAdm))
				{
					header("Location: admin.php?validated=1");
				}
				else
				{
					header("Location: admin.php?errorValidate=1");
				}
			}
			if (!$adminView->showAdminFullOrderPannel($fullOrderList, "commande"))
			{
				echo "<p>Aucune commande à afficher.</p>";
			}
			if (isset($_GET["setup"]) && $_GET["cat"] == $cat)
			{
				$adminView->showModifyFullOrderPannel($orderManager, $purchaseManager, $_GET["setup"]);
			}
		?>
		</div>
	</section>
	<section id="plannings">
		<h2>Plannings</h2>
		<div id="planningsListe">
			<?php
				$cat1 = "planning";
				if (!$adminView->showAdminPannel($planningManager->listPlannings(), $cat1))
				{
					echo "<p>Aucun planning à afficher.</p>";
				}
				if (isset($_GET["setup"]) && $_GET["cat"] == $cat1)
				{
					$adminView->showModifyItemPannel($planningManager, $_GET["setup"]);
				}
				if (isset($_GET["add"]) && $_GET["cat"] == $cat1)
				{
					$adminView->showAddItemPannel($planningManager);
				}
				else
				{
					$adminView->showAddButton($cat1);
				}
			?>
		</div>
	</section>
	<section id="types">
		<h2>Types</h2>
		<div id="typesListe">
			<?php
				$cat2 = "type";
				if (!$adminView->showAdminPannel($typeManager->listTypes(), $cat2))
				{
					echo "<p>Aucun type de produit à afficher.</p>";
				}
				if (isset($_GET["setup"]) && $_GET["cat"] == $cat2)
				{
					$adminView->showModifyItemPannel($typeManager, $_GET["setup"]);
				}
				if (isset($_GET["add"]) && $_GET["cat"] == $cat2)
				{
					$adminView->showAddItemPannel($typeManager);
				}
				else
				{
					$adminView->showAddButton($cat2);
				}
			?>
		</div>
	</section>
	<section id="produits">
		<h2>Produits</h2>
		<div id="produitsListe">
			<?php
				$cat3 = "produit";
				if (!$adminView->showAdminPannel($productManager->listProducts(), $cat3))
				{
					echo "<p>Aucun produit à afficher.</p>";
				}
				if (isset($_GET["setup"]) && $_GET["cat"] == $cat3)
				{
					$adminView->showModifyItemPannel($productManager, $_GET["setup"]);
				}
				if (isset($_GET["add"]) && $_GET["cat"] == $cat3)
				{
					$adminView->showAddItemPannel($productManager);
				}
				else
				{
					$adminView->showAddButton($cat3);
				}
			?>
		</div>
	</section>
	<section id="users">
		<h2>Utilisateurs</h2>
		<div id="usersListe">
			<?php
				$cat4 = "user";
				if (!$adminView->showAdminPannel($userManager->listUsers(), $cat4))
				{
					echo "<p>Aucun utilisateur à afficher.</p>";
				}
				if (isset($_GET["setup"]) && $_GET["cat"] == $cat4)
				{
					$adminView->showModifyItemPannel($userManager, $_GET["setup"]);
				}
				if (isset($_GET["add"]) && $_GET["cat"] == $cat4)
				{
					$adminView->showAddItemPannel($userManager);
				}
				else
				{
					$adminView->showAddButton($cat4);
				}
			?>
		</div>
	</section>
</body>
</html>