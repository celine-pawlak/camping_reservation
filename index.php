<?php

$page_selected = 'index';
?>
<!DOCTYPE html>
<html>
<head>
    <title>camping - homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
    <?php
    include("includes/header-v1.php");
    include("class/bdd.php");
    $connexion = $db->connectDb();
    include 'avis.php'; ?>
</header>
<main>
    <section id="banner">
        <h1>WELCOME</h1>
        <img id="logo" src="src/wave-white.png" alt="icon-waves">
        <h2>une ambiance conviviale, des activités variées, et un cadre idyllique... bienvenue au Sardine's Camp</h2>
        <a href="reservation-form.php">Réserver votre séjour</a>
    </section>

    <section id="description">

        <h1>NOS SITES</h1>

        <p>Nous vous accueillons sur notre site dans des lieux idylliques. Rejoignez-nous et choisissez l'ambiance qui
            vous correspond!</p>

        <aside>
            <p>la température actuelle est de ...</p>
        </aside>

        <section id="sites">

            <article>
                <div class="lieu">
                    <h2>la plage</h2>
                    <img src="src/wave.png" alt="wave-icon-white">
                </div>
                <div class="lieu">
                    <h2>les pins</h2>
                    <img src="src/pins.png" alt="pine-icon-white">
                </div>
                <div class="lieu">
                    <h2>le massif</h2>
                    <img id="massif" src="src/massif.png" alt="mountain-icon-white">
                </div>
            </article>

            <section id="diapo">
                <ul class="slideshow1">
                    <li><span><div class="principal1"></div></span></li>
                    <li><span><div class="principal1"></div></span></li>
                    <li><span><div class="principal1"></div></span></li>
                    <li><span><div class="principal1"></div></span></li>
                    <li><span><div class="principal1"></div></span></li>
                </ul>
            </section>

        </section>

    </section>

    <section id="services">
        <h1>NOS SERVICES</h1>

        <section class="cen">
            <section class="service">
                <i class="fas fa-plug"></i>
                <h2>borne électrique</h2>
                <p>des bornes electriques sont installées à travers tout le camping pour recherger et profiter de tous
                    vos appareils électriques</p>
            </section>

            <section class="service">
                <i class="fas fa-wifi"></i>
                <h2>wifi</h2>
                <p>un réseau wifi avec un débit ultra-performant vous permet de profiter d'une super connexion quelque
                    soit votre emplacement</p>
            </section>

            <section class="service">
                <i class="fas fa-shower"></i>
                <h2>sanitaires</h2>
                <p>nos sanitaires haut de gamme sont nettoyés tout au long de la journée et vous offrent un confort
                    quelque soit le moment de la journée</p>
            </section>

            <section class="service">
                <i class="fas fa-swimmer"></i>
                <h2>activités</h2>
                <p>inscrivez-vous à nos activités menées par des coachs expérimentés : yoga, frisbee, ski nautique...
                    amusez-vous et dépensez vous !</p>
            </section>

            <section class="service">
                <i class="fas fa-coffee"></i>
                <h2>coffee shop et snacks bio</h2>
                <p>notre coffee shop vous propose un service de boissons chaudes et de snacks préparés avec des produits
                    locaux bios toute la journée</p>
            </section>
        </section>
    </section>

    <section class="testimonials">
        <h1>LES 3 DERNIERS AVIS</h1>
        <section>
            <?php
            $q = $connexion->prepare("SELECT id_avis FROM avis ORDER BY id_avis DESC LIMIT 3");
            $q->execute();
            $avis = $q->fetchAll();
            foreach ($avis as $value) {
                viewComment($value['id_avis']);
            } ?>
        </section>
        <div>
            <a href="voir_avis.php">En voir plus ...</a>
        </div>
    </section>

</main>
<footer>
    <?php
    include("includes/footer.php") ?>
</footer>
</body>
</html>



