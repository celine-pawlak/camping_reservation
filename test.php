<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<header>
    <?php
    include("includes/header.php") ?>
</header>
<?php

$test = new camping_properties();
var_dump($test->getLieux());
var_dump($test->getTypesEmplacement());
var_dump($test->getOptions());

$infos = new camping_properties;
?>

<script type="text/javascript">

    function showDiv(oEvent) {
        var sVal = this.value,
            sIdCible = 'register-' + sVal + '-form',
            oForm = this.form,
            sClass = "select-cible-show",
            //Je recupère les select-cible qui sont dans le form
            // je ne parcours pas tout le DOM en faissant document....

            aDivs = oForm.getElementsByClassName("select-cible");
        for (var i = 0; i < aDivs.length; i++) {
            var oEle = aDivs[i];
            if (oEle.id == sIdCible) {
                oEle.classList.add(sClass)
            } else {
                oEle.classList.remove(sClass)
            }
        }
    }

    //Quand le DOm est dispo
    document.addEventListener('DOMContentLoaded', function () {
        var oForm = document.forms['myForm'];
        oForm['status-select'].addEventListener('change', showDiv);
    });
</script>

<style>
    .select-cible {
        display: none;
    }

    .select-cible-show {
        display: block;
    }
</style>

<form action="" method="post" id="myForm">
    <select name="lieu" id="" name="status-select">
        <optgroup label="Choix du lieu">
            <option value="default" selected hidden>--Sélectionnez votre lieu--</option>
            <?php
            foreach ($infos->getLieux() as $lieu) { ?>
                <option value="<?= $lieu['nom_lieu'] ?>"><?= $lieu['nom_lieu'] ?></option>
                <?php
            } ?>
        </optgroup>
    </select>
    <div>
        <?php
    foreach ($infos->getOptions() as $option) { ?>
        <input type="checkbox" id="<?= $option['id_option'] ?>" name="option[]" value="<?= $option['id_option'] ?>">
        <label for="<?= $option['id_option'] ?>"><?= $option['nom_option'] ?></label>
        <?php
        }  ?>
    </div>

    <div>
        <?php
        foreach ($infos->getLieux() as $lieu) { ?>
            <?php
            $test = $lieu['emplacements_disponibles'];
            ?>
            <div id="register-<?= $lieu['nom_lieu'] ?>-form" class="select-cible">
                <?php
                foreach ($infos->getTypesEmplacement() as $type_emplacement) {
                    $test2 = $type_emplacement['nb_emplacements'];
                    $result = intval($test / $test2);
                    ?>
                    <div class="default-fieldset">
                        <select name="" id="">
                            <?php
                            for ($i = 1; $i <= $result; $i++) {
                                $nom_emplacement = $type_emplacement['nom_type_emplacement'];
                                ?>
                                <option value=""><?php
                                    echo "$i $nom_emplacement" ?></option>
                                <?php
                            } ?>
                        </select>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</form>

</body>
</html>

