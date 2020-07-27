<?php

$page_selected = 'reservation';
require 'class/evenements.php';
$events = new Evenements();
/*if(!isset ($_GET['id'])){
  header('location:.php');
}*/
$event = $events->find($_GET['id'] ?? null);
$option = $events->option($_GET['id'] ?? null);
?>

<!DOCTYPE html>
<html>
<head>
    <title>camping - check reservation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
      <?php include("includes/header.php");?>
    </header>
    <main>
      <section id="container-reservations">
        <h1> <img src="src/wave.png" alt="wave-icon-white"> VOS RÉSERVATIONS EN COURS <img src="src/wave.png" alt="wave-icon-white"></h1>
        <ul id="current-reservations">
          <li>Votre séjour aura lieu du <?= (new DateTime($event['date_debut']))->format('d/m/Y')?> jusqu'au <?= (new DateTime($event['date_fin']))->format('d/m/Y')?> inclus</li>
          <li> </li>
          <li>Lieu : <?= ($event['nom_lieu'])?></li>
          <li>vos emplacements : <?=($event['nb_emplacement'])?></li>
          <li>vos options : 
           <?php foreach($option as $opt){
                         $val = $opt['nom_option'];
                         echo $val.' &nbsp;';
                         }
           ?>
        </li>
          <li>prix total de la reservation : <?= ($event['prix_total'])?> Euros</li>
        </ul>
        <p>pour modifier votre réservation, veuillez <a  href="mailto:hello@sardinescamp.com">nous contacter</a>.</p>
      </section>
    </main>
<footer>
    <?php
    include("includes/footer.php"); ?>
</footer>
</body>
</html>
