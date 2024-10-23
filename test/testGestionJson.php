<!-- -------------------------------------------------------------
//TEST UNITAIRE FONCTIONALITÉ GESTION JSON
<div id="contenu">
-->
<h2>Test unitaire - résultats insertion / update des oeuvres du Json</h2>
<div id="contenu">
<br>
<form name="formTestJson" method="get">
    <input type="submit" name="testJson" value="Tester">
</form>
<?php
    $oeuvre = new Oeuvre();

    if (isset($_GET["testJson"])) {
        $oeuvre->updaterOeuvresVille();
        $date = $oeuvre->getDateDernierUpdate();
    }
    $oeuvre->afficherTestJson();
    if (!empty($date)) {
        echo "<br>La dernière mise à jour a été effectuée le " . $date["dateDernierUpdate"] . " à " . $date["heureDernierUpdate"];
    }
?>
</div>





