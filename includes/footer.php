<footer>
  <nav>
      <ul>
        <li><a href="index.php">homepage</a></li>

        <?php 
          try
         {
         $bdd = new PDO('mysql:host=localhost;dbname=camping;charset=utf8', 'root', 'root');
         $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
         $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
         }
         catch (Exception $e){
         die('Erreur : ' . $e->getMessage());
         }

        if (isset($_SESSION["login"])){
          if($_SESSION["login"] == "admin"){
        ?>

        <li><a href="admin.php">espace admin</a></li>

        <?php
           }
        ?> 
        <li><a href="planning.php">nos disponibilités</a></li>
        <li><a href="reservation-form.php">réserver</a></li>
        <li>
          <form action="index.php" method="post">
            <input id="deco1" name="deco" value="DECONNEXION" type="submit"/>
          </form>
        </li>

        <?php
          }else{
        ?>
        <li><a href="connexion.php">réserver</a></li>
        <li><a href="connexion.php">espace admin</a></li>
        <li><a href="connexion.php">se connecter</a></li>
        <?php }?>
      </ul>
    </nav>
  <section id=container-bottom>
    <section id="footerleft">
      <section id="newsletter">
        <h3>inscris-toi à notre newsletter</h3>
        <form action="" method="POST">
          <input type="text" id="news" name="emailnews" placeholder="Enter your email"></br>
          <input type="submit" name="submitnews" id="btnnews" value="envoyer">
        </form>
      </section>
    </section> 

    <section id="footercenter">
      <section id="bottom-logo"> 
        <img id="logo" src="https://i.ibb.co/XzyCCqt/LOGO1.png" alt="logo-sardinescamp"></a>
        <h1><a href="index.php">SARDINE'S CAMP</a></h1>
      </section>
    
      <section id="social-media">
        <ul id="social-list">
          <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></i></a></li>
          <li><a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a></li>
          <li><a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a></li>
          <li><a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a></li>
        </ul>
      </section>
   
      <p id="copyright">&copy; 2020 SARDINE'S CAMP</p>
    </section>  

    <section id="footerright">
      <h2>SARDINE'S CAMP</h2>
      <p>"Le Sardine's Camp vous accueille au coeur de la Méditerranée dans un cadre idyllique. Vous serez plongés entre la mer, les calanques, les massifs de pins. 
        Rejoignez-nous et transformez votre séjour en parenthèse enchantée "
      </p>
      <address>
        1 avenue de la Madrague 13008 Marseille
        <a href="tel:+330491919191">"tel:+330491919191"</a>
        <a href="mailto:hello@thewowsclan.com">hello@sardinescamp.com</a>
      </address>
    </section>
  </section>
</footer>