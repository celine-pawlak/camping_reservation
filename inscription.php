<?php
session_start();
require 'class/users.php';

if (isset($_POST['submit'])) {
    $user = new Users;
    var_dump($user->register(
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['email'],
        $_POST['password'],
        $_POST['conf_password'],
        $_POST['num_tel']
    ));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>camping - inscription</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<header>
    <?php
    include("includes/header.php") ?>
</header>
<main>
    <form action="inscription.php" method="post">
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" placeholder="Prénom">
        <label for="lastname">Nom</label>
        <input type="text" name="lastname" placeholder="Nom">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe">
        <label for="conf_password">Confirmation mot de passe</label>
        <input type="password" name="conf_password" placeholder="Confirmer mot de passe">
        <label for="num_tel">Numéro de téléphone</label>
        <input type="text" name="num_tel" placeholder="Numéro de téléphone">
        <button type="submit" name="submit">Enregistrer</button>
    </form>
</main>
<footer>
    <?php
    include("includes/footer.php") ?>
</footer>
</body>
</html>
