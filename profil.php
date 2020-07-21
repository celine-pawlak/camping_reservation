<?php
$page_selected = 'profil';
?>

<!DOCTYPE html>
<html>

<head>
    <title>camping - profil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes" />
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <header>
        <?php include("includes/header.php"); ?>
    </header>
    <main>
        <?php
            //TENTATIVE CONNEXION BDD
            try
                {
                    //CONNEXION BDD 
                    $connexion = new PDO("mysql:host=localhost;dbname=camping", 'root', '');
                    //DEFINITION MODE ERREUR PDO SUR EXCEPTION
                    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
                        //DEFINITION DE VARIABLE STOCKANT LA SESSION EN COURS
                        $session=htmlentities(trim($_SESSION['user']['id_user']));
                        
                        //RECUPERATION DES DONNEES UTILISATEURS 
                        $user_session_data = $connexion->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = $session ");
                        //EXECUTION DE LA REQUETE
                        $user_session_data->execute();
                        //RECUPERATION RESULTAT
                        $user_session_data_result = $user_session_data->fetchAll(PDO::FETCH_ASSOC);
                        
                         //var_dump($user_session_data_result);
                        
                        //SI ON APPUIS SUR L'ENVOI DE FICHIER
                        if(isset($_POST['send']))
                        {
                                //DEFINITION DES VARIABLES STOCKANT LA PHOTO ET LE CHEMIN VERS LA PHOTO
                               $file_name=$_FILES["photo"]["name"];
                                $avatar="uploads/$file_name";
                                
                                //SI AUCUN AVATAR EXISTE POUR MA SESSION EN COURS
                                if( $user_session_data_result[0]['avatar'] == "NULL")
                                {
                                    //INSERTION AVATAR
                                    $insert_avatar="INSERT INTO utilisateurs (avatar) VALUES (:avatar) WHERE id_utilisateur = '$session'";
                                    //PREPARATION REQUETE
                                   $insert1= $connexion->prepare($insert_avatar);
                                   $insert1->bindParam(':avatar',$avatar, PDO::PARAM_STR);
                                    //EXECUTION REQUETE
                                   $insert1->execute();
           
                                }
                            else
                                {
                                    //MISE A JOUR AVATAR
                                    $update_avatar="UPDATE utilisateurs SET avatar = :avatar WHERE id_utilisateur = '$session'";
                                    //PREPARATION REQUETE
                                   $update1= $connexion->prepare($update_avatar);
                                   $update1->bindParam(':avatar',$avatar, PDO::PARAM_STR);
                                    //EXECUTION REQUETE
                                   $update1->execute(); 
                                }

                            

                                if($_SERVER["REQUEST_METHOD"] == "POST")
                                {
                                    // Vérifie si le fichier a été uploadé sans erreur.
                                    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0)
                                    {
                                        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                                        $filename = $_FILES["photo"]["name"];
                                        $filetype = $_FILES["photo"]["type"];
                                        $filesize = $_FILES["photo"]["size"];

                                        // Vérifie l'extension du fichier
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);

                                        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

                                        // Vérifie la taille du fichier - 5Mo maximum
                                        $maxsize = 5 * 1024 * 1024;

                                        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

                                        // Vérifie le type MIME du fichier
                                        if(in_array($filetype, $allowed))
                                        {
                                            // Vérifie si le fichier existe avant de le télécharger.
                                            if(file_exists("uploads/".$_FILES["photo"]["name"]))
                                            {
                                                echo $_FILES["photo"]["name"] . " existe déjà.";

                                            } 
                                            else
                                            {
                                                move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $_FILES["photo"]["name"]);

                                                header('location:profil.php');

                                            } 
                                        } 
                                        else
                                        {
                                            echo "Error: Téléchargement du fichier impossible. Veuillez réessayer."; 
                                        }
                                    } 
                                    else
                                    {
                                    echo "Error: " . $_FILES["photo"]["error"];
                                    }
                                }              

                        }
                        
                        //SI ON SUPPRIME LA PHOTO
                        if(isset($_POST['delete']))
                
                        {
                            //SI UN AVATAR EXISTE BIEN EN BDD
                            if($user_session_data_result[0]['avatar'] != NULL)
                            {
                                $avatar_delete = NULL ;
                                //SUPPRESSION AVATAR EN BDD
                                $delete_avatar = "UPDATE utilisateurs SET avatar=:avatar WHERE id_utilisateur = '$session' ";
                                //PREPARATION REQUETE
                                $delete1 = $connexion->prepare($delete_avatar);
                                $delete1->bindParam(':avatar',$avatar_delete, PDO::PARAM_NULL);
                                //EXECUTION REQUETE 
                                $delete1->execute();
                                header('location:profil.php');
                            }
                        }
                
                
                
                
                
                        
                        //MODIFICATION DES DONNEES DE L'UTILISATEUR SI ON APPUIS SUR VALIDER
                        if(isset($_POST['submit']))
                        {
                            //DEFINITION DES VARIABLES STOCKANT LES DONNEES UTILISATEURS
                            $gender=htmlentities(trim($_POST['gender']));
                            $lastname=htmlentities(trim($_POST['lastname']));
                            $firstname=htmlentities(trim($_POST['firstname']));
                            $mail=htmlentities(trim($_POST['mail']));
                            $phone=htmlentities(trim($_POST['phone_number']));
                            $password=htmlentities(trim($_POST['password']));
                            $check_password=htmlentities(trim($_POST['check_password']));
                            $hash=password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));
                            
                            //SI LE CHAMPS GENRE EST REMPLI
                            if($gender)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_gender = "UPDATE utilisateurs SET gender=:gender WHERE id_utilisateur = '$session' ";
                                //PREPARATION REQUETE
                                $update_niv1 = $connexion -> prepare($update_gender);
                                $update_niv1->bindParam(':gender',$gender, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv1->execute();
                            }
                           
                            //SI LE CHAMPS NOM EST REMPLI
                            if($lastname)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_lastname = "UPDATE utilisateurs SET nom=:lastname WHERE id_utilisateur = '$session' ";
                                //PREPARATION REQUETE
                                $update_niv2 = $connexion -> prepare($update_lastname);
                                $update_niv2->bindParam(':lastname',$lastname, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv2->execute();
                            }
                         
                            
                            //SI LE CHAMPS PRENOM EST REMPLI
                            if($firstname)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_firstname = "UPDATE utilisateurs SET prenom=:firstname WHERE id_utilisateur = '$session' ";
                                //PREPARATION REQUETE
                                $update_niv3 = $connexion -> prepare($update_firstname);
                                $update_niv3->bindParam(':firstname',$firstname, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv3->execute();
                            }
                            
                            if($mail)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_mail = "UPDATE utilisateurs SET email=:mail WHERE id_utilisateur = '$session' ";
                                //PREPARATION REQUETE
                                $update_niv4 = $connexion -> prepare($update_mail);
                                $update_niv4->bindParam(':mail',$mail, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv4->execute();
                            }
                            
                            if($phone)
                            {
                                //MISE A JOUR DES DONNEES
                                $update_phone = "UPDATE utilisateurs SET num_tel=:phone WHERE id_utilisateur = '$session' ";
                                //PREPARATION REQUETE
                                $update_niv5 = $connexion -> prepare($update_phone);
                                $update_niv5->bindParam(':phone',$phone, PDO::PARAM_STR);
                                //EXECUTION REQUETE
                                $update_niv5->execute();
                            }
                        
                            
                             //SI LES CHAMPS MOTS DE PASSE ET CONFIRMATION DE MOT DE PASSE SONT  REMPLIS
                            if($password AND $check_password)
                            {
                                if($password == $check_password)
                                {
                                    //MISE A JOUR DES DONNEES
                                    $update_password = "UPDATE utilisateurs SET password=:hash WHERE id_utilisateur = '$session' ";
                                    //PREPARATION REQUETE
                                    $update_niv6 = $connexion -> prepare($update_password);
                                    $update_niv6->bindParam(':hash',$hash, PDO::PARAM_STR);
                                    //EXECUTION REQUETE
                                    $update_niv6->execute();
                                }
                                else
                                {
                                    echo "Vos mots de passe doivent être identiques<br/>";
                                }
                            }
                      

                      
                            header ('location:profil.php');
                        }
                
                        if(isset($_POST['delete_account']))
                        {
                            $password=htmlentities(trim($_POST['password_delete']));
                            $check=htmlentities(trim($_POST['password_delete_check']));
                            
                            if(!empty($password) AND !empty($check))
                            {
                                if($password == $check);
                                $user->delete($password); 
                            }
                            
                        }


                }

                catch(PDOException $e)
                {
                    echo "Erreur : " . $e->getMessage();
                }
    

