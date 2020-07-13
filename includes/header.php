<?php 
if (isset($_POST["deco"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}
?>
<header>
  <section id="top-header">
    <a href="newsletter-form.php">RECEVOIR NOTRE BROCHURE</a>
    <a id="header-title" href="reservation-form.php">RESERVER</a>
  </section>
  <section>
    <nav>
      <ul id="nav_links">
        <li><a href="planning.php">NOS DISPONIBILITÉS</a></li>
        <li><a href="#">NOS SERVICES</a></li>
        <li id="title">
          <a href="index.php">
            <img id="logo1" src="https://i.ibb.co/hMhFxXF/logotype1.png" alt="logotype1">
            <h1>camping chic</h1>
          </a>
        </li>
        <?php 
        if (isset($_SESSION["login"])){
          if($_SESSION["login"] == "admin"){
          ?>
          <li><a href="admin.php">PANEL BOARD</a></li>
          
            <form  action="index.php" method="post">
              <input id="deco" name="deco" value="DECONNEXION" type="submit"/>
            </form>
       
          <?php 
          }
          else{
          ?>

          <li><a href="profil.php">MON COMPTE</a></li>
        
          <form  action="index.php" method="post">
            <input id="deco" name="deco" value="DECONNEXION" type="submit"/>
          </form>
       

      <?php
          }
      ?> 
     
      <?php
        }else{
      ?>
      <li><a href="contact.php">NOUS CONTACTER</a></li>
      <li><a id="deco" href="connexion.php"> SE CONNECTER</a></li>
      </ul>

      <?php }?>

    </nav>
  </section>
</header>