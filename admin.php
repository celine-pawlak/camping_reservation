<?php
ob_start();
$page_selected = 'admin';
?>

<!DOCTYPE html>
<html>

<head>
    <title>camping - admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <header>
        <?php include("includes/header.php"); ?>
    </header>
    <main>
        


        <section class="admin_tableaux admin_table">
            <h1>GESTION DES UTILISATEURS</h1><br/>
            <?php include("tableau_utilisateur.php"); ?>
        </section>
        
        <section class="admin_general">
            <h1>GESTION ADMINISTRATIVE</h1><br/>
            <div class="gestion_admin">
               <?php 
                include("tableau_gestion_emplacements.php");
                include("tableau_gestion_options.php");
                include("tableau_gestion_sites.php");
                ?> 
            </div>
        </section>
        
        <section class="admin_tableaux admin_table">
            <h1>GESTION DES RESERVATIONS</h1><br/>
            <?php include("tableau_gestion_reservations.php");?>
        </section>
    </main>
    <footer>
        <?php include("includes/footer.php") ?>
    </footer>
</body>

</html>

<?php ob_end_flush();?>