?>


        <h1>Modifier vos données personnelles</h1>


        <form action="" method="post" enctype="multipart/form-data">
            <img src="
                     <?php 
                      if($user_session_data_result[0]['avatar'] == NULL){
                          echo 'css/images/no-image.png';
                      }else{echo $user_session_data_result[0]['avatar'];}
                      ?>" alt="avatar" width="200"><br />


            <input type="file" name="photo">
            <input type="submit" name="send" value="ENVOYER">
            <input type='submit' name="delete" value="SUPPRIMER"><br />
        </form>

        <form action="" method="post">

            <?php 
            
            $gender_check = html_entity_decode($user_session_data_result[0]['gender']);
            $check = ($gender_check=="Femme")?true:false; 
            $check2 = ($gender_check=="Homme")?true:false; 
            $check3 = ($gender_check=="Non genré")?true:false; 
            
            ?>

            <input type="radio" name="gender" value="Femme" <?php if($check==true){echo "checked";}else{echo "";}  ?> />

            <label for="female">Femme</label>

            <input type="radio" name="gender" value="Homme" <?php if($check2==true){echo "checked";}else{echo "";} ?> />
            <label for="male">Homme</label>

            <input type="radio" name="gender" value="Non genré" <?php if($check3==true){echo "checked";}else{echo "";} ?> />
            <label for="no_gender">Non genré</label><br />

            <label for="name">Nom</label><br />
            <input type="text" name="lastname" value="<?php echo $user_session_data_result[0]['nom'] ?>"><br />
            <label for="firstname">Prénom</label><br />
            <input type="text" name="firstname" value="<?php echo $user_session_data_result[0]['prenom'] ?>"><br />

            <label for="mail">Email</label><br />
            <input type="mail" name="mail" value="<?php echo $user_session_data_result[0]['email'] ?>"><br />
            <label for="phone_number">Numéro de téléphone</label><br />
            <input type="text" name="phone_number" value="<?php echo $user_session_data_result[0]['num_tel'] ?>"><br />

            <label for="password">Mot de passe</label><br />
            <input type="password" name="password" placeholder="Entrez votre nouveau mot de passe"><br />
            <label for="password">Confirmation de mot de passe</label><br />
            <input type="password" name="check_password" placeholder="Confirmez votre nouveau mot de passe"><br />

            <input type="submit" name="submit" value="VALIDER"><br />

        </form>
        
        <br/>
        
        <h2>Suppression définitive du compte</h2>
        
        <form action="" method="post">
            <label for="">Entrez votre mot de passe actuel</label><br/>
            <input type="password" name="password_delete" placeholder="Entrez votre mot de passe actuel"><br/>
            <label for="password_delete_check">Confirmez votre mot de passe</label><br/>
            <input type="password" name="password_delete_check" placeholder="Confirmez votre mot de passe actuel"><br/><br/>
            <input type="submit" name="delete_account" value="SUPPRIMER">
        </form>

        <h1>Modifier vos réservations</h1>


    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>
