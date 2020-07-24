<?php
//Ajout d'un commentaire vérifications

function addComment($note, $titre, $avis, $id_user, $id_reservation)
{
    $db = new Database();
    $connexion = $db->connectDb();

    //verification note
    if ($note < 0 or $note > 5) {
        $errors[] = "La note doit être comprise entre 0 et 5";
    }
    //verification titre
    if (strlen($avis) < 3 or strlen($titre) > 50) {
        $errors[] = "Le titre doit comporter entre 3 et 50 caractères";
    }
    //veridication avis
    if (strlen($avis) < 10 or strlen($avis) > 500) {
        $errors[] = "L'avis doit comporter entre 10 et 500 caractères";
    }
    if (empty($errors)) {
        $date = date('Y-m-d');
        echo $date;
        $q = $connexion->prepare(
            "INSERT INTO avis (note_sejour, titre_avis, texte_avis, post_date, id_utilisateur, id_reservation) VALUES (:note_sejour, :titre_avis, :texte_avis, :post_date, :id_utilisateur, :id_reservation)"
        );
        $q->bindParam(':note_sejour', $note, PDO::PARAM_INT);
        $q->bindParam(':titre_avis', $titre, PDO::PARAM_STR);
        $q->bindParam(':texte_avis', $avis, PDO::PARAM_STR);
        $q->bindParam(':post_date', $date, PDO::PARAM_STR);
        $q->bindParam(':id_utilisateur', $id_user, PDO::PARAM_INT);
        $q->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
        $q->execute();
    } else {
        $message = new messages($errors);
        echo $message->renderMessage();
    }
}

function viewComment($id_avis)
{
    $db = new Database();
    $connexion = $db->connectDb();
    //récupération avis
    $q = $connexion->prepare("SELECT * FROM avis WHERE id_avis = :id_avis");
    $q->bindParam(':id_avis', $id_avis, PDO::PARAM_INT);
    $q->execute();
    $avis = $q->fetch();
    //récupération réservation
    $reservation = $avis['id_reservation'];
    $q2 = $connexion->prepare(
        "SELECT reservations.date_debut,
                reservations.date_fin,
                utilisateurs.nom,
                utilisateurs.prenom,
                utilisateurs.avatar
                FROM reservations, utilisateurs
                WHERE reservations.id_reservation = :reservation
                AND utilisateurs.id_utilisateur = reservations.id_utilisateur"
    );
    $q2->bindParam(':reservation', $reservation, PDO::PARAM_INT);
    $q2->execute();
    $other_infos_from_reservation = $q2->fetch();
    ?>
    <div>
        <div> <!-- utilisateur -->
            <img src="<?= $other_infos_from_reservation['avatar'] ?>"
                 alt="Avatar de <?= $other_infos_from_reservation['nom'] ?>"
                 width='30' height='30'>
            <p><?= $other_infos_from_reservation['nom'] ?></p>
        </div>
        <div><!-- avis -->
            <div>
                <p><?= $avis['note_sejour'] ?>/5</p>
                <p>Avis publié le <?= $avis['post_date'] ?></p>
            </div>
            <p><?= $avis['titre_avis'] ?></p>
            <p><?= $avis['texte_avis'] ?></p>
            <p>A séjourné du <?= $other_infos_from_reservation['date_debut'] ?>
                au <?= $other_infos_from_reservation['date_fin'] ?></p>
        </div>
    </div>
    <?php
}
