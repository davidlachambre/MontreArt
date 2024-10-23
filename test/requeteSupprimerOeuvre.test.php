<h2>Test unitaire - suppresion oeuvre BDD</h2>
<div id="contenu">
<?php

    $oeuvre = new Oeuvre();
    
    if (isset($_GET["testsuppOeuvre"])) {
        if (!empty($_GET["selectOeuvre"])) {
            $oeuvre->supprimerOeuvre($_GET["selectOeuvre"]);
        }
        else {
            echo "aucune oeuvre sélectionnée";
        }
    }
    $oeuvresBDD = $oeuvre->getAllOeuvres();
?>
    <form name="formTestsuppOeuvre" method="get">
        <select name="selectOeuvre">
            <option value="">choisir une oeuvre à supprimer</option>
            <?php
            foreach ($oeuvresBDD as $oeuvreBDD) {
                echo "<option value='".$oeuvreBDD["idOeuvre"]."'>".$oeuvreBDD["titre"]."</option>";
            }
            ?>
        </select>
        <input type="submit" name="testsuppOeuvre" value="supprimer">
    </form>
</div>