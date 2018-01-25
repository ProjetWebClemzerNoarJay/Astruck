<?php
//Fonction d'autoload de toutes nos classes
spl_autoload_register(function($class){
	require_once('php/'. $class. '.class.php');
});

try
{
	$db = new PDO("mysql:host=localhost;dbname=Astruck;charset=utf8", "ahsyaj", "ttittaten7tretypolog");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die("Erreur PDO : " . $e->getMessage());
}

$userManager = new UserManager($db);
$orderManager = new OrderManager($db);
$planningManager = new PlanningManager($db);
$typeManager = new TypeManager($db);
$productManager = new ProductManager($db);
$purchaseManager = new PurchaseManager($db);
$adminView = new AdminViewManager();
$admMgr = new AdminManager($db);
$arch = new Archiver($db);

$idAdm = 10;