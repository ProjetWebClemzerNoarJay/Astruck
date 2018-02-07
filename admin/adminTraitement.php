<?php
include "../php/init.php";

$_POST = $adminView->wash($_POST);
if ($_POST["form"] == "add")
{
	$success = false;
	switch ($_POST["obj"])
	{
		case "PurchaseManager":
			$purchase = new Purchase($_POST);
			var_dump($purchase);
			if ($purchaseManager->addPurchase($purchase))
			{
				$success = true;
			}
			break;
		case "PlanningManager":
			$plg = new Planning($_POST);
			if ($planningManager->addPlanning($plg))
			{
				$arch->log($plg, $_SESSION["id"]);
				$success = true;
			}
			break;
		case "TypeManager":
			$type = new Type($_POST);
			if ($typeManager->addType($type))
			{
				$arch->log($type, $_SESSION["id"]);
				$success = true;
			}
			break;
		case "ProductManager":
			$prd = new Product($_POST);
			if ($productManager->addProduct($prd))
			{
				$arch->log($prd, $_SESSION["id"]);
				$success = true;
			}
			break;
		case "UserManager":
			$usr = new User($_POST);
			//Validation des champs utilisateur, si eMsg est une chaine, les champs ne sont pas corrects et nous sautons à la redirection avec erreur
			$eMsg = $userManager->validateUserFields($usr);
			if (is_int($eMsg))
			{
				if ($userManager->addUser($usr))
				{
					$arch->log($usr, $_SESSION["id"]);
					$success = true;
				}
				if ($_POST["admin"] == "on")
				{
					$adm = new Admin($usr->toArray(1));
					$admMgr->addAdmin($adm);
				}
			}
			break;
	}
	if (isset($eMsg) && is_string($eMsg))
	{
		header("Location: admin.php?errorAdd=1&uEMsg=" . $eMsg);
	}
	else if (!$success)
	{
		header("Location: admin.php?errorAdd=1");
	}
	else
	{
		header("Location: admin.php?added=" . $id);
	}
}
else if ($_POST["form"] == "setup")
{
	$id = (int) $_GET["id"];
	$success = false;
	switch ($_POST["obj"])
	{
		case "FullOrder":
			foreach ($_POST as $key => $value)
			{

				if ($key != "obj" && $key != "form" && !preg_match("#pastId#", $key))
				{
					if (in_array($key, $orderManager::$CHAMPS))
					{
						if ($orderManager->setOrderField($id, $key, $value))
						{
							$success = true;
						}
					}
					else if (preg_match("#quantite_\d#", $key))
					{
						$a = preg_replace("#quantite_(\d)#", "$1", $key);
						$pId = $_POST["pastId_".$a];
						if ($purchaseManager->setPurchaseField($id, $productManager->getProductIdFromName($_POST["produit_".$a]), "quantite", $value))
						{
							$success = true;
						}
					}
					else if (preg_match("#produit_\d#", $key))
					{
						$a = preg_replace("#produit_(\d)#", "$1", $key);
						$pId = $_POST["pastId_".$a];
						if ($purchaseManager->setPurchaseField($id, $pId, "id_produit", $productManager->getProductIdFromName($value)))
						{
							$success = true;
						}
					}
				}
			}
			break;
		case "PlanningManager":
			foreach ($_POST as $key => $value)
			{
				if ($planningManager->setPlanningField($id, $key, $value))
				{
					$success = true;
				}
			}
			$arch->log($planningManager->loadPlanning($id), $_SESSION["id"]);
			break;
		case "TypeManager":
			foreach ($_POST as $key => $value)
			{
				if ($typeManager->setTypeField($id, $key, $value))
				{
					$success = true;
				}
			}
			$arch->log($typeManager->loadType($id), $_SESSION["id"]);
			break;
		case "ProductManager":
			foreach ($_POST as $key => $value)
			{
				if ($productManager->setProductField($id, $key, $value))
				{
					$success = true;
				}

			}
			$arch->log($productManager->loadProduct($id), $_SESSION["id"]);
			break;
		case "UserManager":
		$usr = new User($_POST);
			if (!$_POST["mdp"])
			{
				unset($_POST["mdp"]);
				$eMsg = "";
				foreach ($_POST as $key => $value) 
				{
					$eMsg .= ($userManager->validateUserField($usr, $key) == 0) ? null : $userManager->validateUserField($usr, $key);
				}
			}
			else
			{
				$eMsg = $userManager->validateUserFields($usr);
				$_POST["mdp"] = $userManager->saltAndCrypt($_POST["mdp"]);
			}
			if (!$eMsg)
			{
				foreach ($_POST as $key => $value)
				{
					if ($userManager->setUserField($id, $key, $value))
					{
						$success = true;
					}
				}
				$arch->log($userManager->loadUser($id), $_SESSION["id"]);
				if (isset($_POST["admin"]) && !$userManager->isAdmin($id))
				{
					$a = new Admin($admMgr->getHydrateTabFromArg($id));
					$admMgr->addAdmin($a);
				}
				else if (!isset($_POST["admin"]) && $userManager->isAdmin($id))
				{
					$arch->delLogs($admMgr->idUsrToIdAdm($id));
					$admMgr->delAdmin($admMgr->idUsrToIdAdm($id));
				}
			}
			break;
	}
	if (is_string($eMsg) && strlen($eMsg) != 0)
	{
		header("Location: admin.php?errorSetup=1&uEMsg=" . $eMsg);
	}
	else if (!$success)
	{
		header("Location: admin.php?errorSetup=1");
	}
	else
	{
		header("Location: admin.php?setted=" . $id);
	}
}