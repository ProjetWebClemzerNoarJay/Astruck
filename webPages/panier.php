<!DOCTYPE html>
<?php
	session_start();
	include '../php/init.php';
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/style.css"/>
	<script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
	<title>Panier - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<section id="logForm">
		<?php
			include 'bandeau.php';
		?>
		<h1>Panier</h1>
		<?php
			//Si il y a des produits dans le panier ayant étés validés
			if (!empty($_POST))
			{
				//Si jamais l'user n'est pas connecté on l'invite à se connecter/s'inscrire
				if (!isset($_SESSION["id"]))
				{
					echo '<p class="infoCde">Vous devez vous connecter si vous souhaitez pouvoir commander. Vous pouvez créer un compte sur la page inscription accessible via le 2ème icone après le menu.</p>';
				}
				else
				{
					//Sinon on crée les produits/achats en base de donnée
					$idO = $orderManager->addOrder($_SESSION["id"]);
					if ($idO)
					{
						//$content = '<html><head><title>Commande Astruck</title></head><body><h1>Recapitulatif de commande</h1><div><ul>';
						$tot = 0;
						foreach ($_POST as $key => $value)
						{
							$name = ucfirst($key);
							$name = (preg_match("#_#", $name)) ? preg_replace("#_#", " ", $name) : $name;
							$idP = $productManager->getProductIdFromName($name);
							$itmsPrice = (int) ($productManager->getProductField($idP, 'prix' * $value));
							$tot += $itmsPrice;
							$purchaseManager->addPurchase(new Purchase(array("id_commande" => $idO, "id_produit" => $idP, "quantite" => $value)));
							//$content .= ('<li>' . $value . 'x ' . ucfirst($key) . ' ' . $itmsPrice . ' €</li>');
						}
						foreach ($_SESSION['panier'] as $key => $value)
						{
							unset($_SESSION['panier'][$key]);
						}
						//$content .= '<li>Prix total ' . $tot . ' €</li></ul></div></body></html>';
						echo '<p class="infoCde">Votre commande a été enregistré avec succès, elle sera disponible à notre position dans un delai de 5 à 10 minutes.</p>';
						//$header = 'MIME-Version: 1.0'."\r\n";
						//$header .= 'Content-type: text/html; charset=utf-8'."\r\n";
						//On mail le client en question => manque formatage de mail
						//Laissé en commentaire car service à paramètrer sur le serveur web
						//mail($userManager->getUserField($_SESSION["id"], 'email'), "Votre commande chez Astruck", $content, $header);
						//mail("astruck@miam.fr", "Nouvelle commande Astruck", $content, $header);
					}
					else
					{
						echo '<p class="infoCde">Il y a eu une erreur avec l\'ajout de votre commande, merci de nous contacter (voir infos en pied de page).</p>';
					}
				}
			}

			//Si le panier est vide, on affiche un message invitant à commander
			if (empty($_SESSION['panier']))
			{
				echo '<p class="infoCde">Vous n\'avez pas de produits dans votre commande, vous pouvez commander à partir des pages du menu déroulant derrière l\'onglet "carte"</p>';
			}
			//Sinon on affiche le contenu du panier
			else
			{
				$adminView->showBasket($_SESSION["panier"]);
			}

			//Si l'user supprime un produit, on le retire et recharge la page
			if (isset($_GET["del"]) && array_key_exists($_GET["del"], $_SESSION['panier']))
			{
				unset($_SESSION["panier"][$_GET['del']]);
				header('Location: panier.php');
			}
		?>
	<script type="text/javascript">
		//Script permettant de gérer l'affichage/la maj des prix et des quantités des produits du panier
		var inputs = $('input[type="number"]');
		var totCde = $('#totalCde');
		function setFinalPrice(item)
		{
			var prices = $('.tPrix');
			var totPrice = 0;
			for (var i = 0; i < prices.length; i++)
			{
				totPrice += Number(prices[i].textContent);
			}
			item.text(totPrice);
		}
		setFinalPrice(totCde);
		inputs.change(function(e)
		{
			$.ajax({
            type: "POST",
            url: "../php/ajoutPanier.php",
            data: "prdName=" + e.target.id + "&qtt=" + e.target.value
        	});
        	var priceBloc = $('#' + e.target.id + "S");
        	var qtt = Number($('#' + e.target.id).val());
        	var unitPrice = Number($('#' + e.target.id + "H").val());
        	priceBloc.text(unitPrice*qtt);
        	setFinalPrice(totCde);
		});	
	</script>
	</section>
	<?php
		include 'footer.php';
	?>
</body>
</html>