<?php
$page_selected = 'inscription';

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
    <?php
    if (isset($_POST['submit'])) {
        $user->register(
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['email'],
            $_POST['password'],
            $_POST['conf_password'],
            $_POST['num_tel'],
            $_POST['gender']
        );
    }
    ?>
    <form action="inscription.php" method="post">
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" placeholder="Prénom">
        <label for="lastname">Nom</label>
        <input type="text" name="lastname" placeholder="Nom">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="email@email.com">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe">
        <label for="conf_password">Confirmation mot de passe</label>
        <input type="password" name="conf_password" placeholder="Confirmer mot de passe">
        <label for="num_tel">Numéro de téléphone</label>
        <input type="text" name="num_tel" placeholder="0123456789">
        <input type="radio" name="gender" id="male" value="Homme">
        <label for="male">Homme</label>
        <input type="radio" name="gender" id="female" value="Femme">
        <label for="female">Femme</label>
        <input type="radio" name="gender" id="no_gender" value="Non genré">
        <label for="no_gender">Non genré</label>
        <button type="submit" name="submit">Enregistrer</button>
    </form>
</main>
<footer>
    <?php
    include("includes/footer.php") ?>
</footer>
</body>
</html>
