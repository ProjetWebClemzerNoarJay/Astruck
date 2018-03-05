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
	<title>Produits - Astruck</title>
</head>
<body>
	<?php 
		include 'header.php';
	?>
	<div id="basketArea">
	</div>
	<section>
		<?php
			echo '<h1 id="titre' . $_GET["cat"] . '">' . ucfirst($_GET["cat"]) . 's</h1>';
			$prdsLst = $productManager->listProductsCat($_GET["cat"]);
			$adminView->showProducts($prdsLst, $_GET['cat']);
			include 'bandeau.php';
		?>
	<script type="text/javascript">
		//Definition d'evenement d'ajout de produit au panier (une requete AJAX est executée à chaque modification de produits pour la mise a jour en variable de session)
		var basket = $('input[type=number]');
		var zone = $('#basketArea');
		//Fonction permettant de mettre a jour le pannier via requete AJAX (redirection vers un script php qui effectuera la modification)
		function updatePurchaseProduct(e){
			var id = e.target.id.replace('Q', 'H');
			var item = $('#'+id);
			//si l'item existe, on le met à jout
			if (item.length != 0)
			{
				item.val(e.target.value);
				$.ajax({
		            type: "POST",
		            url: "../php/ajoutPanier.php",
		            data: "prdName=" + item.attr('id') + "&qtt=" + item.val()
		          	});
			}
			//sinon on crée
			else
			{
				var input = document.createElement('input');
				input.type = 'hidden';
				input.id = id;
				input.value = e.target.value;
				zone.append(input);
				$.ajax({
		            type: "POST",
		            url: "../php/ajoutPanier.php",
		            data: "prdName=" + input.id + "&qtt=" + input.value
		        });
			}
		}
		basket.change(updatePurchaseProduct);
	</script>
	</section>
	<?php
		include 'footer.php';
	?>
</body>

</html>