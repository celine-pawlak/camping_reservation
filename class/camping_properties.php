<?php


class camping_properties
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

    public function getLieux()
    {
        $q = $this->db->prepare("SELECT * FROM lieux");
        $q->execute();
        return $q->fetchAll();
    }

    public function getTypesEmplacement()
    {
        $q = $this->db->prepare("SELECT * FROM types_emplacement");
        $q->execute();
        return $q->fetchAll();
    }

    public function getOptions()
    {
        $q = $this->db->prepare("SELECT * FROM options");
        $q->execute();
        return $q->fetchAll();
    }

}

$test = new camping_properties();
var_dump($test->getLieux());
var_dump($test->getTypesEmplacement());
var_dump($test->getOptions());


?>

<section>
    <select name="camping">
        <option value="">--camping-car--</option>
        <option value="0" selected>0 camping-car</option>
        <option value="2">1 camping-car</option>
        <option value="4">2 camping-car</option>
    </select>
</section>

<section>
    <select name="tente">
        <option value="">--tente--</option>
        <option value="0" selected>0 tente</option>
        <option value="1">1 tente</option>
        <option value="2">2 tentes</option>
        <option value="3">3 tentes</option>
        <option value="4">4 tentes</option>
    </select>
</section>

<?php
$infos = new camping_properties;
?>
<section>
    <select name="lieu" id="">
        <option value="">--Sélectionnez votre lieu--</option>
        <?php
        foreach ($infos->getLieux() as $lieu) { ?>
            <option value="<?= $lieu['nom_lieu'] ?>"><?= $lieu['nom_lieu'] ?></option>
            <?php
        } ?>
    </select>
</section>
<section>
        <?php
        foreach ($infos->getOptions() as $option) { ?>
            <input type="checkbox" id="<?= $option['id_option'] ?>" name="option[]" value="<?= $option['id_option']?>">
            <label for="<?= $option['id_option'] ?>"><?= $option['nom_option'] ?></label>
            <?php
        } ?>
</section>

<section>
    <?php
    foreach ($infos->getLieux() as $lieu){ ?>
        <select>
            
        </select>
   <?php }
    ?>
</section>


<script>
    function showDiv(oEvent){
        var sVal = this.value,
            sIdCible = 'register-'+sVal+'-form',
            oForm = this.form,
            sClass = "select-cible-show",
            //Je recupère les select-cible qui sont dans le form
            // je ne parcours pas tout le DOM en faissant document....
            aDivs = oForm.getElementsByClassName("select-cible");
        for(var i = 0; i < aDivs.length; i++){
            var oEle = aDivs[i];
            if(oEle.id == sIdCible){
                oEle.classList.add(sClass)
            }else{
                oEle.classList.remove(sClass)
            }
        }
    }
    //Quand le DOm est dispo
    document.addEventListener('DOMContentLoaded',function(){
        var oForm = document.forms['myForm'];
        oForm['status-select'].addEventListener('change',showDiv);
    });
</script>

<style>
    .select-cible{
        display:none
    }
    .select-cible-show{
        display:block
    }
</style>
<!--
https://openclassrooms.com/forum/sujet/afficher-contenu-si-option-de-select-selectionnee
-->
<h1>Afficher contenu si option de select sélectionnée (Javascript)</h1>
<form class="default-form" id="myForm" action="/handball_club_manager_V2/register.php" method="POST">
    <select class="default-select" name="status-select">
        <optgroup label="Type d'inscription">
            <option value="default" selected hidden>Choisissez votre statut</option>
            <option value="club">Inscription Club</option> <!-- OPTION 1 -->
            <option value="user">Inscription Utiilisateur</option> <!-- OPTION 2 -->
        </optgroup>
    </select>
    <div id="register-club-form" class="select-cible"> <!-- A afficher si OPTION 1 sélectionnée -->
        <div class="default-fieldset">
            <input class="club-name" type="text" placeholder="Nom du club">
        </div>
        <div class="default-fieldset">
            <input class="dep-code" type="text" placeholder="Numéro Département (5 chiffres)" maxlength="5">
            <input class="dep-name" type="text" placeholder="Nom Département">
        </div>
        <div class="default-fieldset">
            <input class="dep-committee" type="text" placeholder="Comité départemental">
            <input class="reg-league" type="text" placeholder="Ligue régionale">
            <input class="nat-federation" type="text" placeholder="Fédération">
        </div>
        <div class="default-fieldset">
            <input class="office-location" type="text" placeholder="Siège social">
        </div>
        <div class="default-fieldset">
            <input class="hall1-name" type="text" placeholder="Salle 1">
            <input class="hall2-name" type="text" placeholder="Salle 2 (Optionnel)">
            <input class="hall3-name" type="text" placeholder="Salle 3 (Optionnel)">
        </div>
        <div class="default-fieldset">
            <input type="creation-date" type="text" placeholder="Date de création">
        </div>
        <input class="submit-input" type="submit" value="Inscription">
    </div>
    <div id="register-user-form" class="select-cible"> <!-- A afficher si OPTION 2 sélectionnée -->
        <div class="default-fieldset">
            <input class="club-name" type="url" placeholder="Lien d'invitation">
        </div>
        <input class="submit-input" type="submit" value="Inscription">
    </div>
</form>