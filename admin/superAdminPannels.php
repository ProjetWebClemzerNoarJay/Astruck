<!--Page protégée via formulaire d'identification pour l'administration-->
<?php 
if (defined('include')) 
{
?>
<section id="plannings">
	<h2>Plannings</h2>
	<div id="planningsListe">
		<?php
			$cat1 = "planning";
			if ($plgLst = $planningManager->listPlannings())
			{
				$adminView->showAdminPannel($plgLst, $cat1);
			}
			else
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
			if ($typLst = $typeManager->listTypes())
			{
				$adminView->showAdminPannel($typLst, $cat2);
			}
			else
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
			if ($prdLst = $productManager->listProducts())
			{
				$adminView->showAdminPannel($prdLst, $cat3);				
			}
			else
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
			if ($usrLst = $userManager->listUsers())
			{
				$adminView->showAdminPannel($usrLst, $cat4);
				echo "<p>Aucun utilisateur à afficher.</p>";
			}
			else
			{

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
<?php
}
else
{
	header('Location: admin.php');
}
?>