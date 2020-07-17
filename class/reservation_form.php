<?php
require 'messages.php';

class reservation
{
    public $db;

    public function __construct($host = "localhost", $username = "root", $password = "", $dbname = "camping")
    {
        try {
            $this->db = new PDO('mysql:dbname=' . $dbname . ';host=' . $host . '', $username, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    //dates
    public function checkDates($lieu, $date_debut, $date_fin)
    {
        $date_debut_jour = idate('d',strtotime($date_debut));
        $date_debut_mois = idate('m',strtotime($date_debut));
        $date_debut_annee = idate('Y',strtotime($date_debut));

        $date_fin_jour = idate('d',strtotime($date_fin));
        $date_fin_mois = idate('m',strtotime($date_fin));
        $date_fin_annee = idate('Y',strtotime($date_fin));

        $debut_date = mktime(0, 0, 0, $date_debut_mois, $date_debut_jour, $date_debut_annee);
        $fin_date = mktime(0, 0, 0, $date_fin_mois, $date_fin_jour, $date_fin_annee);

        for($i = $debut_date; $i <= $fin_date; $i+=86400)
        {
            $date = date("Y-m-d",$i);
            $emplacements_dispo_selon_periode[$date] = self::HowManyEmplacementAvailableForADay($lieu,$date);
        }
        foreach ($emplacements_dispo_selon_periode as $key=>$value) {
            if ($value != null){
                return $emplacements_dispo_selon_periode;
            }
        }
        $date_debut = date('d/m/Y',strtotime($date_debut));
        $date_fin = date('d/m/Y',strtotime($date_fin));
        $errors[] = "Il n'y a aucun emplacement disponible entre le $date_debut et le $date_fin à $lieu";
        $message = new messages($errors);
        echo $message->renderMessage();


    }

    public function HowManyEmplacementAvailableForADay($lieu, $day_check)
    {
        $q = $this->db->prepare(
            "SELECT reservations.id_reservation FROM reservations, detail_lieux WHERE reservations.date_debut <= :day_check AND :day_check <= reservations.date_fin AND detail_lieux.nom_lieu = :nom_lieu AND detail_lieux.id_reservation = reservations.id_reservation"
        );
        $q->bindParam(':day_check', $day_check, PDO::PARAM_STR);
        $q->bindParam(':nom_lieu', $lieu, PDO::PARAM_STR);
        $q->execute();
        $reservation_on_same_day = $q->fetchAll();
        foreach ($reservation_on_same_day as $key => $value) {
            $q3 = $this->db->prepare(
                "SELECT nb_emplacements_reserves FROM detail_types_emplacement WHERE id_reservation = :id_reservation"
            );
            $q3->bindParam(':id_reservation', $reservation_on_same_day[$key]['id_reservation'], PDO::PARAM_INT);
            $q3->execute();
            $liste_nb_emplacements_reserves = $q3->fetchAll();
            foreach ($liste_nb_emplacements_reserves as $key => $value) {
                if (!isset($nb_emplacements_reserves_in_a_day)) {
                    $nb_emplacements_reserves_in_a_day = 0;
                }
                $nb_emplacements_reserves_in_a_day = $nb_emplacements_reserves_in_a_day + $liste_nb_emplacements_reserves[$key]['nb_emplacements_reserves'];
            }
        }
        $q2 = $this->db->prepare("SELECT emplacements_disponibles FROM lieux WHERE nom_lieu = :nom_lieu");
        $q2->bindParam(':nom_lieu', $lieu, PDO::PARAM_STR);
        $q2->execute();
        $emplacements_max = $q2->fetch();
        if (!isset($nb_emplacements_reserves_in_a_day)) {
            $nb_emplacements_reserves_in_a_day = 0;
        }
        $emplacements_disponibles = $emplacements_max[0] - $nb_emplacements_reserves_in_a_day;
        if ($emplacements_disponibles ==0){
            return null;
        }
        else return $emplacements_disponibles;
    }
}

$test = new reservation;
var_dump($test->checkDates('Les Pins','2020-07-24','2020-07-25'));
/*$test->HowManyEmplacementAvailableForADay('Les Pins', '2020-07-24');*/