<?php
$page_selected = 'connexion';
?>
<!DOCTYPE html>
<html>
<head>
    <title>camping - connexion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
    <?php
    include("includes/header.php"); ?>
</header>
<main>
    <?php
    if (isset($_POST['submit'])) {
        $user->connect(
            $_POST['email'],
            $_POST['password']
        );
    }
    ?>
    <form action="connexion.php" method="post">
        <label for="email">Email</label>
        <input name="email" type="text" placeholder="email@email.com">
        <label for="password">Mot de passe</label>
        <input name="password" type="password" placeholder="Mot de passe">
        <button type="submit" name="submit">Connexion</button>
    </form>
</main>
<footer>
    <?php
    include("includes/footer.php") ?>
</footer>
</body>
</html>