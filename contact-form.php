<?php
$connexion = $db->connectDb();
if (!empty($_POST['emailnews'])){
    $email_news = $_POST['emailnews'];
    $email_required = preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/", $email_news);
    if (!$email_required){
        $errors[] = "L'email n'est pas conforme.";
    }
    $q2 = $connexion->prepare("SELECT email FROM newsletter WHERE email = :email");
    $q2->bindParam('email', $email_news, PDO::PARAM_STR);
    $q2->execute();
    $email_check = $q2->fetch();
    if (!empty($email_check)){
        $errors[] = "Vous êtes déjà abonné(e) à notre newsletter.";
    }
    if(empty($errors)){
        $q = $connexion->prepare("INSERT INTO newsletter (email) VALUES (:email)");
        $q->bindParam(':email',$_POST['emailnews'],PDO::PARAM_STR);
        $q->execute();
    }
    else{
        $message = new messages($errors);
        echo $message->renderMessage();
    }
}

