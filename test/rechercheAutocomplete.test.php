<h2>Test unitaire - recherche autocomplete</h2>
<div id="contenu">
<?php

    if (isset($_GET['testAutocomplete'])) {
        
        if (isset($_GET["titre"]) && $_GET["titre"] != "") {
            $oeuvre = new Oeuvre();
            $data =  $oeuvre->chercheParTitre($_GET['keyword']);
            echo "recherche par titre :<br>";
            var_dump($data);
            echo "<br><br><br>";
        }
        if (isset($_GET["artiste"]) && $_GET["artiste"] != "") {
            $artiste = new Artiste();
            $data =  $artiste->chercheParArtiste($_GET['keyword']);
            echo "recherche par artiste :<br>";
            var_dump($data);
            echo "<br><br><br>";
        }
    }
    
?>
    <form name="formTestAutocomplete" method="get">
        <input type="text" name="titre" placeholder="par titre">
        <input type="text" name="artiste" placeholder="par artiste">
        <input type="submit" name="testAutocomplete" value="Tester">
    </form>
</div>