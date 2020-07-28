<?php
ob_start();
$page_selected = 'gestion_reservation';
?>

<!DOCTYPE html>
<html>

<head>
    <title>camping - gestion_reservation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/XzyCCqt/LOGO1.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <header>
        <?php 
        include("includes/header.php"); 
        require 'class/reservation_form.php';
        $modif_reservation = new reservation($db);
        $connexion = $db->connectDb();
        $infos = new camping_properties($db);
        ?>
    </header>
    <main class="main_gestion_reservation">
        <?php
        try
        {
            //CONNEXION BDD
            $connexion1=new PDO("mysql:host=localhost;dbname=camping",'root','');
            // DEFINITION MODE D'ERREUR PDO SUR EXCEPTION
            $connexion1->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
            //VARIABLE STOCKANT L'ID DE RESERVATION
            $id_booking=$_GET['id_reservation'];
            
            
            //RECUPERATION DES INFORMATIONS LIEES A LA RESERVATION
            $info_customer = $connexion1->prepare ("SELECT 
            reservations.id_utilisateur,
            utilisateurs.id_utilisateur, 
            utilisateurs.nom,
            utilisateurs.prenom,
            utilisateurs.num_tel,
            utilisateurs.email
            FROM 
            reservations,
            utilisateurs 
            WHERE reservations.id_reservation = $id_booking
            AND 
            reservations.id_utilisateur = utilisateurs.id_utilisateur
            ");
            //EXECUTION REQUETE
            $info_customer->execute();
            //RECUPERATION RESULTAT
            $resultat_info_customer = $info_customer->fetchAll(PDO::FETCH_ASSOC);
            
            
            //RECUPERATION DES INFORMATIONS LIEES A LA RESERVATION
            $info_reservation = $connexion1->prepare ("SELECT * FROM reservations WHERE id_reservation = $id_booking");
            //EXECUTION REQUETE
            $info_reservation->execute();
            //RECUPERATION RESULTAT
            $resultat_info_reservation = $info_reservation->fetchAll(PDO::FETCH_ASSOC);

            //RECUPERATION DES INFORMATIONS LIEES A LA RESERVATION
            $info_lieu = $connexion1->prepare ("SELECT * FROM detail_lieux WHERE id_reservation = $id_booking");
            //EXECUTION REQUETE
            $info_lieu->execute();
            //RECUPERATION RESULTAT
            $resultat_info_lieu = $info_lieu->fetchAll(PDO::FETCH_ASSOC);
            
            //RECUPERATION DES INFORMATIONS LIEES A LA RESERVATION
            $info_type = $connexion1->prepare ("SELECT * FROM  detail_types_emplacement WHERE id_reservation = $id_booking");
            //EXECUTION REQUETE
            $info_type->execute();
            //RECUPERATION RESULTAT
            $resultat_info_type = $info_type->fetchAll(PDO::FETCH_ASSOC);
            
            //RECUPERATION DES INFORMATIONS LIEES A LA RESERVATION
            $info_option = $connexion1->prepare ("SELECT * FROM  detail_options WHERE id_reservation = $id_booking");
            //EXECUTION REQUETE
            $info_option->execute();
            //RECUPERATION RESULTAT
            $resultat_info_option = $info_option->fetchAll(PDO::FETCH_ASSOC);
            
            //RECUPERATION DES INFORMATIONS LIEES A LA RESERVATION
            $info_prix = $connexion1->prepare ("SELECT * FROM  prix_detail WHERE id_reservation = $id_booking");
            //EXECUTION REQUETE
            $info_prix->execute();
            //RECUPERATION RESULTAT
            $resultat_info_prix = $info_prix->fetchAll(PDO::FETCH_ASSOC);
        
        }
        
        
        
        catch (PDOException $e) 
        {
        echo "Erreur : " . $e->getMessage();
        }

        ?>
        
        <section class="booking_details">
            <div class="reservation_facture">
           
            <h1>Facture réservation n°<?php echo $resultat_info_reservation[0]['id_reservation'] ?></h1><br/>
            
            <h3>Sardine's Camp</h3><br/>
            <address>
                <p>1 avenue de la Madrague 13008 Marseille</p>
                <a class="contact" href="tel:+330491919191">"tel:+330491919191"</a><br/>
                <a class="contact" href="mailto:hello@sardinescamp.com">hello@sardinescamp.com</a>
            </address>

            <br/>
                
            <h3> Informations client </h3><br/>
            <dl>
                <dt>Id utilisateur</dt>
                <dd><?php echo  $resultat_info_customer[0]['id_utilisateur'] ?></dd>
                
                <dt>Nom et Prénom</dt>
                <dd><?php echo  $resultat_info_customer[0]['prenom'].' '.$resultat_info_customer[0]['nom'] ?></dd>
                
                <dt>Numéro de téléphone</dt>
                <dd><?php echo  $resultat_info_customer[0]['num_tel'] ?></dd>
                
                <dt>Mail</dt>
                <dd><?php echo  $resultat_info_customer[0]['email'] ?></dd>
            </dl>
            
            <br/>
            
            <h3> Récapitulatif du séjour</h3><br/>
            <dl>
                <dt>Date de séjour</dt>
                <dd>Arrivée le : <?php echo $resultat_info_reservation[0]['date_debut'] ?> _ Départ le : <?php echo $resultat_info_reservation[0]['date_fin'] ?></dd><br/>
                
                <dt>Site réservé et tarif journalier</dt>
                <dd>
                    <?php foreach($resultat_info_lieu as $info_lieu){echo html_entity_decode($info_lieu['nom_lieu']).' _ '. $info_lieu['prix_journalier'].'€/j (1 emplacement)';}?>
                </dd><br/>
                
                <dt>Type(s) d'emplacement réservé(s)</dt>
                <dd>
                    <?php
                    foreach($resultat_info_type as $info_type)
                    {
                        echo html_entity_decode($info_type['nom_type_emplacement']).' ('.
                        $info_type['nb_emplacements_reserves'].' emplacement(s) réservé(s) ) <br/>';
                    }
                    ?>
                </dd><br/>
                
                <dt>Option(s) sélectionnée(s) et tarif</dt>
                <dd>
                    <?php 
                         foreach($resultat_info_option as $info_option)
                        {
                            echo html_entity_decode($info_option['nom_option']) .' '.
                            $info_option['prix_option'].' €/j <br/>';
                        }
                    ?>
                </dd>
            </dl>
            
            <br/>
            
            <h3>TOTAL</h3><br/>
            <dl>
                <dt>Total emplacement(s) réservé(s)</dt>
                <dd><?php echo $resultat_info_prix[0]['nb_emplacement'] ?></dd>
                <dt>Total tarif journalier emplacement(s)</dt>
                <dd><?php echo $resultat_info_prix[0]['prix_journalier'].' €' ?></dd>
                <dt>Total tarif journalier option(s) </dt>
                <dd><?php echo $resultat_info_prix[0]['prix_options'] .' €'?></dd>
                <dt>Total journée(s) réservée(s)</dt>
                <dd><?php echo $resultat_info_prix[0]['nb_jours'] ?></dd>
                <dt>Total coût séjour</dt>
                <dd id="total"><?php echo $resultat_info_prix[0]['prix_total'].' €' ?></dd>
            </dl>
            
            
            <button onclick="myFunction()"  class="button_print"><i class="fas fa-print"></i></button>
          
    
            <script>
            function myFunction() {
                window.print();
            }
            </script>
            
            <?php 
                                    /*$id_reservation = $resultat_info_reservation[0]['id_reservation'];
    
                                     $select_type_place = $connexion->prepare("SELECT nom_type_emplacement FROM detail_types_emplacement WHERE id_reservation=$id_reservation"); 
                                    $select_type_place ->execute();
                                    $selection_emplacement = $select_type_place->fetchAll();
                   
                                    var_dump($selection_emplacement);*/
                
                if($_SESSION['user']['is_admin'])
                {
                    

                   ?>
                
                    <section id="facture-container-resaform">
                    <?php
                    //var_dump($_POST);
                    $id_reservation = $resultat_info_reservation[0]['id_reservation'];
                    $id_utilisateur = $resultat_info_customer[0]['id_utilisateur'];
                    if (isset($_POST['submit'])) {
                        foreach ($_POST as $key => $value) {
                            if ($value != 'default') {
                                $q = $connexion->prepare("SELECT * FROM types_emplacement WHERE nom_type_emplacement = '$key'");
                                $q->execute();
                                $result2 = $q->fetch();
                                if ($result2 != false) {
                                    $type_emplacement_reserve = $result2['nom_type_emplacement'];
                                    $nombre_emplacement_reserve = $_POST[$result2['nom_type_emplacement']];
                                    $emplacements_reserves[$type_emplacement_reserve] = (int)$nombre_emplacement_reserve;
                                }
                            }
                        }
                        if (empty($type_emplacement_reserve)) {
                            $errors[] = "Aucun emplacement n'a été choisi.";
                            $message = new messages($errors);
                            echo $message->renderMessage();
                        } else {
                            foreach ($emplacements_reserves as $value) {
                                if (!isset($nombre_emplacements_total)) {
                                    $nombre_emplacements_total = 0;
                                }
                                $nombre_emplacements_total = $nombre_emplacements_total + $value;
                            }
                        }
                        if (empty($errors)) {
                            $modif_reservation_possible = $modif_reservation->checkReservation(
                                $_POST['lieu'],
                                $_POST['arrival'],
                                $_POST['departure'],
                                $nombre_emplacements_total
                            );

                            if ($modif_reservation_possible) {
                                $arrival = $_POST['arrival'];
                                $departure = $_POST['departure'];
                                $lieu = $_POST['lieu'];
  
                                // MISE A JOUR TABLE reservation
                                $request1 = $connexion->prepare(
                                    "UPDATE reservations SET date_debut=:date_debut, date_fin=:date_fin WHERE id_reservation = $id_reservation"
                                );
                                $request1->bindParam(':date_debut', $arrival, PDO::PARAM_STR);
                                $request1->bindParam(':date_fin', $departure, PDO::PARAM_STR);
                                $request1->execute();
                                $idresa = $id_reservation;


                                // MISE A JOUR TABLE detail_lieux
                                foreach ($infos->getLieux() as $value) {
                                    if ($value['nom_lieu'] == $lieu) {
                                        $q2 = $connexion1->prepare("SELECT prix_journalier FROM lieux WHERE nom_lieu= :lieu");
                                        $q2->bindParam(':lieu', $lieu, PDO::PARAM_STR);
                                        $q2->execute();
                                        $prix_journalier = $q2->fetch();
                                    }
                                }
                                $request2 = $connexion->prepare(
                                    "UPDATE detail_lieux SET nom_lieu=:nom_lieu, prix_journalier=:prix_journalier, id_reservation=:id_reservation WHERE id_reservation = $id_reservation "
                                );
                                $request2->bindParam(':nom_lieu', $lieu, PDO::PARAM_STR);
                                $request2->bindParam(':prix_journalier', $prix_journalier['prix_journalier'], PDO::PARAM_STR);
                                $request2->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
                                $request2->execute();
                                
                                
                                // MISE A JOUR TABLE detail_types_emplacement
                                foreach ($emplacements_reserves as $type_emplacement => $nombre_emplacement) {
                                    $select_type_place = $connexion->prepare("SELECT * FROM detail_types_emplacement WHERE id_reservation=$idresa"); 
                                    $select_type_place ->execute();
                                    $selection_emplacement = $select_type_place->fetchAll();
                                    
                                    
                                    
                                    if(in_array($selection_emplacement,$_POST['lieu']))
                                    {
                                        $request3 = $connexion->prepare(
                                        "UPDATE detail_types_emplacement SET nom_type_emplacement=:nom_type_emplacement, nb_emplacements_reserves =:nb_emplacements_reserves, id_reservation=:id_reservation WHERE id_reservation = $id_reservation"
                                    );
                                    $request3->bindParam(':nom_type_emplacement', $type_emplacement, PDO::PARAM_STR);
                                    $request3->bindParam(':nb_emplacements_reserves', $nombre_emplacement, PDO::PARAM_INT);
                                    $request3->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
                                    $request3->execute();
                                    }
                                    else
                                    {
                                        $request4 = $connexion->prepare(
                                        "INSERT INTO detail_types_emplacement (nom_type_emplacement, nb_emplacements_reserves, id_reservation) VALUES (:nom_type_emplacement,:nb_emplacements_reserves, :id_reservation)"
                                        );
                                        $request4->bindParam(':nom_type_emplacement', $type_emplacement, PDO::PARAM_STR);
                                        $request4->bindParam(':nb_emplacements_reserves', $nombre_emplacement, PDO::PARAM_INT);
                                        $request4->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
                                        $request4->execute();
                                    }
                                        
                                    
                                }

                                foreach ($_POST['option'] as $name_option) {
                                    $q3 = $connexion->prepare("SELECT * FROM options WHERE nom_option = :nom_option");
                                    $q3->bindParam(':nom_option', $name_option);
                                    $q3->execute();
                                    $options = $q3->fetch();
                                    $request5 = $connexion->prepare(
                                        "UPDATE detail_options SET nom_option=:nom_option, prix_option=:prix_option, id_reservation=:id_reservation WHERE id_reservation = $id_reservation"
                                    );
                                    $request5->bindParam(':nom_option', $name_option, PDO::PARAM_STR);
                                    $request5->bindParam(':prix_option', $options['prix_option'], PDO::PARAM_INT);
                                    $request5->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
                                    $request5->execute();
                                }
                                // MISE A JOUR TABLE prix_detail

                                //RECUPERE nombre de jours réservés
                                $nb_days = $connexion->prepare(
                                    "SELECT DATEDIFF(date_fin, date_debut) FROM reservations WHERE id_reservation = $id_reservation"
                                );
                                $nb_days->execute([$idresa]);
                                $nb_days = $nb_days->fetchAll();
                                $days = $nb_days[0][0] + 1;

                                //RECUPERE nombre total d'emplacements réservés
                                $emplacement = $connexion->prepare(
                                    "SELECT SUM(nb_emplacements_reserves) FROM detail_types_emplacement WHERE id_reservation = $id_reservation"
                                );
                                $emplacement->execute([$idresa]);
                                $emplacement = ($emplacement->fetchAll());
                                $nb_emp = $emplacement[0][0];

                                //RECUPERE prix journalier multiplié par le nb d'emplacements
                                $lieux = $connexion->prepare(
                                    "SELECT prix_journalier * $nb_emp FROM detail_lieux WHERE id_reservation = $id_reservation"
                                );
                                $lieux->execute([$idresa]);
                                $lieux = $lieux->fetchAll();
                                $price_day = $lieux[0][0];

                                //RECUPERE prix total des options choisies
                                $option = $connexion->prepare("SELECT SUM(prix_option) FROM detail_options WHERE id_reservation = $id_reservation");
                                $option->execute([$idresa]);
                                $option = ($option->fetchAll());
                                $price_option = $option[0][0];

                                //FONCTION cacul prix réservation
                                function facture($nb_jours, $operation, $total_jour)
                                {
                                    $calcul = $nb_jours * $total_jour;
                                    return $calcul;
                                }

                                $resultat = facture($nb_jours = $days, $operation = '*', $total_jour = ($price_day + $price_option));

                                //INSERTION finale
                                $request_total = $connexion->prepare(
                                    "UPDATE prix_detail SET nb_jours=:nb_jours, prix_total=:prix_total, id_reservation=:id_reservation WHERE id_reservation=$id_reservation )"
                                );
                                $request_total->bindParam(':prix_total', $resultat, PDO::PARAM_STR);
                                $request_total->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
                                $request_total->execute();
                                header('location:facturation.php?id_reservation=' . $id_reservation . '');
                            }
                        }
                    }
                    ?>
                    <h1 id="hello">Bienvenue @ <?php
                        echo $_SESSION['user']['firstname'] ?>!<br>Modification du séjour</h1>
                    <?php
                    if (!isset($_POST['Valider_date_lieu']) and empty($_POST)) {
                        ?>
                        <section id="facture-sub-form">
                            <form id="form_date_lieu" method="post" action="facturation.php?id_reservation=<?php echo $id_reservation?>">
                                <section id="facture-date-section">
                                    <label for="arrival">Date d'arrivée</label>
                                    <input type="date" name="arrival">
                                    <label for="departure">Date de départ</label>
                                    <input type="date" name="departure" id="departure">
                                    <br/><i>* Les réservations correspondent aux nuits</i>
                                </section>
                                <section id="section-lieu">
                                    <select name="lieu" id="" name="">
                                        <optgroup label="Choix du lieu">
                                            <option value="default" selected hidden>--Sélectionnez votre lieu--</option>
                                            <?php
                                            foreach ($infos->getLieux() as $lieu) { ?>
                                            <option value="<?= $lieu['nom_lieu'] ?>"><?= $lieu['nom_lieu'] ?></option>
                                            <?php
                                            } ?>
                                        </optgroup>
                                    </select>
                                    <button type="submit" name="Valider_date_lieu">Valider</button>
                                </section>
                            </form>
                        <?php
                        } else {
                        if (!empty($_POST['arrival']) and !empty($_POST['departure']) and !empty($_POST['lieu'])) {
                            $_SESSION['arrival'] = $_POST['arrival'];
                            $_SESSION['departure'] = $_POST['departure'];
                            $_SESSION['nom_lieu'] = $_POST['lieu'];
                        ?>
                        <section id="facture-sub-form1">
                            <form method="post" action="facturation.php?id_reservation=<?php echo $id_reservation?>">
                                <section id="date-section1">
                                    <label for="arrival">Date d'arrivée</label>
                                    <input id="arrival" type="date" name="arrival" value="<?= $_SESSION['arrival'] ?>" readonly>
                                    <label for="departure">Date de départ</label>
                                    <input id="departure" type="date" name="departure" value="<?= $_SESSION['departure'] ?>" readonly>
                                    <label for="lieu">Lieu</label>
                                    <input id="lieu" type="text" name="lieu" value="<?= $_SESSION['nom_lieu'] ?>" readonly>
                                </section>
                                <section id="type-section">
                                    <h2>Choisissez votre type d'emplacement</h2>
                                    <?php
                                    foreach ($infos->getLieux() as $lieu) { ?>
                                        <?php
                                        if ($lieu['nom_lieu'] == $_SESSION['nom_lieu']) {
                                            $test = $lieu['emplacements_disponibles'];
                                        }
                                    } ?>
                                    <?php
                                    foreach ($infos->getTypesEmplacement() as $type_emplacement) {
                                        $test2 = $type_emplacement['nb_emplacements'];
                                        $result = intval($test / $test2);
                                        if ($result >= 1) {
                                            ?>
                                            <select name="<?= $type_emplacement['nom_type_emplacement'] ?>">
                                                <option value="default">0 <?= $type_emplacement['nom_type_emplacement'] ?></option>
                                                <?php
                                                for (
                                                    $i = 1;
                                                    $i <= $result;
                                                    $i++
                                                ) {
                                                    $nom_emplacement = $type_emplacement['nom_type_emplacement'];
                                                    if (!isset($total_emplacement)) {
                                                        $total_emplacement = 0;
                                                    }
                                                    echo $total_emplacement = $i * (int)$type_emplacement['nb_emplacements'];
                                                    ?>
                                                    <option value="<?= $total_emplacement ?>"><?php
                                                        echo "$i $nom_emplacement" ?></option>
                                                    <?php
                                                } ?>
                                            </select>
                                            <?php
                                        }
                                    } ?>
                                </section>
                                <section id="option-section">
                                    <h2>Choisissez vos options durant votre séjour</h2>
                                    <?php
                                    foreach ($infos->getOptions() as $option) { ?>
                                        <section><input type="checkbox" id="<?= $option['id_option'] ?>" name="option[]"
                                               value="<?= $option['nom_option'] ?>">
                                        <label for="<?= $option['id_option'] ?>"><?= $option['nom_option'] ?>
                                            à <?= $option['prix_option'] ?>
                                            €/jour</label>
                                        </section>
                                        <?php
                                    } ?>
                                </section>
                                <section id="but-form"><button id="form-button" type="submit" name="submit">Réserver</button></section>
                            </form>
                        </section>
                            <?php
                        } else {
                            $errors[] = "Tous les éléments doivent être seléctionnés.";
                            $message = new messages($errors);
                            echo $message->renderMessage();
                        }
                    } ?>
                      </section>
                    </section>


                    <?php

                        
                    }

                    ?>
            
             
            
             </div>
        </section>
        
        
    </main>
    <footer>
        <?php include("includes/footer.php") ?>
    </footer>
</body>