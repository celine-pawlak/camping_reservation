
<!DOCTYPE html>
<html>
<head>
    <title>camping - reservationform</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
      <?php include("includes/header-v1.php");?>
    </header>
    <main>
      <section id="resa-form">

        <?php 

        try
        {
        $db = new PDO('mysql:host=localhost;dbname=camping;charset=utf8', 'root', '');
        }
        catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
        }

        if(isset($_SESSION['user'])): ?>
     
        <h2 id="hello">Bienvenue @ <?php echo $_SESSION['user']['firstname']?> réserver votre séjour maintenant</h2>
 
        <form id="form-resa" method="post" action="reservation-form.php">

          <section id="date-section">
            <label>date arrivée</label>
            <input type="date" name="arrival">

            <label>date départ</label>
            <input type="date" name="departure">             
          </section>
          
          <section id="site-section">
            <section>
              <select name="lieu">
                <option value="">--lieu--</option>
                <?php $datas_lieux = $db->prepare("SELECT * FROM lieux");
                      $datas_lieux->execute();
                      $datas_lieux = ($datas_lieux->fetchAll());
 
                  foreach($datas_lieux as $key1 => $value){
                  $id_lieu = $value['id_lieu'];
                  $nom_lieu = $value['nom_lieu'];
                  $prix_jr = $value['prix_journalier'];
                  echo '<option value="'.$nom_lieu.'"> '.$nom_lieu.'</option>';
                  }
                ?>
              </select>
            </section>

            <section>
              <select name="camping">
                <option value="">--camping-car--</option>
                <option value="0">0 camping-car</option>
                <option value="2">1 camping-car</option>
                <option value="4">2 camping-car</option>
              </select>
            </section>

            <section>
              <select name="tente" >
                <option value="">--tente--</option>
                <option value="0">0 tente</option>
                <option value="1">1 tente</option>
                <option value="2">2 tentes</option>
                <option value="3">3 tentes</option>
                <option value="4">4 tentes</option>
              </select>
            </section>
          </section>
          
            <h2>vos options pendant votre séjour</h2>


            <section>
              <?php
              $datas_options = $db->prepare("SELECT * FROM options");
              $datas_options->execute();
              $datas_options = ($datas_options->fetchAll());

              foreach($datas_options as $key1 => $value1){
              $id_option = $value1['id_option'];
              $nom_option = $value1['nom_option'];
              $prix_option = $value1['prix_option'];
              //$tab = array();
              //array_push($tab,$id_option, $nom_option, $prix_option );
              echo '<input type="checkbox" name="option[]" value="'.$nom_option.'">'.$nom_option.' à '.$prix_option. ' euros/jr </br>';
              }

              ?>
            </section>
         
           <input class="btn-txt" type="submit" value="RÉSERVER" name="submit">
  
          </form>
       <?php include("traitement-form.php");?>
       
     </section>
     <?php else: ?> 
       <section id="presentation-resa">
         <p>Pour accèder à notre formulaire de réservation, veuillez &nbsp;
           <a href="connexion.php"> vous connectez&nbsp;</a>
           ou rejoignez notre communauté de campeurs bohêmes en créant &nbsp;
           <a href="inscription.php"> un nouveau compte en quelques clics</a>.
         </p>
       </section>
     <?php endif; ?>  
      </section>
    </main>
    <footer>
      <?php include("includes/footer.php");?>
    </footer>
</body>
</html>
