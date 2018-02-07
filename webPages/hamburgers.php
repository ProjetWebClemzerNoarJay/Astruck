<!DOCTYPE html>
<?php
    session_start();
?>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../css/style.css"/>
    <script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
    <title>Hamburger - Astruck</title>
</head>
<body>
    <?php 
        include 'header.php';
    ?>
	<section>
		<?php
            include 'bandeau.php';
        ?>
        <h1 id="titrehamburger">Nos Hamburgers</h1>
        <div id="hamburgersP">
            <div id="accompagnement" class="burger">
                <h2>Accompagnement</h2>
                <p>Frites ou Potatoes ou Salade</p>
                <p>Prix = 2€50</p>
                <img src="../img/hamburgers/salade.png" alt="accompagnement" title="Accompagnement"/>
            </div>
            <div id="vegan" class="burger">
                <h2>Vegan</h2>
                <p>Prix = 6€</p>
                <img src="../img/hamburgers/vegan.png" alt="Vegan" title="Vegan"/>
            </div>
            <div id="cheeseburger" class="burger">
                <h2>Cheeseburger</h2>
                <p>Prix = 6€</p>
                <img src="../img/hamburgers/cheese.png" alt="Cheeseburger" title="Cheeseburger"/>
            </div>
            <div id="chevre" class="burger">
                <h2>Chèvre</h2>
                <p>Prix = 6€</p>
                <img src="../img/hamburgers/chevre.png" alt="Chèvre" title="Chèvre"/>
            </div>
            <div id="poisson" class="burger">
                <h2>Poisson</h2>
                <p>Prix = 6€</p>
                <img src="../img/hamburgers/poisson.png" alt="Poisson" title="Poisson"/>
            </div>
            <div id="bacon" class="burger">
                <h2>Bacon</h2>
                <p>Prix = 6€</p>
                <img src="../img/hamburgers/bacon.png" alt="Bacon" title="Bacon"/>
            </div>
            <div id="poulet" class="burger">
                <h2>Poulet</h2>
                <p>Prix = 6€</p>
                <img src="../img/hamburgers/poulet.png" alt="Poulet" title="Poulet"/>
            </div> 
        </div> 
    </section>
    <?php
        include 'footer.php';
    ?>
</body>
</html>