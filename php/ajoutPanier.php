<?php
session_start();
if (isset($_POST))
	{
		$formatName = preg_replace("#^(menu)(\w*)#", "$1 $2", str_replace("H", "", $_POST['prdName']));
		$formatName = preg_replace("#(pot)(de)(glace)#", "$1 $2 $3", $formatName);
		$_SESSION['panier'][$formatName] = $_POST['qtt'];
	}
?>