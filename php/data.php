<?php
try
{
	$db = new PDO("mysql:host=localhost;db-name=Astruck;charset=utf8", "ahsyaj", "ttittaten7tretypolog");
}
catch (Exception $e)
{
	die("Erreur PDO : " . $e->getMessage());
}

$db->query("SELECT * FROM commande");
$data = $req->fetch();
echo $data["id_commande"];
//$um = new UserManager($db);
//$orderManager = new OrderManager($db);
//$planningManager = new PlanningManager($db);
//$typeManager = new TypeManager($db);
//$productManager = new ProductManager($db);
//$purchaseManager = new PurchaseManager($db);
//$adminView = new AdminViewManager();
