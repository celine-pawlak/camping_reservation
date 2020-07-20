<?php
$page_selected = 'compte_utilisateur';//dire a celine d'ajouter cette page
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <title>camping - compte utilisateur</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <header>
        <?php include("includes/header.php")?>
    </header>
    <main>
        <?php
               
                //TENTATIVE CONNEXION BDD
                try
                {
                    //CONNEXION BDD 
                    $connexion = new PDO("mysql:host=localhost;dbname=camping",'root','');
                    //DEFINITION MODE ERREUR PDO SUR EXCEPTION
                    $connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    
                        //STOCKAGE ID UTILISATEUR ENVOYE DEPUIS LA PAGE ADMIN 
                        $id_user=$_GET['id'];
                        //SELECTION DES DONNEES DE L'UTILISATEUR
                        $user_profil = $connexion->prepare("SELECT * FROM utilisateurs WHERE id = '$id_user' ");
                        //EXECUTION REQUETE
                        $user_profil->execute();
                        //RECUPERATION RESULTAT
                        $user_profil_result = $user_profil->fetchAll(PDO::FETCH_ASSOC);

                        
                        if(isset($_POST['delete']))
                        {
                            if($user_profil_result[0]['avatar'] != NULL)
                            {
                                $avatar_delete = NULL ;
                                //SUPPRESSION AVATAR EN BDD
                                $delete_avatar ="UPDATE utilisateurs SET avatar=:avatar WHERE id = '$id_user' ";
                                //PREPARATION REQUETE
                                $delete1 = $connexion->prepare($delete_avatar);
                                $delete1->bindParam(':avatar',$avatar_delete, PDO::PARAM_NULL);
                                //EXECUTION REQUETE 
                                $delete1->execute();
                            }
                        }


                        
                        //MODIFICATION DES DONNEES DE L'UTILISATEUR SI ON APPUIS SUR VALIDER
                        if(isset($_POST['submit']))
                        {
                            //DEFINITION DES VARIABLES STOCKANT LES DONNEES UTILISATEURS
                            $gender=htmlentities(trim($_POST['gender']));
                            $lastname=htmlentities(trim($_POST['lastname']));
                            $firstname=htmlentities(trim($_POST['firstname']));
                            $birth=htmlentities(trim($_POST['birthday_day']));
                            $mail=htmlentities(trim($_POST['mail']));
                            $phone=htmlentities(trim($_POST['phone_number']));
                            $login=htmlentities(trim($_POST['login']));
                            $password=htmlentities(trim($_POST['password']));
                            $check_password=htmlentities(trim($_POST['check_password']));
                            $hash=password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));
                            
                            //SI LE CHAMPS GENRE EST REMPLI
                            if($gender)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_gender = "UPDATE utilisateurs SET gender=:gender WHERE id = '$id_user' ";
                                //PREPARATION REQUETE
                                $update_niv1 = $connexion -> prepare($update_gender);
                                $update_niv1->bindParam(':gender',$gender, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv1->execute();
                            }
                            else
                            {
                                echo "Veuillez remplir le champs genre <br/>";
                            }
                            
                            //SI LE CHAMPS NOM EST REMPLI
                            if($lastname)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_lastname = "UPDATE utilisateurs SET lastname=:lastname WHERE id = '$id_user' ";
                                //PREPARATION REQUETE
                                $update_niv2 = $connexion -> prepare($update_lastname);
                                $update_niv2->bindParam(':lastname',$lastname, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv2->execute();
                            }
                            else
                            {
                                echo "Veuillez remplir le champs nom de famille<br/>";
                            }
                            
                            //SI LE CHAMPS PRENOM EST REMPLI
                            if($firstname)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_firstname = "UPDATE utilisateurs SET firstname=:firstname WHERE id = '$id_user' ";
                                //PREPARATION REQUETE
                                $update_niv3 = $connexion -> prepare($update_firstname);
                                $update_niv3->bindParam(':firstname',$firstname, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv3->execute();
                            }
                            else
                            {
                                echo "Veuillez remplir le champs prénom<br/>";
                            }
                            
                             //SI LE CHAMPS DATE DE NAISSANCE EST REMPLI
                            if($birth)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_birth = "UPDATE utilisateurs SET birthday_day=:birth WHERE id = '$id_user' ";
                                //PREPARATION REQUETE
                                $update_niv4 = $connexion -> prepare($update_birth);
                                $update_niv4->bindParam(':birth',$birth, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv4->execute();
                            }
                            else
                            {
                                echo "Veuillez remplir le champs date de naissance<br/>";
                            }
                            
                             //SI LE CHAMPS DATE DE NAISSANCE EST REMPLI
                            if($password AND $check_password)
                            {
                                if($password == $check_password)
                                {
                                    //MISE A JOUR DES DONNEES
                                    $update_password = "UPDATE utilisateurs SET password=:hash WHERE id = '$id_user' ";
                                    //PREPARATION REQUETE
                                    $update_niv5 = $connexion -> prepare($update_data_user);
                                    $update_niv5->bindParam(':hash',$hash, PDO::PARAM_STR);
                                    //EXECUTION REQUETE
                                    $update_niv5->execute();
                                }
                                else
                                {
                                    echo "Vos mots de passe doivent être identiques<br/>";
                                }
                            }
                            else
                            {
                                echo "Veuillez remplir les champs mot de passe et confirmation <br/>";
                            }
                            
                            //SI LE CHAMPS LOGIN EST REMPLI
                            if($login)
                            {
                                //VERIFICATION CORRESPONDANCE LOGIN EN BDD ET NOUVEAU LOGIN
                                $login_users = $connexion->prepare("SELECT * FROM utilisateurs WHERE login = '$login'");
                                //EXECUTION REQUETE
                                $login_users->execute();
                                //RECUPERATION RESULTAT
                                $login_users_result =  $login_users->rowCount();
                                
                                if($login_users_result >= 1)
                                {
                                    echo " Ce login existe déjà ! ";
                                }
                                else
                                {
                                    //MISE A JOUR DES DONNEES
                                    $update_login_user = "UPDATE utilisateurs SET login=:login WHERE id = '$id_user' ";
                                    //PREPARATION REQUETE
                                    $update_niv6 = $connexion -> prepare($update_login_user);
                                    $update_niv6->bindParam(':login',$login, PDO::PARAM_STR);
                                    //EXECUTION REQUETE
                                    $update_niv6->execute();

                                }
                            }
                            else
                            {
                                echo "Veuillez remplir le champs login <br/>";
                            }
                            
                        }
                    
                    
                    
                }
                catch(PDOException $e)
                {
                    echo "Erreur : ". $e->getMessage();
                }
                
            
                
            ?>

        <h1>MODIFICATION DONNEES PERSONNELLES</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <img src="
                     <?php 
                      if($user_profil_result[0]['avatar'] == NULL){
                          echo 'css/images/no-image.png';
                      }else{echo $user_profil_result[0]['avatar'];}
                      ?>" alt="avatar" width="100"><br />
            <input type="submit" name="delete" value="SUPPRIMER"><br />
        </form>
        
        
        
        <form action="" method="post">
            
            <?php 
            $check = ($user_profil_result[0]['gender']=="female")?true:false; 
            $check2 = ($user_profil_result[0]['gender']=="male")?true:false; 
            $check3 = ($user_profil_result[0]['gender']=="no_gender")?true:false; 
        
            ?>
            
            <input type="radio" name="gender" value="female" <?php if($check==true){echo "checked";}else{echo "";}  ?> disabled  />
            <label for="female">Femme</label>
            <input type="radio" name="gender" value="male" <?php if($check2==true){echo "checked";}else{echo "";} ?> disabled />
            <label for="male">Homme</label>
            <input type="radio" name="gender" value="no_gender" <?php if($check3==true){echo "checked";}else{echo "";} ?> disabled />
            <label for="no_gender">Non genré</label><br />

            <label for="name">Nom</label><br />
            <input type="text" name="lastname" value="<?php echo $user_profil_result[0]['lastname'] ?>" disabled><br />
            <label for="firstname">Prénom</label><br />
            <input type="text" name="firstname" value="<?php echo $user_profil_result[0]['firstname'] ?>" disabled><br />
            <label for="birthday_day">Date de naissance</label><br />
            <input type="date" name="birthday_day" value="<?php echo $user_profil_result[0]['birthday_day'] ?>" disabled><br />

            <label for="mail">Email</label><br />
            <input type="mail" name="mail" value="<?php echo $user_profil_result[0]['mail'] ?>"><br />
            <label for="phone_number">Numéro de téléphone</label><br />
            <input type="tel" name="phone_number" value="<?php echo $user_profil_result[0]['phone_number'] ?>"><br />

            <label for="login">Login</label><br />
            <input type="text" name="login" value="<?php echo $user_profil_result[0]['login'] ?>" disabled><br />
            <label for="password">Mot de passe</label><br />
            <input type="password" name="password" placeholder="Entrez votre nouveau mot de passe"><br />
            <label for="password">Confirmation de mot de passe</label><br />
            <input type="password" name="check_password" placeholder="Confirmez votre nouveau mot de passe"><br />

            <input type="submit" name="submit" value="VALIDER">

        </form>
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
</body>

</html>


<!--

 //SELECTION AVATAR DE L'UTILISATEUR
                        $user_avatar = $connexion->prepare("SELECT * FROM avatars WHERE id_utilisateur = '$id_user' ");
                        //EXECUTION REQUETE
                        $user_avatar->execute();
                        //RECUPERATION RESULTAT
                        $user_avatar_result = $user_avatar->rowCount();
                        $user_avatar_pic = $user_avatar->fetchAll(PDO::FETCH_ASSOC);
                        //var_dump($user_avatar_result);
                        //var_dump($user_avatar_pic);


-->
