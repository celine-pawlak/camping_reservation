<?php 

        //TENTATIVE CONNEXION BDD
        try
        {
            //CONNEXION BDD
            $connexion=new PDO("mysql:host=localhost;dbname=camping",'root','');
            // DEFINITION MODE D'ERREUR PDO SUR EXCEPTION
            $connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
            //SELECTION DE TOUTES LES DONNEES RESERVATION
            $data_users = $connexion->prepare("SELECT * FROM utilisateurs");
            //EXECUTION REQUETE
            $data_users->execute();
            //RECUPERATION RESULTAT
            $resultat_data_users = $data_users->fetchAll(PDO::FETCH_ASSOC);
            
            //AJOUT NOUVELLE RESERVATION
                
            
            //SI ON APPUIS SUR DELETE RESERVATION
                    if (isset($_POST['delete_reservation'])) 
                    {
                        //DEFINITION VARIABLE ID_HIDDEN
                        $reservation_id = htmlentities(trim($_POST['reservation_id_hidden']));

                        //SUPPRESSION DES DONNEES UTILISATEUR EN BDD
                        $reservation_delete = $connexion->prepare("DELETE FROM reservations WHERE id_reservation = $reservation_id ");
                        //EXECUTION REQUETE
                        $reservation_delete->execute();

                        //RAFRAICHISSEMENT PAGE
                        header("location:admin.php");
                    }

        }

        catch (PDOException $e) 
        {
        echo "Erreur : " . $e->getMessage();
        }

?>