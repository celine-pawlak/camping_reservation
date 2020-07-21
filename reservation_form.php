<?php

$page_selected = 'reservation_form';

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camping - Formulaire de réservation</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
    <?php
    include("includes/header.php");
    $infos = new camping_properties($db);
    if (isset($_POST['submit'])){
        require 'class/reservation_form.php';
        $reservation = new reservation($db);
        $reservation_possible = $reservation->Check_reservation($_POST['lieu'],$_POST['arrival'],$_POST['departure'],'nb emplacements ici');
        if ($reservation_possible){
            if (isset($_POST['submit'])){
                if (isset($_POST['arrival']) && isset($_POST['departure']) && isset($_POST['lieu']) && isset($_POST['camping']) && isset($_POST['tente'])){

                }
        }
    }
    ?>
</header>
<main>
    <h2 id="hello">Bienvenue @<?php
        echo $_SESSION['user']['firstname'] ?>!<br>Réservez votre séjour maintenant</h2>
    <?php
    if (!isset($_POST['Valider_date_lieu'])) {
        ?>
        <form id="form_date_lieu" method="post" action="reservation_form.php">
            <section id="date-section">
                <i>* Les réservations correspondent aux nuits</i>
                <label for="arrival">Date d'arrivée</label>
                <input type="date" name="arrival">
                <label for="departure">Date de départ</label>
                <input type="date" name="departure">
            </section>
            <select name="lieu" id="" name="">
                <optgroup label="Choix du lieu">
                    <option value="default" selected hidden>--Sélectionnez votre lieu--</option>
                    <?php
                    foreach ($infos->getLieux() as $lieu) { ?>
                        <option value="<?= $lieu['nom_lieu'] ?>"><?= $lieu['nom_lieu'] ?></option>
                        <?php
                    } ?>
                </optgroup>
            </select>
            <button type="submit" name="Valider_date_lieu">Valider</button>
        </form>
        <?php
    } else {
        $_SESSION['arrival'] = $_POST['arrival'];
        $_SESSION['departure'] = $_POST['departure'];
        $_SESSION['nom_lieu'] = $_POST['lieu'];
        ?>
        <form id="form-resa" method="post" action="reservation-form.php">
            <section>
                <label for="arrival">Date d'arrivée</label>
                <input type="date" name="arrival" value="<?= $_SESSION['arrival'] ?>" disabled>
                <label for="departure">Date de départ</label>
                <input type="date" name="departure" value="<?= $_SESSION['departure'] ?>" disabled>
                <label for="lieu">Lieu</label>
                <input type="text" name="lieu" value="<?= $_SESSION['nom_lieu'] ?>" disabled>
            </section>
            <section>
                <h2>Choisissez votre type d'emplacement</h2>
                <?php
                foreach ($infos->getLieux() as $lieu) { ?>
                    <?php
                    if ($lieu['nom_lieu'] == $_SESSION['nom_lieu']) {
                        $test = $lieu['emplacements_disponibles'];
                    }
                } ?>
                <?php
                foreach ($infos->getTypesEmplacement() as $type_emplacement) {
                    $test2 = $type_emplacement['nb_emplacements'];
                    $result = intval($test / $test2);
                    if ($result >= 1) {
                        ?>
                        <select name="<?= $type_emplacement['nom_type_emplacement'] ?>">
                            <?php
                            for ($i = 1; $i <= $result; $i++) {
                                $nom_emplacement = $type_emplacement['nom_type_emplacement'];
                                if (!isset($total_emplacement)){
                                    $total_emplacement = 0;
                                }
                                echo $total_emplacement = $total_emplacement + (int)$type_emplacement['nb_emplacements'];
                                ?>
                                <option value="<?=$total_emplacement?>"><?php
                                    echo "$i $nom_emplacement" ?></option>
                                <?php
                            } ?>
                        </select>
                        <?php
                    }
                } ?>
            </section>
            <section>
                <h2>Choisissez vos options durant votre séjour</h2>
                <?php
                foreach ($infos->getOptions() as $option) { ?>
                    <input type="checkbox" id="<?= $option['id_option'] ?>" name="option[]" value="<?= $option['nom_option'] ?>">
                    <label for="<?= $option['id_option'] ?>"><?= $option['nom_option'] ?> à <?= $option['prix_option'] ?>€/jour</label>
                    <?php
                }  ?>
            </section>
            <button class="btn-txt" type="submit" name="submit">Réserver</button>
        </form>
        <?php
    } ?>
    </form>
</main>
<footer>
    <?php
    include("includes/footer.php");
    ?>
</footer>
</body>
</html>
