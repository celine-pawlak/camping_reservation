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
            
            
                //SELECTION DU LIEU ET DU TARIF PAR LIEU
                $data_place_price = $connexion->prepare("SELECT * FROM lieux ");
                //EXECUTION REQUETE
                $data_place_price->execute();
                //RECUPERATION DONNEES TARIFS
                $data_place_price_result = $data_place_price->fetchAll(PDO::FETCH_ASSOC);
            
                 //SELECTION DU TYPE D'EMPLACEMENT ET DU NB
                $data_place_type = $connexion->prepare("SELECT * FROM types_emplacement ");
                //EXECUTION REQUETE
                $data_place_type->execute();
                //RECUPERATION DONNEES TARIFS
                $data_place_type_result = $data_place_type->fetchAll(PDO::FETCH_ASSOC);
            
                 //SELECTION DES OPTIONS ET DE LEUR PRIX
                $data_option_price = $connexion->prepare("SELECT * FROM options ");
                //EXECUTION REQUETE
                $data_option_price->execute();
                //RECUPERATION DONNEES TARIFS
                $data_option_price_result = $data_option_price->fetchAll(PDO::FETCH_ASSOC);
            

                //SI ON APPUIS SUR DELETE UTILISATEUR
                if(isset($_POST['delete_user']))
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
        
                //SI ON APPUIS SUR DELETE PLACE
                if(isset($_POST['delete_place']))
                {
                    //DEFINITION VARIABLE ID_HIDDEN
                    $place_id = htmlentities(trim($_POST['place_id_hidden']));

                    //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
                    $place_delete = $connexion->prepare("DELETE FROM lieux WHERE id_lieu = '$place_id' ");
                    //EXECUTION REQUETE
                    $place_delete->execute();
                    
                     //RAFRAICHISSEMENT PAGE
                    header("location:admin.php");
                }
            
                //SI ON APPUIS SUR DELETE TYPE
                if(isset($_POST['delete_type']))
                {
                    //DEFINITION VARIABLE ID_HIDDEN
                    $type_id = htmlentities(trim($_POST['type_id_hidden']));
                    //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
                    $type_delete = $connexion->prepare("DELETE FROM types_emplacement WHERE id_type_emplacement = '$type_id' ");
                    //EXECUTION REQUETE
                    $type_delete->execute();
                    
                     //RAFRAICHISSEMENT PAGE
                    header("location:admin.php");
                }
            
                //SI ON APPUIS SUR DELETE OPTION
                if(isset($_POST['delete_option']))
                {
                    //DEFINITION VARIABLE ID_HIDDEN
                    $option_id = htmlentities(trim($_POST['option_id_hidden']));
                    //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
                    $option_delete = $connexion->prepare("DELETE FROM options WHERE id_option = '$option_id' ");
                    //EXECUTION REQUETE
                    $option_delete->execute();
                    
                     //RAFRAICHISSEMENT PAGE
                    header("location:admin.php");
                }

                
                //SI ON APPUIS SUR AJOUTER UN LIEU 
                if(isset ($_POST['add_place']))
                {
                    //DEFINITION DES VARIABLES STOCKANT LES LIEUX, NBR EMPLACEMENT PAR LIEU ET TARIFS
                    $place=htmlentities(trim($_POST['place']));
                    $nbr_place=htmlentities(trim($_POST['number_place']));
                    $tarif=htmlentities(trim($_POST['price_place']));

                    //SI LES CHAMPS PRECEDENTS SONT RENSEIGNES
                    if($place AND $nbr_place AND $tarif)
                    {
                        // VERIFICATION CORRESPONDANCE BDD 
                        $check_place_match = $connexion->prepare ("SELECT * FROM lieux WHERE nom_lieu = '$place' ");
                        // EXECUTION REQUETE
                        $check_place_match->execute();
                        //RECUPERATION DONNEES
                        $check_place_match_result = $check_place_match->rowCount();
                        
                        //SI IL EXISTE DEJA DANS LA BDD
                        if($check_place_match_result>=1)
                        {
                           echo'Ce lieu existe déjà'; 
                        }
                        else
                        {
                            //INSERTION NOUVEAU LIEU
                            $insert_place = "INSERT INTO lieux (nom_lieu,emplacements_disponibles,prix_journalier) VALUES (:place,:nbr_place, :tarif)";
                            //PREPARATION REQUETE
                            $insert_place1 = $connexion->prepare($insert_place);
                            $insert_place1->bindParam(':place',$place, PDO::PARAM_STR);
                            $insert_place1->bindParam(':nbr_place',$nbr_place, PDO::PARAM_INT);
                            $insert_place1->bindParam(':tarif',$tarif, PDO::PARAM_INT);
                            //EXECUTION REQUETE
                            $insert_place1->execute(); 
                             header("location:admin.php");
                        }
                    }
                    else 
                    {
                    echo'Veuillez remplir tous les champs';
                    }
                }
                
            
                //SI ON APPUIS SUR AJOUTER UN TYPE D'EMPLACEMENT 
                if(isset ($_POST['add_type']))
                {
                    //DEFINITION DES VARIABLES STOCKANT LES TYPES D'EMPLACEMENTS ET LEUR TAILLE
                    $type_place=htmlentities(trim($_POST['type']));
                    $nbr_place_type=htmlentities(trim($_POST['number_place_type']));

                    //SI LES CHAMPS PRECEDENTS SONT RENSEIGNES
                    if( $type_place AND $nbr_place_type)
                    {
                        // VERIFICATION CORRESPONDANCE BDD 
                        $check_type_match = $connexion->prepare ("SELECT * FROM types_emplacement WHERE nom_type_emplacement = ' $type_place' ");
                        // EXECUTION REQUETE
                        $check_type_match->execute();
                        //RECUPERATION DONNEES
                        $check_type_match_result = $check_type_match->rowCount();
                        
                        //SI IL EXISTE DEJA DANS LA BDD
                        if($check_type_match_result>=1)
                        {
                           echo'Ce type d\'emplacement existe déjà'; 
                        }
                        else
                        {
                            //INSERTION NOUVEAU TYPE
                            $insert_type = "INSERT INTO types_emplacement (nom_type_emplacement,nb_emplacement) VALUES (:type,:nbr_place_type)";
                            //PREPARATION REQUETE
                            $insert_type1 = $connexion->prepare($insert_type);
                            $insert_type1->bindParam(':type',$type_place, PDO::PARAM_STR);
                            $insert_type1->bindParam(':nbr_place_type',$nbr_place_type, PDO::PARAM_INT);
                            //EXECUTION REQUETE
                            $insert_type1->execute(); 
                            header("location:admin.php");
                        }
                    }
                    else 
                    {
                    echo'Veuillez remplir tous les champs';
                    }
                }
            
                 //SI ON APPUIS SUR AJOUTER UNE OPTION
                if(isset ($_POST['add_option']))
                {
                    //DEFINITION DES VARIABLES STOCKANT OPTIONS ET TARIFS
                    $option = htmlentities(trim($_POST['option']));
                    $price_option = htmlentities(trim($_POST['price_option']));

                    //SI LES CHAMPS PRECEDENTS SONT RENSEIGNES
                    if($option AND $price_option)
                    {
                        // VERIFICATION CORRESPONDANCE BDD 
                        $check_option_match = $connexion->prepare ("SELECT * FROM options WHERE nom_option = '$option' ");
                        // EXECUTION REQUETE
                        $check_option_match->execute();
                        //RECUPERATION DONNEES
                        $check_option_match_result = $check_option_match->rowCount();
                        
                        //SI IL EXISTE DEJA DANS LA BDD
                        if($check_option_match_result>=1)
                        {
                           echo'Cette option existe déjà'; 
                        }
                        else
                        {
                            //INSERTION NOUVELLE OPTION
                             $insert_option = "INSERT INTO options (nom_option,prix_option) VALUES (:option,:prix_option)";
                            //PREPARATION REQUETE
                            $insert_option1 = $connexion->prepare($insert_option);
                            $insert_option1->bindParam(':option',$option, PDO::PARAM_STR);
                            $insert_option1->bindParam(':prix_option',$price_option, PDO::PARAM_INT);
                            //EXECUTION REQUETE
                            $insert_option1->execute(); 
                            header("location:admin.php");
                        }
                    }
                    
                }
            
            
                //SI ON APPUIS SUR MODIFIER LIEUX
                if(isset($_POST['update_place']))
                {
                    //DEFINITION DES VARIABLES STOCKANT LES LIEUX, NBR EMPLACEMENT PAR LIEU ET TARIFS
                    $update_place = htmlentities(trim($_POST['update_place_name']));
                    $update_nb_place = htmlentities(trim($_POST['update_nb_place']));
                    $update_price_place = htmlentities(trim($_POST['update_price_place']));
                    
                    //SI L'UN DES CHAMPS PRECEDENTS EST RENSEIGNE
                    if($update_place OR $update_nb_place OR $update_price_place)
                    {
                        
                    }
                }
                
        }
           
            
            

        catch(PDOException $e)
        {
            echo "Erreur : ". $e->getMessage();
        }
        ?>


        <h1>Tableau utilisateur</h1>
        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                    <th>Date d'enregistrement</th>
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
                    <td><?php echo $info_users ['id_utilisateur']?></td>
                    <td><?php echo $info_users ['nom'] ?></td>
                    <td><?php echo $info_users ['prenom'] ?></td>
                    
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
                                echo'<i class="fas fa-genderless"></i></i>';
                            }
                        ?>
                    </td>
                    <td><?php echo $info_users ['email'] ?></td>
                    <td><?php echo $info_users ['num_tel'] ?></td>
                    <td><?php echo $info_users ['register_date'] ?></td>
                    
                    <td>
                        <a href="compte_utilisateur.php?id=<?php echo $info_users['id_utilisateur']?>">MODIFIER</a>
                    </td>
                    <td>
                        <form method="post" action="">
                            <button type="submit" name="delete_user"><i class="fas fa-trash-alt"></i></button>
                            <input type="hidden" name="id_hidden" value="<?php echo $info_users ['id_utilisateur']  ?>">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h1>Modification des tarifs et emplacements</h1>
        
        <h2>Lieux, emplacements et tarifs journaliers</h2>
        <table>
            <thead>
                <tr>
                    
                    <th>Lieux</th>
                    <th>Nbr d'emplacement par lieu</th>
                    <th>Tarif journalier</th>
                    <th>Mise à jour</th>
                    <th>Suppression</th>
                   
                    
            </thead>
            <tbody>
                <?php foreach($data_place_price_result as $place){ ?>
                <tr>
                    
                    <td><?php echo $place['nom_lieu'] ?></td>
                    <td><?php echo $place['emplacements_disponibles'] ?></td>
                    <td><?php echo $place['prix_journalier'].'€' ?></td>
                    <td>
                        <form action="" method="post">
                            <label for="update_place_name">Modification nom lieu</label><br/>
                            <input type="text" name="update_place_name"><br/>
                            <label for="update_nb_place">Modification du nbr d'emplacement</label><br/>
                            <input type="number" name="update_nb_place"><br/>
                            <label for="update_price_place">Modification du tarif</label><br/>
                            <input type="number" step="0.01" name="update_price_place"><br/>
                            <input type="submit" name="update_place" value="MODIFIER"><br/>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="">
                            <button type="submit" name="delete_place"><i class="fas fa-times"></i></button>
                            <input type="hidden" name="place_id_hidden" value="<?php echo $place['id_lieu']  ?>">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3>Ajouter un nouveau lieu</h3>
        <form method="post" action=""> 
            <label for="place">Lieux</label>
            <input type="text" name="place"><br/>
            <label for="place">Nbr d'emplacement(s) par lieu</label>
            <input type="number" name="number_place"><br/>
            <label for="place">Tarif journalier</label>
            <input type="number" step="0.01" name="price_place"><br/>
            <input type="submit" name="add_place" value="VALIDER">
        </form>
        
        <h2>Types et nombre d'emplacement(s)</h2>
        <table>
            <thead>
                <tr>
                    <th>Supprimer</th>
                    <th>Types d'emplacement</th>
                    <th>Nbr d'emplacement par types</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data_place_type_result as $type){ ?>
                <tr>
                    <td>
                        <form method="post" action="">
                            <button type="submit" name="delete_type"><i class="fas fa-times"></i></button>
                            <input type="hidden" name="type_id_hidden" value="<?php echo $type['id_type_emplacement']  ?>">
                        </form>
                    </td>
                    <td><?php echo $type['nom_type_emplacement'] ?></td>
                    <td><?php echo $type['nb_emplacement'] ?></td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3>Ajouter un nouveau type d'emplacement</h3>
        <form method="post" action=""> 
            <label for="place">Type d'emplacement</label>
            <input type="text" name="type"><br/>
            <label for="place">Nbr d'emplacement(s) par type</label>
            <input type="number" name="number_place_type"><br/>
            <input type="submit" name="add_type" value="VALIDER">
        </form>
        
        <h2>Options</h2>
        <table>
            <thead>
                <tr>
                    <th>Supprimer</th>
                    <th>Options</th>
                    <th>Tarifs</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data_option_price_result as $option){ ?>
                <tr>
                    <td>
                        <form method="post" action="">
                            <button type="submit" name="delete_option"><i class="fas fa-times"></i></button>
                            <input type="hidden" name="option_id_hidden" value="<?php echo $option['id_option']  ?>">
                        </form>
                    </td>
                    <td><?php echo $option['nom_option'] ?></td>
                    <td><?php echo $option['prix_option'].'€' ?></td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3>Ajouter une nouvelle option</h3>
        <form method="post" action=""> 
            <label for="option">Options</label>
            <input type="text" name="option"><br/>
            <label for="place">Tarifs</label>
            <input type="number" step="0.01" name="price_option"><br/>
            <input type="submit" name="add_option" value="VALIDER">
        </form>


        
        
        
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
</body>

</html>

<!-- 





-->
