<?php 

require 'class/evenements.php';

$events = new Evenements();
/*if(!isset ($_GET['id'])){
  header('location:.php');
}*/
$event = $events->find($_GET['id'] ?? null);

?>
<!DOCTYPE html>
<html>
<head>
    <title>camping - check reservation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
      <?php include("includes/header.php");?>
    </header>
    <main>
      <h1> VOS RÉSERVATIONS </h1>
        <ul>
          <li>Date d'arrivée : <?= (new DateTime($event['date_debut']))->format('d/m/Y')?></li>
          <li>Date de départ : <?= (new DateTime($event['date_fin']))->format('d/m/Y')?></li>
          <li>lieu: <?= ($event['nom_lieu'])?></li>
          <li>vos emplacements : <?= ($event['nb_emplacement'])?></li>
          <li>vos options : <?= ($event['nom_option'])?></li>
          <li>prix total de la reservation : <?= ($event['prix_total'])?> Euros</li>
        </ul>
    </main>
    <footer>
      <?php include("includes/footer.php");?>
    </footer>
</body>
</html>
