<?php

$page_selected = 'planning';
?>
<!DOCTYPE html>
<html>
<head>
    <title>camping - planning </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/calendar-style.css">
    
</head>
<body>
    <header>
      <?php include("includes/header.php") ?>
    </header>
    <main>
    <nav class="navbar navbar-dark bg-secondary mb-3">
      <a href="planning.php" class="navbar-brand">calendrier des réservations</a>
    </nav>
    <?php 

    require 'class/month.php';
    require 'class/evenements.php';
      
      $events = new Evenements();
      $month = new Month($_GET['month'] ?? null, $GET['year'] ?? null);
      $start  = $month->getStartingDay();
      $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
      $weeks = $month->getWeeks();
      $end = (clone $start)->modify('+'. (6 + 7 * ($weeks -1)) .'days');
      //var_dump($end);
      $events =  $events->getEventsBetweenByDay($start,$end);
      //echo '<pre>';
      //var_dump($events);
      //echo '</pre>';

    ?>
    <div class="d-flex flex-row align-items-center justify-content-between mx-ms-3">

      <section>
      <h1><?= $month->toString();?></h1>
      <div>
        <a href="planning.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-secondary">&lt;</a>
        <a href="planning.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-secondary">&gt;</a>
      </div>
    </div>
    <?php $month->getWeeks();?>
      <table class="calendar_table calendar_table--<?=$weeks;?>weeks">
        <?php for($i = 0; $i < $weeks; $i++): ?>
        <tr>
          <?php foreach($month->days as $key =>$day): 
            
          $date = (clone $start)->modify("+" . ($key + $i * 7) . "days");
          $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
          //var_dump($eventsForDay);
          ?>
          <td class="<?= $month->withinMonth($date)?'':'calendar-other'; ?>">
            <?php if ($i == 0): ?>
              <div class="calendar-weekday"><?= $day ?></div>
            <?php endif; ?>
            <div class="calendar-day"><?= $date->format('d');?></div>
            <?php foreach($eventsForDay as $event): ?>
              <div class="calendar-event">

                <?= (new DateTime($event['date_debut']))->format('d-m'); (new DateTime($event['date_fin']))->format('d-m');?> -vous avez une réservation pour cette periode- <a href="reservation.php?id=<?=$event['id_reservation'];?>"><?= $event['id_reservation']; ?>
           
              </div>
            <?php endforeach; ?>

          </td>
          
          <?php endforeach; ?>
         
        </tr>
        <?php endfor; ?>
      </table>

      <a class="calendar__button" href="reservation-form.php">+</a>

      <div id="box-button">
          <button class="icon-btn add-btn">
          <div class="add-icon"></div>
          <input class="btn-txt" type="submit" value="RÉSERVER" name="submit">
        </div>


   

    </section>
    </main>
    <footer>
      <?php include("includes/footer.php");?>
    </footer>
</body>
</html>