<h2>Test unitaire - ajout oeuvre BDD</h2>
<div id="contenu">
<?php
    $oeuvre = new Oeuvre();
    $arrondissement = new Arrondissement();
     $categorie = new Categorie();
    
    $idOeuvre= "";
    $arrondissementsBDD = $arrondissement->getAllArrondissements();
    $categoriesBDD = $categorie->getAllCategories('FR');
  
 

    if (isset($_GET["testajoutOeuvre"])) {      
           if (!empty($_GET["titreAjout"]) && !empty($_GET["prenomArtisteAjout"]) && !empty($_GET["adresseAjout"]) && !empty($_GET["descriptionAjout"]) && !empty($_GET["nomArtisteAjout"])  && !empty($_GET["selectArrondissement"])  && !empty($_GET["selectCategorie"])){
            $oeuvre->ajouterOeuvrePourTest($_GET['titreAjout'], $_GET['adresseAjout'], $_GET['prenomArtisteAjout'], $_GET['nomArtisteAjout'], $_GET['descriptionAjout'], $_GET["selectCategorie"], $_GET["selectArrondissement"], true, 'FR');   
                $idOeuvre = $oeuvre->getIdOeuvreByTitreandAdresse($_GET['titreAjout'],  $_GET['adresseAjout']);//aller chercher id oeuvre insérée
       
     }
         else {
            echo "ne laissez rien en blanc";
        }
    }    
?>   
    
    <form method="get" name="formTestsuppOeuvre" enctype="multipart/form-data">                
                <input type='text' name='titreAjout' value="" placeholder="Titre de l'oeuvre (si connu)"/>  
                <input type='text' name='prenomArtisteAjout' value="" placeholder="Prénom de l'artiste (si connu)"/>
                <input type='text' name='nomArtisteAjout' value="" placeholder="Nom de l'artiste (si connu)"/>
                <input type='text' name='adresseAjout' value="" placeholder="Adresse (obligatoire)"/>   
                <textarea name='descriptionAjout' placeholder="Description (obligatoire)"></textarea>
                <select name="selectArrondissement">
                    <option value="">Choisir un arrondissement</option>
                    <?php
                        foreach ($arrondissementsBDD as $arrondissement) {
                            echo "<option value='".$arrondissement["idArrondissement"]."'>".$arrondissement["nomArrondissement"];
                        }
                        echo "</select>";
                    ?>
                </select><br>
                <select name="selectCategorie">
                    <option value="">Choisir une catégorie</option>
                    <?php
                        foreach ($categoriesBDD as $categorie) {
                            echo "<option value='".$categorie["idCategorie"]."'>".$categorie["nomCategorieFR"];
                        }
                        echo "</select>";
                    ?>
                </select>
                <input  type='submit' name='testajoutOeuvre' value='Ajouter'>
            </form>
</div>