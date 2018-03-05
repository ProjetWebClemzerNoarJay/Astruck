<header>
	<?php
		include '../php/init.php';
	?>
	<a href="index.php" id="lienLogo"><img src="../img/logos/logofinal.png" alt="logo de la société Astruck" id="logo"/></a>
	<nav id="menuPrincipal">
		<div class="menu" id="accueil"><a href="index.php">Accueil</a></div>
		<div class="menu" id="carte">
			<a href="carte.php" id="crte">Carte</a>
			<a href="produits.php?cat=menu" id="menus">Menus</a>
			<a href="produits.php?cat=hamburger" id="hamburgers">Hamburgers</a>
			<a href="produits.php?cat=dessert" id="desserts">Desserts</a>
			<a href="produits.php?cat=boisson" id="boissons">Boissons</a>
		</div>
		<div class="menu" id="nousTrouver"><a href="nousTrouver.php">Nous Trouver</a></div>
		<div class="menu" id="evenements"><a href="evenements.php">Evenements</a></div>
		<div id="pannel">
			<?php
				if (isset($_SESSION['id']))
				{
					echo '<a href="?logout=1"><img src="../img/icones/logout2.png" id="logout" title="Se deconnecter" alt="logo de flèche arriere"/></a>';
				}
				else
				{
					echo '<a href="login.php"><img src="../img/icones/login2.png" id="login" title="Me connecter" alt="logo de connexion"/></a>';
					echo '<a href="signin.php"><img src="../img/icones/signin2.png" id="signin" title="M\'inscrire" alt="logo d\'inscription"/></a>';
				}
				if (isset($_GET["logout"]) && $_GET["logout"] == 1)
				{
					session_destroy();
					header("Location: login.php");
				}
			?>
			
			<a href="panier.php"><img src="../img/icones/cart2.png" id="cart" title="Ma commande" alt="logo de pannier d'achats"/></a>
		</div>
	</nav>
	<div id="social">
		<a href="#"><img src="../img/logos/twitter.png" alt="logo Twitter" width="40" height="40" title="Notre Twitter" id="twitter"\></a>
		<a href="#"><img src="../img/logos/li.png" alt="logo LinkedIn" width="40" height="40" title="Notre LinkedIn" id="li"\></a>
		<a href="#"><img src="../img/logos/fb.png" alt="logo Facebook" width="40" height="40" title="Notre Facebook" id="fb"\></a>
		<a href="#"><img src="../img/logos/insta.png" alt="logo Instagram" width="40" height="40" title="Notre Instagram" id="insta"\></a>
	</div>
</header>
