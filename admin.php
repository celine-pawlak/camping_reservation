<?php

ob_start();
$page_selected = 'admin';
?>

<!DOCTYPE html>
<html>

<head>
    <title>camping - admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
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


                //AJOUT NOUVEL UTILISATEUR


                if (isset($_POST['submit'])){
                    $user2 = new users ($db);
                    $user2->register(
                        $_POST['firstname'],
                        $_POST['lastname'],
                        $_POST['email'],
                        $_POST['password'],
                        $_POST['conf_password'],
                        $_POST['num_tel'],
                        $_POST['gender']
                    );
                }


                //SI ON APPUIS SUR DELETE UTILISATEUR
                if(isset($_POST['delete_user']))
                {
                    //DEFINITION VARIABLE ID_HIDDEN
                    $user_id = htmlentities(trim($_POST['id_hidden']));


        //SI ON APPUIS SUR DELETE UTILISATEUR
        if (isset($_POST['delete_user'])) {
            //DEFINITION VARIABLE ID_HIDDEN
            $user_id = htmlentities(trim($_POST['id_hidden']));

            //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
            $user_delete = $connexion->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = $user_id ");
            //EXECUTION REQUETE
            $user_delete->execute();

            //RAFRAICHISSEMENT PAGE
            header("location:admin.php");
        }

        //SI ON APPUIS SUR DELETE PLACE
        if (isset($_POST['delete_place'])) {
            //DEFINITION VARIABLE ID_HIDDEN
            $place_id = htmlentities(trim($_POST['place_id_hidden']));
            //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
            $place_delete = $connexion->prepare("DELETE FROM lieux WHERE id_lieu = $place_id");
            //EXECUTION REQUETE
            $place_delete->execute();

            //RAFRAICHISSEMENT PAGE
            header("location:admin.php");
        }

        //SI ON APPUIS SUR DELETE TYPE
        if (isset($_POST['delete_type'])) {
            //DEFINITION VARIABLE ID_HIDDEN
            $type_id = htmlentities(trim($_POST['type_id_hidden']));
            //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
            $type_delete = $connexion->prepare("DELETE FROM types_emplacement WHERE id_type_emplacement = $type_id ");
            //EXECUTION REQUETE
            $type_delete->execute();

            //RAFRAICHISSEMENT PAGE
            header("location:admin.php");
        }

        //SI ON APPUIS SUR DELETE OPTION
        if (isset($_POST['delete_option'])) {
            //DEFINITION VARIABLE ID_HIDDEN
            $option_id = htmlentities(trim($_POST['option_id_hidden']));
            //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
            $option_delete = $connexion->prepare("DELETE FROM options WHERE id_option = $option_id ");
            //EXECUTION REQUETE
            $option_delete->execute();

            //RAFRAICHISSEMENT PAGE
            header("location:admin.php");
        }


        <section class="users admin_table">
            <div class="">
                <h2>Tableau utilisateurs</h2><br/>
                <table>
                    <thead>
                        <tr>
                            <th class="display_none">Avatar</th>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th class="display_none">Sexe</th>
                            <th class="display_none">Email</th>
                            <th>Téléphone</th>
                            <th class="display_none">Date d'enregistrement</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($resultat_data_users as $info_users ){ ?>
                        <tr>
                            <td class="display_none avatar">
                                <img src="<?php if($info_users['avatar'] == NULL)
                                                        {
                                                            echo 'css/images/no-image.png';
                                                        }
                                                        else
                                                        {
                                                            echo $info_users['avatar'] ;
                                                        }?>" alt="avatar" width='30' height='30'>
                            </td>
                            <td><?php echo $info_users ['id_utilisateur']?></td>
                            <td><?php echo $info_users ['nom'] ?></td>
                            <td><?php echo $info_users ['prenom'] ?></td>

                            <td class="display_none">
                                <?php
                                            if($info_users ['gender'] == "Femme"){
                                                echo '<i class="fas fa-venus"></i>';
                                            }
                                            elseif($info_users ['gender'] == "Homme")
                                            {
                                                echo'<i class="fas fa-mars"></i>';
                                            }
                                            else
                                            {
                                                echo'<i class="fas fa-genderless"></i></i>';
                                            }
                                        ?>
                            </td>
                            <td class="display_none"><?php echo $info_users ['email'] ?></td>
                            <td><?php echo $info_users ['num_tel'] ?></td>
                            <td class="display_none"><?php echo $info_users ['register_date'] ?></td>

                            <td>
                                <a class="user_modify_button" href="compte_utilisateur.php?id=<?php echo $info_users['id_utilisateur']?>">MODIFIER</a>
                            </td>
                            <td class="delete_button">
                                <form method="post" action="">
                                    <button type="submit" name="delete_user"><i class="fas fa-trash-alt"></i></button>
                                    <input type="hidden" name="id_hidden" value="<?php echo $info_users ['id_utilisateur']  ?>">
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <form method="post" action="" class="form_user">
                    <h2>Ajouter un nouvel utilisateur</h2><br/>
                    <div class="form_admin_user">
                        <div class="section_add_list" id="gender_part">
                            <div class="gender_column">
                                <label>Genre</label>
                                <div class="gender_line">
                                     <input type="radio" name="gender" id="male" value="Homme" checked="checked">
                                    <label for="male">Homme</label>
                                </div>
                                <div class="gender_line">
                                    <input type="radio" name="gender" id="female" value="Femme">
                                    <label for="female">Femme</label>
                                </div>
                                <div class="gender_line">
                                    <input type="radio" name="gender" id="no_gender" value="Non genré">
                                    <label for="no_gender">Non genré</label>
                                </div>
                            </div>
                        </div>
                        <div class="section_add_list">
                            <label for="lastname">Nom</label>
                            <input type="text" name="lastname" placeholder="Nom" autocomplete="on">
                            <label for="firstname">Prénom</label>
                            <input type="text" name="firstname" placeholder="Prénom" autocomplete="on">
                            <label for="num_tel">Numéro de téléphone</label>
                            <input type="text" name="num_tel" placeholder="0123456789" autocomplete="on">

                        </div>
                        <div class="section_add_list">

                            <label for="email">Email</label>
                            <input type="email" name="email" placeholder="email@email.com" autocomplete="on">
                             <label for="password">Mot de passe</label>
                            <input type="password" name="password" placeholder="Mot de passe">
                            <label for="conf_password">Confirmation mot de passe</label>
                            <input type="password" name="conf_password" placeholder="Confirmer mot de passe">
                        </div>
                    </div>
                    <div>
                        <button type="submit" name="submit">Enregistrer</button>
                    </div>
                </form>
            </div>

        </section>

        <section class="form_user">

            <form method="post" action="">
                <h2>Ajouter un nouvel utilisateur</h2><br/>
                <input type="radio" name="gender" id="male" value="Homme" checked="checked">
                <label for="male">Homme</label>
                <input type="radio" name="gender" id="female" value="Femme">
                <label for="female">Femme</label>
                <input type="radio" name="gender" id="no_gender" value="Non genré">
                <label for="no_gender">Non genré</label><br/>

                <label for="lastname">Nom</label><br/>
                <input type="text" name="lastname" placeholder="Nom" autocomplete="on"><br/>
                <label for="firstname">Prénom</label><br/>
                <input type="text" name="firstname" placeholder="Prénom" autocomplete="on"><br/>

                <label for="email">Email</label><br/>
                <input type="email" name="email" placeholder="email@email.com" autocomplete="on"><br/>
                <label for="num_tel">Numéro de téléphone</label><br/>
                <input type="text" name="num_tel" placeholder="0123456789" autocomplete="on"><br/>

                <label for="password">Mot de passe</label><br/>
                <input type="password" name="password" placeholder="Mot de passe"><br/>
                <label for="conf_password">Confirmation mot de passe</label><br/>
                <input type="password" name="conf_password" placeholder="Confirmer mot de passe"><br/><br/>

                <button type="submit" name="submit">Enregistrer</button>
            </form>
        </section>

    </section>


    <section class="admin_general">
        <br/>
        <h1>MODIFICATION DES TARIFS, EMPLACEMENTS ET OPTIONS</h1>
        <div class="gestion_admin">
            <section class="admin_table admin_gestion">
                <h2>Gestions des sites</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Lieux</th>
                        <th>Emplacement(s)</th>
                        <th>Tarif/j</th>
                        <th>Editer</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data_place_price_result as $place) { ?>
                        <tr>
                            <td><?php
                                echo html_entity_decode($place['nom_lieu']) ?></td>
                            <td><?php
                                echo $place['emplacements_disponibles'] ?></td>
                            <td><?php
                                echo $place['prix_journalier'] . '€' ?></td>
                            <td>
                                <a class="user_modify_button" href="admin.php?modifier_lieu=<?php
                                echo $place['nom_lieu'] ?>">EDITER</a>
                            </td>
                            <td>
                                <form method="post" action="">
                                    <button type="submit" name="delete_place"><i class="fas fa-times"></i></button>
                                    <input type="hidden" name="place_id_hidden" value="<?php
                                    echo $place['id_lieu'] ?>">
                                </form>
                            </td>

                        </tr>
                    <?php
                    } ?>
                    </tbody>
                </table>

                <?php

                if (isset($_GET['modifier_lieu'])) {
                    //var_dump($_POST);

                    //DEFINITION VARIABLE NAME_HIDDEN
                    $place_name = htmlentities(trim($_GET['modifier_lieu']));

                    //SI ON APPUIS SUR MODIFIER LIEUX
                    if (isset($_POST['update_place_submit'])) {
                        //DEFINITION DES VARIABLES STOCKANT LES LIEUX, NBR EMPLACEMENT PAR LIEU ET TARIFS
                        $update_place = htmlentities(trim($_POST['update_place_name']));
                        $update_nb_place = htmlentities(trim($_POST['update_nb_place']));
                        $update_price_place = htmlentities(trim($_POST['update_price_place']));

                        var_dump($update_place);
                        var_dump($update_nb_place);

                        var_dump($update_price_place);


                        //SI LE NOM DU LIEU EST RENSEIGNE

                        if (!empty($update_nb_place)) {
                            //MISE A JOUR NB EMPLACEMENT
                            $update_place_nb = "UPDATE lieux SET emplacements_disponibles=:nb_place WHERE nom_lieu = '$place_name'";
                            //PREPARATION REQUETE
                            $update_place_nb1 = $connexion->prepare($update_place_nb);
                            $update_place_nb1->bindParam(':nb_place', $update_nb_place, PDO::PARAM_INT);
                            //EXECUTION REQUETE

                            $update_place_nb1->execute();
                            var_dump($update_place_nb1->execute());
                        }

                        if (!empty($update_price_place)) {
                            //MISE A JOUR NB EMPLACEMENT
                            $update_place_price = "UPDATE lieux SET prix_journalier=:price_place WHERE nom_lieu = '$place_name'";
                            //PREPARATION REQUETE
                            $update_place_price1 = $connexion->prepare($update_place_price);
                            $update_place_price1->bindParam(':price_place', $update_price_place, PDO::PARAM_INT);
                            //EXECUTION REQUETE
                            $update_place_price1->execute();
                        }

                        if (!empty($update_place)) {
                            //MISE A JOUR NOM LIEU
                            $update_place_name = "UPDATE lieux SET nom_lieu=:nom_lieu WHERE nom_lieu = '$place_name'";
                            $update_place_name_bis = "UPDATE detail_lieux SET nom_lieu=:nom_lieu WHERE nom_lieu='$place_name' ";
                            //PREPARATION REQUETE
                            $update_place_name1 = $connexion->prepare($update_place_name);
                            $update_place_name1_bis = $connexion->prepare($update_place_name_bis);
                            $update_place_name1->bindParam(':nom_lieu', $update_place, PDO::PARAM_STR);
                            $update_place_name1_bis->bindParam(':nom_lieu', $update_place, PDO::PARAM_STR);
                            //EXECUTION REQUETE
                            $update_place_name1->execute();
                            $update_place_name1_bis->execute();
                        }

                        header("location:admin.php");
                    }


                    ?>
                    <form class="form_admin" action='' method='post'>
                        <h3>Modifier un lieu</h3><br/>
                        <label for='update_place_name'>Modification nom lieu</label><br/>
                        <input type='text' name='update_place_name'><br/>
                        <label for='update_nb_place'>Modification du nbr d'emplacement</label><br/>
                        <input type='number' name='update_nb_place'><br/>
                        <label for='update_price_place'>Modification du tarif</label><br/>
                        <input type='number' step='0.01' name='update_price_place'><br/><br/>
                        <input type='submit' name='update_place_submit' value='EDITER'>
                    </form>

                    <?php
                }
                ?>


                <form class="form_admin" method="post" action="">
                    <h3>Ajouter un nouveau lieu</h3><br/>
                    <label for="place">Lieux</label><br/>
                    <input type="text" name="place"><br/>
                    <label for="place">Nbr d'emplacement(s) par lieu</label><br/>
                    <input type="number" name="number_place"><br/>
                    <label for="place">Tarif journalier</label><br/>
                    <input type="number" step="0.01" name="price_place"><br/><br/>
                    <input type="submit" name="add_place" value="VALIDER">
                </form>

            </section>


            <section class="admin_table admin_gestion">
                <h2>Gestion des types d'emplacements</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Type d'emplacement</th>
                        <th>Taille</th>
                        <th>Editer</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data_place_type_result as $type) { ?>
                        <tr>
                            <td><?php
                                echo html_entity_decode($type['nom_type_emplacement']) ?></td>
                            <td><?php
                                echo $type['nb_emplacement'] ?></td>
                            <td>
                                <a class="user_modify_button" href="admin.php?modifier_type=<?php
                                echo $type['id_type_emplacement'] ?>">EDITER</a>
                            </td>
                            <td>
                                <form method="post" action="">
                                    <button type="submit" name="delete_type"><i class="fas fa-times"></i></button>
                                    <input type="hidden" name="type_id_hidden" value="<?php
                                    echo $type['id_type_emplacement'] ?>">
                                </form>
                            </td>
                        </tr>
                    <?php
                    } ?>
                    </tbody>
                </table>

                <?php
                if (isset($_GET['modifier_type'])) {
                    //DEFINITION VARIABLE TYPE_HIDDEN
                    $type_name = htmlentities(trim($_GET['modifier_type']));

                    //SI ON APPUIS SUR MODIFIER TYPE D'EMPLACEMENT
                    if (isset($_POST['update_type_submit'])) {
                        //DEFINITION DES VARIABLES STOCKANT LES TYPES D'EMPLACEMENT ET LEUR TAILLE
                        $update_type_name = htmlentities(trim($_POST['update_type_name']));
                        $update_size_type = htmlentities(trim($_POST['update_size']));

                        //DEFINITION VARIABLE ID_HIDDEN
                        $type_id2 = htmlentities(trim($_POST['type_id_hidden2']));

                        //SI LE TYPE D'EMPLACEMENT EST RENSEIGNE
                        if (!empty($update_type_name)) {
                            //MISE A JOUR TYPE D'EMPLACEMENT
                            $update_type = "UPDATE types_emplacement SET nom_type_emplacement=:nom_type WHERE id_type_emplacement = $type_id2";
                            //PREPARATION REQUETE
                            $update_type1 = $connexion->prepare($update_type);
                            $update_type1->bindParam(':nom_type', $update_type_name, PDO::PARAM_STR);
                            //EXECUTION REQUETE
                            $update_type1->execute();

                            header("location:admin.php");
                        }

                        //SI LA TAILLE DU TYPE D'EMPLACEMENT EST RENSEIGNE
                        if (!empty($update_size_type)) {
                            //MISE A JOUR TAILLE EMPLACEMENT
                            $update_size = "UPDATE types_emplacement SET nb_emplacement=:nb_size WHERE id_type_emplacement = $type_id2";
                            //PREPARATION REQUETE
                            $update_size1 = $connexion->prepare($update_size);
                            $update_size1->bindParam(':nb_size', $update_size_type, PDO::PARAM_INT);
                            //EXECUTION REQUETE
                            $update_size1->execute();

                            header("location:admin.php");
                        }
                    }

                    ?>

                    <form class="form_admin" method="post" action="">
                        <h3>Modifier un type d'emplacement</h3><br/>
                        <label for="update_type_name">Modification type d'emplacement</label>
                        <input type="text" name="update_type_name">
                        <label for="update_size">Modification taille emplacement</label>
                        <input type="number" name="update_size">
                        <input type="hidden" name="type_id_hidden2" value="<?php
                        echo $type['id_type_emplacement'] ?>"><br/><br/>
                        <input type="submit" name="update_type_submit" value="MODIFIER">
                    </form>

                    <?php
                }
                ?>


                <form class="form_admin" method="post" action="">
                    <h3>Ajouter un nouveau type d'emplacement</h3><br/>
                    <label for="type">Type d'emplacement</label><br/>
                    <input type="text" name="type"><br/>
                    <label for="number_place_type">Taille emplacement</label><br/>
                    <input type="number" name="number_place_type"><br/><br/>
                    <input type="submit" name="add_type" value="VALIDER">
                </form>
            </section>


            <section class="admin_table admin_gestion">
                <h2> Gestion des options</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Options</th>
                        <th>Tarifs</th>
                        <th>Editer</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data_option_price_result as $option) { ?>
                        <tr>
                            <td><?php
                                echo html_entity_decode($option['nom_option']) ?></td>
                            <td><?php
                                echo $option['prix_option'] . '€' ?></td>
                            <td>
                                <a class="user_modify_button" href="admin.php?modifier_option=<?php
                                echo $option['id_option'] ?>">EDITER</a>
                            </td>
                            <td>
                                <form method="post" action="">
                                    <button type="submit" name="delete_option"><i class="fas fa-times"></i></button>
                                    <input type="hidden" name="option_id_hidden" value="<?php
                                    echo $option['id_option'] ?>">
                                </form>
                            </td>
                        </tr>
                    <?php
                    } ?>
                    </tbody>
                </table>
                <?php

                if (isset($_GET['modifier_option'])) {
                    //DEFINITION VARIABLE ID_HIDDEN
                    $option_id2 = htmlentities(trim($_GET['modifier_option']));

                    //SI ON APPUIS SUR MODIFIER OPTION
                    if (isset($_POST['update_option_submit'])) {
                        //DEFINITION DES VARIABLES STOCKANT LES TYPES D'EMPLACEMENT ET LEUR TAILLE
                        $update_option_name = htmlentities(trim($_POST['update_option_name']));
                        $update_option_price = htmlentities(trim($_POST['update_price_option']));


                        //var_dump($POST);
                        //SI LE TYPE D'EMPLACEMENT EST RENSEIGNE
                        if (!empty($update_option_name)) {
                            //MISE A JOUR TYPE D'EMPLACEMENT
                            $update_option = "UPDATE options SET nom_option=:nom_option WHERE id_option = $option_id2";
                            //PREPARATION REQUETE
                            $update_option1 = $connexion->prepare($update_option);
                            $update_option1->bindParam(':nom_option', $update_option_name, PDO::PARAM_STR);
                            //EXECUTION REQUETE
                            $update_option1->execute();

                            header("location:admin.php");
                        }

                        //SI LA TAILLE DU TYPE D'EMPLACEMENT EST RENSEIGNE
                        if (!empty($update_option_price)) {
                            //MISE A JOUR TAILLE EMPLACEMENT
                            $update_price_option = "UPDATE options SET prix_option=:prix_option WHERE id_option = $option_id2";
                            //PREPARATION REQUETE
                            $update_price_option1 = $connexion->prepare($update_price_option);
                            $update_price_option1->bindParam(':prix_option', $update_option_price, PDO::PARAM_INT);
                            //EXECUTION REQUETE
                            $update_price_option1->execute();

                            header("location:admin.php");
                        }
                    }
                    ?>

                    <form class="form_admin" method="post" action="">
                        <h3>Modifier une option</h3><br/>
                        <label for="update_option_name">Modification option</label>
                        <input type="text" name="update_option_name">
                        <label for="update_price_option">Modification tarifs</label>
                        <input type="number" step="0.01" name="update_price_option">
                        <input type="hidden" name="option_id_hidden2" value="<?php
                        echo $option['id_option'] ?>"><br/><br/>
                        <input type="submit" name="update_option_submit" value="MODIFIER">
                    </form>

                <?php
                } ?>

                <form class="form_admin" method="post" action="">
                    <h3>Ajouter une nouvelle option</h3><br/>
                    <label for="option">Options</label><br/>
                    <input type="text" name="option"><br/>
                    <label for="place">Tarifs</label><br/>
                    <input type="number" step="0.01" name="price_option"><br/><br/>
                    <input type="submit" name="add_option" value="VALIDER">
                </form>
            </section>
        </div>


    </section>


</main>
<footer>
    <?php
    include("includes/footer.php") ?>
</footer>
</body>

</html>

<?php
ob_end_flush();

?>

<!--





-->
