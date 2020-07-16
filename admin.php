<?php
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
        <?php
        //TENTATIVE CONNEXION BDD
        try
        {
            //CONNEXION BDD
            $connexion=new PDO("mysql:host=localhost;dbname=camping",'root','');
            // DEFINITION MODE D'ERREUR PDO SUR EXCEPTION
            $connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
                //SELECTION DE TOUTES LES DONNEES UTILISATEURS
                $data_users = $connexion->prepare("SELECT * FROM utilisateurs");
                //EXECUTION REQUETE
                $data_users->execute();
                //RECUPERATION RESULTAT
                $resultat_data_users = $data_users->fetchAll(PDO::FETCH_ASSOC);
                
            
                //SELECTION DE TOUS LES TARIFS
                $data_price = $connexion->prepare("SELECT reservations.id_reservation, lieux.nom_lieu,lieux.prix_base, types_emplacement.nom_type_emplacement,types_emplacement.nb_emplacement,options.nom_option, options.prix_option FROM reservations, lieux, types_emplacement, options WHERE reservations.id_reservation = lieux.id_reservation AND reservations.id_reservation = types_emplacement.id_reservation AND reservations.id_reservation = options.id_reservation ");
                //EXECUTION REQUETE
                $data_price->execute();
                //RECUPERATION DONNEES TARIFS
                $date_price_result = $data_price->fetchAll(PDO::FETCH_ASSOC);

                //SI ON APPUIS SUR DELETE
                if(isset($_POST['delete']))
                {
                    //DEFINITION VARIABLE ID_HIDDEN
                    $user_id = htmlentities(trim($_POST['id_hidden']));

                    //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
                    $user_delete = $connexion->prepare("DELETE FROM utilisateurs WHERE id = '$user_id' ");
                    //EXECUTION REQUETE
                    $user_delete->execute();

                    //RAFRAICHISSEMENT PAGE
                    header("location:admin.php");
                }
                
                
                
                //SI ON APPUIS SUR MODIFIER LES PRIX
                if(isset ($_POST['price']))
                {
                    //DEFINITION DES VARIABLES STOCKANT LES TARIFS ET OPTIONS
                    $emplacement=htmlentities(trim($_POST['emplacement']));
                    $option_A=htmlentities(trim($_POST['option_A']));
                    $option_B=htmlentities(trim($_POST['option_B']));
                    $option_C=htmlentities(trim($_POST['option_C']));
                    
                    //SI LE CHAMPS EMPLACEMENT EST RENSEIGNE
                    if($emplacement)
                    {
                        //MISE A JOUR DU TARIF
                        $update_place_price = "UPDATE tarifs SET emplacement=:emplacement ";
                        //PREPARATION REQUETE
                        $update_price1 = $connexion->prepare($update_place_price);
                        //EXECUTION REQUETE
                        $update_price1->bindParam(':emplacement',$emplacement,PDO::PARAM_INT);
                        $update_price1->execute();
                    }
                    
                    if($option_A)
                    {
                        //MISE A JOUR DU TARIF
                        $update_optionA_price = "UPDATE tarifs SET option_A=:option_A ";
                        //PREPARATION REQUETE
                        $update_price2 = $connexion->prepare($update_optionA_price);
                        //EXECUTION REQUETE
                        $update_price2->bindParam(':option_A',$option_A,PDO::PARAM_INT);
                        $update_price2->execute();
                    }
                    
                    if($option_B)
                    {
                        //MISE A JOUR DU TARIF
                        $update_optionB_price = "UPDATE tarifs SET option_B=:option_B ";
                        //PREPARATION REQUETE
                        $update_price3 = $connexion->prepare($update_optionB_price);
                        //EXECUTION REQUETE
                        $update_price3->bindParam(':option_B',$option_B,PDO::PARAM_INT);
                        $update_price3->execute();
                    }
                    
                    if($option_C)
                    {
                        //MISE A JOUR DU TARIF
                        $update_optionC_price = "UPDATE tarifs SET option_B=:option_B ";
                        //PREPARATION REQUETE
                        $update_price4 = $connexion->prepare($update_optionC_price);
                        //EXECUTION REQUETE
                        $update_price4->bindParam(':option_C',$option_C,PDO::PARAM_INT);
                        $update_price4->execute();
                    }
                    
                    header("location:admin.php");
                }
                
                

           
                
        }
           
            
            

        catch(PDOException $e)
        {
            echo "Erreur : ". $e->getMessage();
        }
        ?>


        <h1>TABLEAU UTILISATEUR</h1>
        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Id</th>
                    <th>Login</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Sexe</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultat_data_users as $info_users ){ ?>
                <tr>
                    <td>
                        <img src="<?php if($info_users['avatar'] == NULL)
                                        {   
                                            echo 'css/images/no-image.png';
                                            
                                        }
                                        else
                                        {
                                            echo $info_users['avatar'] ; 
                                        }?>" alt="avatar" width='30'>
                    </td>
                    <td><?php echo $info_users ['id']?></td>
                    <td><?php echo $info_users ['login'] ?></td>
                    <td><?php echo $info_users ['firstname'] ?></td>
                    <td><?php echo $info_users ['lastname'] ?></td>
                    <td>
                        <?php 
                            if($info_users ['gender'] == "female"){
                                echo '<i class="fas fa-venus"></i>';
                            }
                            elseif($info_users ['gender'] == "male")
                            {
                                echo'<i class="fas fa-mars"></i>';
                            }
                            else
                            {
                                echo'<i class="far fa-circle"></i>';
                            }
                        ?>
                    </td>
                    <td><?php echo $info_users ['mail'] ?></td>
                    <td><?php echo $info_users ['phone_number'] ?></td>
                    <td>
                        <a href="compte_utilisateur.php?id=<?php echo $info_users['id']?>">MODIFIER</a>
                    </td>
                    <td>
                        <form method="post" action="">
                            <button type="submit" name="delete"><i class="fas fa-trash-alt"></i></button>
                            <input type="hidden" name="id_hidden" value="<?php echo $info_users ['id']  ?>">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>





        <h1>Modification des tarifs</h1>

        <table>
            <thead>
                <tr>
                    <th>Tarif emplacement unique</th>
                    <th>Option borne électrique</th>
                    <th>Option Club Disco</th>
                    <th>Option Sport</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($date_price_result as $info_tarif){?>
                <tr>
                    <td><?php echo  $info_tarif['emplacement'].' €'?></td>
                    <td><?php echo  $info_tarif['option_A'].' €' ?></td>
                    <td><?php echo  $info_tarif['option_B'].' €' ?></td>
                    <td><?php echo  $info_tarif['option_C'].' €' ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>



        <form method="post" action="">
            <label for="emplacement">Tarif emplacement</label>
            <input type="text" name="emplacement"><br />

            <label for="option_A">Option borne électrique</label>
            <input type="text" name="option_A"><br />

            <label for="option_B">Option Club Disco</label>
            <input type="text" name="option_B"><br />

            <label for="option_C"> Option Sport</label>
            <input type="text" name="option_C"><br />

            <input type="submit" name="price" value="MODIFIER">
        </form>
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
</body>

</html>
