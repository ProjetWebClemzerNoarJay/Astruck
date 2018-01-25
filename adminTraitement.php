<?php
include "init.php";


$id = (int) $_GET["id"];
if ($_POST["form"] == "add")
{
	$success = false;
	switch ($_POST["obj"])
	{
		case "PlanningManager":
			$plg = new Planning($_POST);
			if ($planningManager->addPlanning($plg))
			{
				$arch->log($plg, $idAdm);
				$success = true;
			}
			break;
		case "TypeManager":
			$type = new Type($_POST);
			if ($typeManager->addType($type))
			{
				$arch->log($type, $idAdm);
				$success = true;
			}
			break;
		case "ProductManager":
			$prd = new Product($_POST);
			if ($productManager->addProduct($prd))
			{
				$arch->log($prd, $idAdm);
				$success = true;
			}
			break;
		case "UserManager":
			$usr = new User($_POST);
			if ($userManager->addUser($usr))
			{
				$arch->log($usr, $idAdm);
				$success = true;
			}
			if ($_POST["admin"] == "on")
			{
				$adm = new Admin($usr->toArray(1));
				$admMgr->addAdmin($adm);
			}
			break;
	}
	if (!$success)
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
	$success = false;
	switch ($_POST["obj"])
	{
		case "FullOrder":
		var_dump($_POST);
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
					else if (in_array($key, $purchaseManager::$CHAMPS))
					{
						/*if ($purchaseManager->setPurchaseField($id, $key, $value))
						{
							$success = true;
						}*/
					}
					else if (preg_match("#produit_\d#", $key))
					{
						$a = preg_replace("#produit_(\d)#", "$1", $key);
						$pId = $_POST["pastId_".$a];
						echo $pId;
						$PurchaseManager->setPurchaseField($id, $pId, "id_produit", $productManager->getProductIdFromName($value));
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
			$arch->log($planningManager->loadPlanning($id), $idAdm);
			break;
		case "TypeManager":
			foreach ($_POST as $key => $value)
			{
				if ($typeManager->setTypeField($id, $key, $value))
				{
					$success = true;
				}
			}
			$arch->log($typeManager->loadType($id), $idAdm);
			break;
		case "ProductManager":
			foreach ($_POST as $key => $value)
			{
				if ($productManager->setProductField($id, $key, $value))
				{
					$success = true;
				}

			}
			$arch->log($productManager->loadProduct($id), $idAdm);
			break;
		case "UserManager":
			$_POST["mdp"] = $userManager->saltAndCrypt($_POST["mdp"]);
			foreach ($_POST as $key => $value)
			{
				if ($userManager->setUserField($id, $key, $value))
				{
					$success = true;
				}
			}
			$arch->log($userManager->loadUser($id), $idAdm);
			if (isset($_POST["admin"]) && !$userManager->isAdmin($id))
			{
				$admMgr->addAdmin(new Admin($admMgr->getHydrateTabFromArg($id)));
			}
			else if (!isset($_POST["admin"]) && $userManager->isAdmin($id))
			{
				$admMgr->delAdmin($id);
			}
			break;
	}
	if (!$success)
	{
		//header("Location: admin.php?errorSetup=1");
	}
	else
	{
		//header("Location: admin.php?setted=" . $id);
	}
}