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
  </section>
</header>