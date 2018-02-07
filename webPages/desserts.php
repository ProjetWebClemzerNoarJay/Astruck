<!DOCTYPE html>
<?php
    session_start();
?>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../css/style.css"/>
    <script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
    <title>Desserts - Astruck</title>
</head>
<body>
    <?php 
        include 'header.php';
    ?>
	<section>
        <?php
            include 'bandeau.php';
        ?>
        <h1 id="titreboisson">Nos Desserts</h1>
        <div id="dessertsP">
            <div id="snickers" class="dessert">
                <h2>Snickers</h2>
                <p>Prix = 2€</p>
                <img src="../img/desserts/snickers.png" alt="Snickers" title="Snickers"/>
            </div>
               <div id="muffin" class="dessert">
                <h2>Muffin</h2>
                <p>Prix = 3€</p>
                <img src="../img/desserts/muffins.png" alt="Muffin" title="Muffin"/>
            </div>
            <div id="cookie" class="dessert">
                <h2>Cookie</h2>
                <p>Prix = 3€</p>
                <img src="../img/desserts/cookies.png" alt="Cookie" title="Cookie"/>
            </div>
            <div id="flan" class="dessert">
                <h2>Flan</h2>
                <p>Prix = 3€</p>
                <img src="../img/desserts/flan.png" alt="Flan" title="Flan"/>
            </div>
            <div id="kinder" class="dessert">
                <h2>Kinder</h2>
                <p>Prix = 2€</p>
                <img src="../img/desserts/kinder.png" alt="Kinder" title="Kinder"/>
            </div>
            <div id="potdeglace" class="dessert">
                <h2>Pot de glace</h2>
                <p>Prix = 3€</p>
                <img src="../img/desserts/glaces.png" alt="Pot de glace" title="Pot de glace"/>
            </div>
            <div id="fruits" class="dessert">
                <h2>Fruits</h2>
                <p>Prix = 3€</p>
                <img src="../img/desserts/fruits.png" alt="Fruits" title="Fruits"/>
            </div>
            <div id="brownie" class="dessert">
                <h2>Brownie</h2>
                <p>Prix = 3€</p>
                <img src="../img/desserts/brownies.png" alt="Brownie" title="Brownie"/>
            </div>
            <div id="twix" class="dessert">
                <h2>Twix</h2>
                <p>Prix = 2€</p>
                <img src="../img/desserts/twix.png" alt="Twix" title="Twix"/>
            </div>
        </div>	
	</section>
    <?php
        include 'footer.php';
    ?>
</body>
</html>