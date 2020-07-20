
       <?php 
       

        $email = $_SESSION['user']['email'];

        $request_id = $db->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = ? ");
        $request_id->execute([$_SESSION['user']['email']]);
        $result_id = ($request_id->fetchAll());
        //var_dump($result_id[0]['id_utilisateur']);

        if (isset($_POST['submit'])){

        if (isset($_POST['arrival']) && isset($_POST['departure']) && isset($_POST['lieu']) && isset($_POST['camping']) && isset($_POST['tente'])){

        $arrival = $_POST['arrival'];
        $departure = $_POST['departure'];
        $lieu = $_POST['lieu'];
        //var_dump($lieu);
        $nb_camping = $_POST['camping'];
        $nb_tente = $_POST['tente'];
        //var_dump($nb_camping);
        //var_dump($nb_tente);

        $emplacement='camping-car';
        $emplacement2='tente';


        // check pour vérifier les dispos par emplacements et par dates

        // requête pour insérer infos dans la table reservations
        $request1 = $db->prepare(
        "INSERT INTO reservations (date_debut, date_fin, id_utilisateur) VALUES (:date_debut, :date_fin, :id_utilisateur)"
        );
        $request1->bindParam(':date_debut', $arrival, PDO::PARAM_STR);
        $request1->bindParam(':date_fin', $departure, PDO::PARAM_STR);
        $request1->bindParam(':id_utilisateur', $result_id[0]['id_utilisateur'], PDO::PARAM_INT);
        $request1->execute();
        $idresa = $db->lastInsertId();
        //var_dump ($idresa);


        // requête pour insérer la resa dans la table detail lieux
        $request2 = $db->prepare(
        "INSERT INTO detail_lieux (nom_lieu, prix_journalier, id_reservation) VALUES (:nom_lieu, :prix_journalier, :id_reservation)"
        );
        $request2->bindParam(':nom_lieu', $lieu, PDO::PARAM_STR);
        $request2->bindParam(':prix_journalier', $prix_jr, PDO::PARAM_STR);
        $request2->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
        $request2->execute();
    
        // requête pour insérer les resas de camping-car dans la table detail types emplacement
        $request3 = $db->prepare(
        "INSERT INTO detail_types_emplacement (nom_type_emplacement, nb_emplacements_reserves, id_reservation) VALUES (:nom_type_emplacement,:nb_emplacements_reserves, :id_reservation)"
        );
        $request3->bindParam(':nom_type_emplacement', $emplacement, PDO::PARAM_STR);
        $request3->bindParam(':nb_emplacements_reserves', $nb_camping, PDO::PARAM_INT);
        $request3->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
        $request3->execute();

        // requête pour insérer les resas de tentes dans la table detail types emplacement
        $request4 = $db->prepare(
        "INSERT INTO detail_types_emplacement (nom_type_emplacement, nb_emplacements_reserves, id_reservation) VALUES (:nom_type_emplacement,:nb_emplacements_reserves, :id_reservation)"
        );
        $request4->bindParam(':nom_type_emplacement', $emplacement2, PDO::PARAM_STR);
        $request4->bindParam(':nb_emplacements_reserves', $nb_tente, PDO::PARAM_INT);
        $request4->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
        $request4->execute();
  
  
          if (isset($_POST['option'])){

            //var_dump($_POST['option']);

              foreach(($_POST['option']) as $key=> $val) {

                $opt = $_POST['option'][0];
                //var_dump($opt)
                //var_dump($val);
                

                $infos_options = $db->prepare("SELECT * FROM options WHERE nom_option = '".$val."'");
                $infos_options->execute();
                $infos_options = ($infos_options->fetchAll());
                
                //var_dump($infos_options);
                //$infos = $infos_options[0]['id_option'];
                //var_dump($infos_options[0]['id_option']);
                //var_dump($infos_options[0]['nom_option']);
                //var_dump($infos_options[0]['prix_option']);
                $name_option = $infos_options[0]['nom_option'];
                //var_dump($name_option);
                $p_option = $infos_options[0]['prix_option'];
                //var_dump($p_option);

                $request5 = $db->prepare(
                  "INSERT INTO detail_options (nom_option, prix_option, id_reservation) VALUES (:nom_option,:prix_option,:id_reservation)"
                );
                $request5->bindParam(':nom_option', $name_option, PDO::PARAM_STR);
                $request5->bindParam(':prix_option', $p_option, PDO::PARAM_INT);
                $request5->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
                $request5->execute();
                }

  

          }


      //Récupération des infos de la réservation avant de les insérer dans la table prix_detail
      //requete pour recupérer le nombre de jours réservés
      $nb_days = $db->prepare("SELECT DATEDIFF(date_fin, date_debut) FROM reservations WHERE id_reservation = ?");
      $nb_days->execute([$idresa]);
      $nb_days = ($nb_days->fetchAll());
      //var_dump($nb_days);
      $days = $nb_days[0][0];
      //var_dump($days);

      //requete pour récupérer le nb total d'emplacements réservés
      $emplacement = $db->prepare("SELECT SUM(nb_emplacements_reserves) FROM detail_types_emplacement WHERE id_reservation = ?");
      $emplacement->execute([$idresa]);
      $emplacement = ($emplacement->fetchAll());
      //var_dump($emplacement);
      $nb_emp = $emplacement[0][0];

      //requete pour récupérer le prix journalier multiplié par le nb d'emplacements
      $lieux = $db->prepare("SELECT prix_journalier * $nb_emp FROM detail_lieux WHERE id_reservation = ?");
      $lieux->execute([$idresa]);
      $lieux = ($lieux->fetchAll());
      //var_dump($lieux);
      $price_day = $lieux[0][0];
      //var_dump($price_day);


      //requete pour récupérer le prix total des options choisies
      $option = $db->prepare("SELECT SUM(prix_option) FROM detail_options WHERE id_reservation = ?");
      $option->execute([$idresa]);
      $option = ($option->fetchAll());
      //var_dump($option);
      $price_option = $option[0][0];
      //var_dump($price_option = $option[0][0]);

      //function calcul prix de la resa
      function facture($nb_jours, $operation, $total_jour){
        $calcul = $nb_jours * $total_jour;
        return $calcul;
      }
      $resultat = facture($nb_jours = $days, $operation = '*', $total_jour = ($price_day + $price_option));
      echo $resultat;


      //requete pour inséerer les infos de la resa dans la table prix_detail
      $request_total = $db->prepare(
        "INSERT INTO prix_detail (nb_emplacement, prix_journalier, prix_options, nb_jours, prix_total, id_reservation) VALUES (:nb_emplacement,:prix_journalier,:prix_options,:nb_jours, :prix_total, :id_reservation)"
      );
      $request_total->bindParam(':nb_emplacement', $nb_emp, PDO::PARAM_INT);
      $request_total->bindParam(':prix_journalier', $price_day, PDO::PARAM_STR);
      $request_total->bindParam(':prix_options', $price_option, PDO::PARAM_STR);
      $request_total->bindParam(':nb_jours', $days, PDO::PARAM_INT);
      $request_total->bindParam(':prix_total', $resultat, PDO::PARAM_STR);
      $request_total->bindParam(':id_reservation', $idresa, PDO::PARAM_INT);
      $request_total->execute();

    } 

  }
               
       
       ?>