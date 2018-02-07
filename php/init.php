<?php
//Fichier d'init, inclu en début de chaque page, contenant nos managers initialisées, le setup erreur php et le chargement de nos classes
//Fonction d'autoload de toutes nos classes
spl_autoload_register(function($class){
	require_once('class/'. $class. '.class.php');
});

error_reporting(E_ALL);
ini_set("display_errors","On");

$db = PDOFactory::getDb();
$userManager = new UserManager($db);
$orderManager = new OrderManager($db);
$planningManager = new PlanningManager($db);
$typeManager = new TypeManager($db);
$productManager = new ProductManager($db);
$purchaseManager = new PurchaseManager($db);
$adminView = new AdminViewManager($db);
$admMgr = new AdminManager($db);
$arch = new Archiver($db);
