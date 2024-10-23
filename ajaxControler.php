<?php
/**
 * Controlleur AJAX. Ce fichier est la porte d'entrée des requêtes AJAX
 * @author Jonathan Martel
 * @author David Lachambre
 * @author Philippe Germain
 * @version 1.0
 * @update 2016-01-23
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 */
require_once("./config.php");
	
$oCookie = new Cookie();
$langueAffichage = $oCookie->getLangue();

// Mettre ici le code de gestion de la requête AJAX 
switch ($_GET['rAjax']) {//requête
    case 'googleMap':
        googleMap();
        break;
    case 'googleMapTrajet':
        googleMapTrajet($lat,$lng);
        break;
    case 'visiteOeuvres':
        visiteOeuvres();
        break;        
    case 'autoComplete':
        autoComplete();
        break;
    case 'afficherSelectRecherche':
        afficherSelectRecherche();
        break;
    case 'afficherBoutonRecherche':
        afficherBoutonRecherche();
        break;
    case 'afficherSelectRechercheMobile':
        afficherSelectRechercheMobile();
        break;
    case 'afficherBoutonRechercheMobile':
        afficherBoutonRechercheMobile();
        break;
    case 'ajouterCategorie':
        ajouterCategorie();
        break;
    case 'supprimerCategorie':
        supprimerCategorie();
        break;
    case 'ajouterOeuvre':
        ajouterOeuvre();
        break;
    case 'recupererIdOeuvre':
        recupererIdOeuvre();
        break;
    case 'ajouterPhoto':
        ajouterPhoto();
        break;
    case 'supprimerOeuvre':
        supprimerOeuvre();
        break;
    case 'afficherFormModif':
        afficherFormModif();
        break;
    case 'modifierOeuvre':
        modifierOeuvre();
        break;
    case 'modifierOeuvreSoumise':
        modifierOeuvreSoumise();
        break;
    case 'modifierArtisteSoumis':
        modifierArtisteSoumis();
        break;
    case 'modifierCommentaireSoumis':
        modifierCommentaireSoumis();
        break;
    case 'updateOeuvresVille':
        updateOeuvresVille();
        break;
    case 'updateDate':
        updateDate();
        break;
    case 'recupererCategories':
        recupererCategories();
        break;
    case 'recupererArrondissements':
        recupererArrondissements();
        break;
    case 'recupererOeuvres':
        recupererOeuvres();
        break;
    case 'recupererUneOeuvre':
        recupererUneOeuvre();
        break;
    case 'recupererUnePhoto':
        recupererUnePhoto();
        break;
    case 'recupererUnCommentaire':
        recupererUnCommentaire();
        break;
    case 'accepterSoumissionOeuvre':
        accepterSoumissionOeuvre();
        break;
    case 'accepterSoumissionPhoto':
        accepterSoumissionPhoto();
        break;
    case 'accepterSoumissionCommentaire':
        accepterSoumissionCommentaire();
        break;
    case 'refuserSoumissionOeuvre':
        refuserSoumissionOeuvre();
        break;
    case 'refuserSoumissionPhoto':
        refuserSoumissionPhoto();
        break;
    case 'refuserSoumissionCommentaire':
        refuserSoumissionCommentaire();
        break;
    case 'updateLiensApprobOeuvres':
        updateLiensApprobOeuvres();
        break;
    case 'updateLiensApprobPhotos':
        updateLiensApprobPhotos();
        break;
    case 'updateLiensApprobCommentaires':
        updateLiensApprobCommentaires();
        break;
    case 'connexion':
        connexion();
        break;
	 case 'connexionNouveau':
        connexionNouveau();
        break;
    case 'deconnexion':
        deconnexion();
        break;
     case 'recupererInfoUtilisateur':
        recupererInfoUtilisateur();
        break;    
    case 'modifierUtilisateur':
        modifierUtilisateur();
        break;   
    case 'ajouterPhotoUtilisateur':
        ajouterPhotoUtilisateur();
        break;          
}

/* --------------------------------------------------------------------
============================ PAGE GESTION =============================
-------------------------------------------------------------------- */

/**
* @brief Fonction qui ajoute la catégorie soumise par un administrateur
* @access public
* @author David Lachambre
* @return void
*/
function ajouterCategorie () {
    
    $categorie = new Categorie();
    $msgErreurs = $categorie->ajouterCategorie($_POST["categorieFr"], $_POST["categorieEn"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui supprime la catégorie soumise par un administrateur
* @access public
* @author David Lachambre
* @return void
*/
function supprimerCategorie () {
    
    $categorie = new Categorie();
    $msgErreurs = $categorie->supprimerCategorie($_POST["idCategorie"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère toutes les catégories de la BDD.
* @access public
* @author David Lachambre
* @return void
*/
function recupererCategories () {

    $categorie = new Categorie();
    $categories = $categorie->getAllCategories($_COOKIE["langue"]);
    
    echo json_encode($categories);//Encode le tableau de catégories retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère tous les arrondissements de la BDD.
* @access public
* @author David Lachambre
* @return void
*/
function recupererArrondissements () {

    $arrondissement = new Arrondissement();
    $arrondissements = $arrondissement->getAllArrondissements();
    
    echo json_encode($arrondissements);//Encode le tableau de catégories retourné par la requête en Json.
} 

/**
* @brief Fonction qui récupère toutes les oeuvres de la BDD.
* @access public
* @author David Lachambre
* @return void
*/
function recupererOeuvres () {

    $oeuvre = new Oeuvre();
    $oeuvres = $oeuvre->getAllOeuvres();
        
   echo json_encode($oeuvres);//Encode le tableau d'oeuvres retourné par la requête en Json.
}

/**
* @brief Fonction qui ajoute l'oeuvre soumise par un administrateur
* @access public
* @author David Lachambre
* @return void
*/
function ajouterOeuvre () {
    
    //Ajout d'une oeuvre.

    $oeuvre = new Oeuvre();

    if ($_POST['droitsAdmin'] === "false") {
        $droitsAdmin = false;
    }
    if ($_POST['droitsAdmin'] === "true") {
        $droitsAdmin = true;
    }

    $msgErreurs = $oeuvre->ajouterOeuvre($_POST['titre'], $_POST['adresse'], $_POST['prenomArtiste'], $_POST['nomArtiste'], $_POST['description'], $_POST["idCategorie"], $_POST["idArrondissement"], $droitsAdmin, $_COOKIE["langue"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère l'ID de l'oeuvre qui vient d'être créée
* @access public
* @author David Lachambre
* @return void
*/
function recupererIdOeuvre () {

    $oeuvre = new Oeuvre();
    $idOeuvre = $oeuvre->getIdOeuvreByTitreandAdresse($_POST["titre"], $_POST["adresse"]);//aller chercher id oeuvre insérée
    
    echo $idOeuvre;
}

/**
* @brief Fonction qui ajoute la photo soumise
* @access public
* @author David Lachambre
* @author Philippe Germain
* @return void
*/
function ajouterPhoto () {
    
    if (isset($_GET["admin"]) && $_GET["admin"] == "true") {
        $authorise = true;
    }
    else {
        $authorise = false;
    }
    //Ajout d'une oeuvre.
    $photo = new Photo();
    $typePhoto = "oeuvre";
    $msgErreurs = $photo->ajouterPhoto($_GET["idOeuvre"], $authorise, $typePhoto);
    
    echo $msgErreurs;
}

/**
* @brief Fonction qui supprime l'oeuvre soumise par un administrateur
* @access public
* @author David Lachambre
* @return void
*/
function supprimerOeuvre () {
    
    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->supprimerOeuvre($_POST["idOeuvre"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui affiche le formulaire de modification d'une oeuvre après sélection de l'oeuvre à modifier par l'utilisateur.
* @access public
* @author David Lachambre
* @author Philippe Germain
* @return void
*/
function afficherFormModif () {
    
    $oeuvre = new Oeuvre();
    $oArrondissement = new Arrondissement();
    $oCategorie = new Categorie();
    $langue = $_COOKIE['langue'];
    
    $oeuvreAModifier = $oeuvre->getAnyOeuvreById($_POST['idOeuvre'], $langue);
    if ($oeuvreAModifier) {
        $arrondissements = $oArrondissement->getAllArrondissements();
        $categories = $oCategorie->getAllCategories($langue);

        $titreModif = $oeuvreAModifier['titre'];
        $adresseModif = $oeuvreAModifier['adresse'];
        $idCategorieModif = $oeuvreAModifier['idCategorie'];
        $idArrondissementModif = $oeuvreAModifier['idArrondissement'];
        if ($_COOKIE["langue"] == "FR") {
            $descriptionModif = $oeuvreAModifier['descriptionFR'];
        }
        else if ($_COOKIE["langue"] == "EN") {
            $descriptionModif = $oeuvreAModifier['descriptionEN'];
        }
        ?>  
            <form method="POST" name="formModifOeuvre" id='formModifSelectOeuvre' action="?r=gestion" onsubmit="return valideModifierOeuvre();">
                <input type='text' class="inputGestion" name='titreModif' id='titreModif' placeholder="Titre de l'oeuvre" value='<?php echo $titreModif; ?>'/>
                <br><span class="erreur" id="erreurTitreOeuvreModif"></span>

                <input type='text' class="inputGestion" name='adresseModif' id='adresseModif'  placeholder="Adresse " value='<?php echo $adresseModif; ?>'/>
                <br><span class="erreur" id="erreurAdresseOeuvreModif"></span>

                <br>
                <textarea name='descriptionModif' class="inputGestion textAreaGestion" id='descriptionModif' placeholder="Description "><?php echo $descriptionModif; ?></textarea>
                <br><span class="erreur" id="erreurDescriptionModif"></span>

                <select name="selectArrondissementModif"  id="selectArrondissementModif" class="selectGestion">

                    <option value="">Choisir un arrondissement</option>
                    <?php
                        foreach ($arrondissements as $arrondissement) {
                            if ($arrondissement["idArrondissement"] == $idArrondissementModif) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$arrondissement["idArrondissement"]."'".$selection.">".$arrondissement["nomArrondissement"];
                        }
                    ?>
                </select>
                <br><span class="erreur" id="erreurSelectArrondissementModif"></span>

                <select name="selectCategorieModif" id="selectCategorieModif" class="selectGestion">

                    <option value="">Choisir une catégorie</option>
                    <?php
                        foreach ($categories as $categorie) {
                            if ($categorie["idCategorie"] == $idCategorieModif) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$categorie["idCategorie"]."'".$selection.">".$categorie["nomCategorie$langue"];
                        }
                        echo "</select>";
                    ?>
                </select> 

                <br><span class="erreur" id="erreurSelectCategorieModif"></span>

                <br><input class="boutonMoyenne  boutonHover" id='btnModCat' type='submit' name='boutonModifOeuvre' value='Modifer'>
            </form>
        <?php
    }
    else {
        echo "<span class='erreur'>cette oeuvre n'existe pas.</span>";
    }
}

/**
* @brief Fonction qui modifie l'oeuvre choisie par un administrateur
* @access public
* @author David Lachambre
* @return void
*/
function modifierOeuvre () {
    
    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->modifierOeuvre($_POST["idOeuvre"], $_POST["titre"], $_POST["adresse"], $_POST["description"], $_POST["idCategorie"], $_POST["idArrondissement"], $_COOKIE["langue"]);
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui modifie un champs de l'oeuvre soumise par un utilisateur pour approbation
* @access public
* @author David Lachambre
* @return void
*/
function modifierOeuvreSoumise () {
    
    $oeuvre = new Oeuvre();
    $elementModif = array();
    $msgErreurs = array();
    
    if (isset($_POST["titreModif"])) {
        $elementModif["titre"] = $_POST["titreModif"];
        $msgErreurs = $oeuvre->modifierOeuvreSoumise($_POST["idOeuvre"], $elementModif);
    }
    else if (isset($_POST["adresseModif"])) {
        $elementModif["adresse"] = $_POST["adresseModif"];
        $msgErreurs = $oeuvre->modifierOeuvreSoumise($_POST["idOeuvre"], $elementModif);
    }
    else if (isset($_POST["descriptionFrModif"])) {
        $elementModif["descriptionFR"] = $_POST["descriptionFrModif"];
        $msgErreurs = $oeuvre->modifierOeuvreSoumise($_POST["idOeuvre"], $elementModif);
    }
    else if (isset($_POST["descriptionEnModif"])) {
        $elementModif["descriptionEN"] = $_POST["descriptionEnModif"];
        $msgErreurs = $oeuvre->modifierOeuvreSoumise($_POST["idOeuvre"], $elementModif);
    }
    else if (isset($_POST["arrondissementModif"])) {
        $elementModif["idArrondissement"] = $_POST["arrondissementModif"];
        $msgErreurs = $oeuvre->modifierOeuvreSoumise($_POST["idOeuvre"], $elementModif);
    }
    else if (isset($_POST["categorieModif"])) {
        $elementModif["idCategorie"] = $_POST["categorieModif"];
        $msgErreurs = $oeuvre->modifierOeuvreSoumise($_POST["idOeuvre"], $elementModif);
    }
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui modifie un artiste
* @access public
* @author David Lachambre
* @return void
*/
function modifierArtisteSoumis () {
    
    $artiste = new Artiste();
    $elementModif = array();
    $msgErreurs = array();
    
    if (isset($_POST["pArtisteModif"]) && isset($_POST["nArtisteModif"])) {
        $elementsModif["prenomArtiste"] = $_POST["pArtisteModif"];
        $elementsModif["nomArtiste"] = $_POST["nArtisteModif"];
        $msgErreurs = $artiste->modifierArtisteSoumis($_POST["idOeuvre"], $_POST["idArtiste"], $elementsModif);
    }
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui modifie un commentaire soumis par un utilisateur pour approbation
* @access public
* @author David Lachambre
* @return void
*/
function modifierCommentaireSoumis () {
    
    $commentaire = new Commentaire();
    $msgErreurs = array();
    
    if (isset($_POST["commentaireModif"])) {
        $elementModif["texteCommentaire"] = $_POST["commentaireModif"];
        $msgErreurs = $commentaire->modifierCommentaireSoumis($_POST["idCommentaire"], $elementModif);
    }
    else if (isset($_POST["langueCommentaireModif"])) {
        $elementModif["langueCommentaire"] = $_POST["langueCommentaireModif"];
        $msgErreurs = $commentaire->modifierCommentaireSoumis($_POST["idCommentaire"], $elementModif);
    }
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui mets à jour les oeuvres de la BDD avec les oeuvres de la ville et mets à jour l'affichage dans la page de gestion.
* @access public
* @author David Lachambre
* @return void
*/
function updateOeuvresVille () {
    
    //Mise à jour des oeuvres de la ville de Montréal
    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->updaterOeuvresVille();
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère la dernière date de mise à jour des oeuvres de la ville.
* @access public
* @author David Lachambre
* @return void
*/
function updateDate () {
    
    //Affichage de la date de dernière mise à jour des oeuvres de la ville.
    $oeuvre = new Oeuvre();
    $date = $oeuvre->getDateDernierUpdate();
    echo json_encode($date);//Encode la date retournée par la requête en Json.
}

/**
* @brief Fonction qui récupère l'oeuvre choisie
* @access public
* @author David Lachambre
* @return void
*/
function recupererUneOeuvre () {

    $oeuvre = new Oeuvre();
    $oeuvrePourApprobation = $oeuvre->getOeuvrePourApprobation($_POST["idOeuvre"]);
    echo json_encode($oeuvrePourApprobation);//Encode le tableau retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère la photo choisie
* @access public
* @author David Lachambre
* @return void
*/
function recupererUnePhoto () {

    $photo = new Photo();
    $photoUnique = $photo->getPhotoById($_POST["idPhoto"]);
    echo json_encode($photoUnique);//Encode le tableau retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère le commentaire choisi
* @access public
* @author David Lachambre
* @return void
*/
function recupererUnCommentaire () {

    $commentaire = new Commentaire();
    $commentaireUnique = $commentaire->getCommentaireById($_POST["idCommentaire"]);
    echo json_encode($commentaireUnique);//Encode le tableau retourné par la requête en Json.
}

/**
* @brief Fonction qui accepte la soumission de l'oeuvre choisie
* @access public
* @author David Lachambre
* @return void
*/
function accepterSoumissionOeuvre () {

    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->accepterSoumission($_POST["id"]);
    echo json_encode($msgErreurs);//Encode le tableau de l'oeuvre retournée par la requête en Json.
}

/**
* @brief Fonction qui accepte la soumission de la photo choisie
* @access public
* @author David Lachambre
* @return void
*/
function accepterSoumissionPhoto () {

    $photo = new Photo();
    $msgErreurs = $photo->accepterSoumission($_POST["id"]);
    echo json_encode($msgErreurs);//Encode le tableau de l'oeuvre retournée par la requête en Json.
}

/**
* @brief Fonction qui accepte la soumission du commentaire choisie
* @access public
* @author David Lachambre
* @return void
*/
function accepterSoumissionCommentaire () {

    $commentaire = new Commentaire();
    $msgErreurs = $commentaire->accepterSoumission($_POST["id"]);
    echo json_encode($msgErreurs);//Encode le tableau de l'oeuvre retournée par la requête en Json.
}

/**
* @brief Fonction qui refuse/supprime la soumission de l'oeuvre choisie
* @access public
* @author David Lachambre
* @return void
*/
function refuserSoumissionOeuvre () {

    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->supprimerOeuvre($_POST["id"]);
    echo json_encode($msgErreurs);//Encode le tableau de l'oeuvre retournée par la requête en Json.
}

/**
* @brief Fonction qui refuse/supprime la soumission de la photo choisie
* @access public
* @author David Lachambre
* @return void
*/
function refuserSoumissionPhoto () {

    $photo = new Photo();
    $msgErreurs = $photo->supprimerPhoto($_POST["id"]);
    echo json_encode($msgErreurs);//Encode le tableau de l'oeuvre retournée par la requête en Json.
}

/**
* @brief Fonction qui refuse/supprime la soumission du commentaire choisie
* @access public
* @author David Lachambre
* @return void
*/
function refuserSoumissionCommentaire () {

    $commentaire = new Commentaire();
    $msgErreurs = $commentaire->supprimerCommentaire($_POST["id"]);
    echo json_encode($msgErreurs);//Encode le tableau de l'oeuvre retournée par la requête en Json.
}

/**
* @brief Fonction qui rafraîchit les liens oeuvres à approuver
* @access public
* @author David Lachambre
* @return void
*/
function updateLiensApprobOeuvres () {

    $oeuvre = new Oeuvre();
    $oeuvres = $oeuvre->getAllOeuvresPourApprobation();
    echo json_encode($oeuvres);//Encode le tableau de la requête en Json.
}

/**
* @brief Fonction qui rafraîchit les liens photos à approuver
* @access public
* @author David Lachambre
* @return void
*/
function updateLiensApprobPhotos () {

    $photo = new Photo();
    $photos = $photo->getAllPhotosPourApprobation();
    echo json_encode($photos);//Encode le tableau de la requête en Json.
}

/**
* @brief Fonction qui rafraîchit les liens commentaires à approuver
* @access public
* @author David Lachambre
* @return void
*/
function updateLiensApprobCommentaires () {

    $commentaire = new Commentaire();
    $commentaires = $commentaire->getAllCommentairesPourApprobation();
    echo json_encode($commentaires);//Encode le tableau de la requête en Json.
}

/* --------------------------------------------------------------------
============================ PAGE ACCUEIL =============================
-------------------------------------------------------------------- */
/**
* @brief Fonction qui récupère les infos pour populer la carte de Google Map
* @access public
* @return void
*/
function googleMap () {
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);

    $oeuvre = new Oeuvre();
    $infoOeuvre = $oeuvre->getAllOeuvresMap();
    $urlOeuvre = "http://".$_SERVER['HTTP_HOST']."?r=oeuvre&o=";

    // ADD TO XML DOCUMENT NODE
    for ($i = 0; $i < count($infoOeuvre); $i++) {
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("name","<div class='nomGooglemap'>".$infoOeuvre[$i]["titre"]."</div>");
        //$newnode->setAttribute("address", $row['adresse']);
        $newnode->setAttribute("lat", $infoOeuvre[$i]["latitude"]);
        $newnode->setAttribute("lng", $infoOeuvre[$i]["longitude"]); 
        //$newnode->setAttribute("photo", $infoOeuvre[$i]["image"]);   
        $newnode->setAttribute("url", $urlOeuvre.$infoOeuvre[$i]["idOeuvre"]);
        $newnode->setAttribute("idOeuvre", $infoOeuvre[$i]["idOeuvre"]);
    }
    header("Content-type: text/xml");
    echo $dom->saveXML();
}
/**
* @brief Fonction qui vérifie si l'utilisateur a deja visiter l'oeuvre et l'ajoute sinon
* @access public
* @return void
*/
function visiteOeuvres () {
    
    $test= false;
    $oeuvre = new Oeuvre();
    $test =  $oeuvre->aVisiteOeuvre($_POST["idOeuvre"], $_POST["idUtilisateur"]); 
    if ($test){
        $oeuvre->visiteOeuvre($_POST["idOeuvre"], $_POST["idUtilisateur"], $_POST["laDate"]);   
    }
      
}


/* --------------------------------------------------------------------
========================= BARRES DE RECHERCHE =========================
-------------------------------------------------------------------- */
/**
* @brief Fonction qui récupère des noms de la BDD en fonction des lettres entrées par l'utilisateur
* @access public
* @author Philippe Germain
* @return string
*/
function autoComplete () {
    
    if (!isset($_GET['keyword'])) {
        die();
    }

    if (isset($_GET['rechercheVoulue'])) {
        $keyword = $_GET['keyword'];

        if (($_GET['rechercheVoulue'])=="titre") {
            $oeuvre = new Oeuvre();
            $data = $oeuvre->chercheParTitre($keyword);
        }

        else if (($_GET['rechercheVoulue'])=="artiste") {
            $artiste = new Artiste();
            $data = $artiste->chercheParArtiste($keyword);
        }
    }
    echo json_encode($data);
}

/**
* @brief Fonction qui affiche le 2e select de la barre de recherche en fonction du choix de l'utilisateur
* @access public
* @author David Lachambre
* @return void
*/
function afficherSelectRecherche () {
    
    if (isset($_GET["typeRecherche"]) && $_GET["typeRecherche"] != "") {
        
        $nomServeur = $_SERVER["HTTP_HOST"];
        
        if ($_GET["typeRecherche"] == "artiste") {
            echo '<input class="text" type="text" placeholder="Entrez le nom de l\'artiste" id="keyword" name="inputArtiste" onkeyup="autoComplete(\'artiste\', \''.$nomServeur.'\')">';
            echo '<div id="results"></div>';
        }
        else if ($_GET["typeRecherche"] == "titre") {
            echo '<input class="text" type="text" placeholder="Entrez le titre de l\'oeuvre" id="keyword" name="inputOeuvre" onkeyup="autoComplete(\'titre\', \''.$nomServeur.'\')">';
            echo '<div id="results"></div>';
        }
        else if ($_GET["typeRecherche"] == "arrondissement") {
            echo '<select name="selectArrondissement" class="selectArrondissement">';
            echo '<option value = "">Faites un choix</option>';
            $nouvelArrondissement = new Arrondissement();
            $arrondissements = $nouvelArrondissement->getAllArrondissements();
            foreach ($arrondissements as $arrondissement) {
                echo '<option value="'.$arrondissement["idArrondissement"].'">'.$arrondissement["nomArrondissement"].'</option>';
            }
            echo '</select>';
        }
        else if ($_GET["typeRecherche"] == "categorie") {
            $nouvelleCategorie = new Categorie();
            if (isset($_COOKIE["langue"])) {
                $langue = $_COOKIE["langue"];
            }
            else {
                $langue = "FR";
            }
            $categories = $nouvelleCategorie->getAllCategories($langue);
            echo '<select name="selectCategorie" class="selectCategorie">';
            echo '<option value = "">Faites un choix</option>';
            foreach ($categories as $categorie) {
                echo '<option value="'.$categorie["idCategorie"].'">'.$categorie["nomCategorie$langue"].'</option>';
            }
            echo '</select>';
        }
    }
}

/**
* @brief Fonction qui affiche le bouton submit de la recherche si l'utilisateur a choisi arrondissement ou catégorie
* @access public
* @author David Lachambre
* @return void
*/
function afficherBoutonRecherche () {
    if ((isset($_GET["selectArrondissement"]) && $_GET["selectArrondissement"] != "") || (isset($_GET["selectCategorie"]) && $_GET["selectCategorie"] != "")) {
        echo '<input type="submit" name="boutonRecherche" value="Rechercher">';
    }
}

/**
* @brief Fonction qui affiche le 2e select de la barre de recherche mobile en fonction du choix de l'utilisateur
* @access public
* @author David Lachambre
* @return void
*/
function afficherSelectRechercheMobile () {
    
    if (isset($_GET["typeRechercheMobile"]) && $_GET["typeRechercheMobile"] != "") {
        
        $nomServeur = $_SERVER["HTTP_HOST"];
        
        if ($_GET["typeRechercheMobile"] == "artiste") {
            echo '<input class="text" type="text" placeholder="Entrez le nom de l\'artiste" id="keywordMobile" name="inputArtisteMobile" onkeyup="autoCompleteMobile(\'artiste\', \''.$nomServeur.'\')">';
            echo '<div id="resultsMobile"></div>';
        }
        else if ($_GET["typeRechercheMobile"] == "titre") {
            echo '<input class="text" type="text" placeholder="Entrez le titre de l\'oeuvre" id="keywordMobile" name="inputOeuvreMobile" onkeyup="autoCompleteMobile(\'titre\', \''.$nomServeur.'\')">';
            echo '<div id="resultsMobile"></div>';
        }
        else if ($_GET["typeRechercheMobile"] == "arrondissement") {
            echo '<select name="selectArrondissementMobile" class="selectArrondissementMobile">';
            echo '<option value = "">Faites un choix</option>';
            $nouvelArrondissement = new Arrondissement();
            $arrondissements = $nouvelArrondissement->getAllArrondissements();
            foreach ($arrondissements as $arrondissement) {
                echo '<option value="'.$arrondissement["idArrondissement"].'">'.$arrondissement["nomArrondissement"].'</option>';
            }
            echo '</select>';
        }
        else if ($_GET["typeRechercheMobile"] == "categorie") {
            $nouvelleCategorie = new Categorie();
            if (isset($_COOKIE["langue"])) {
                $langue = $_COOKIE["langue"];
            }
            else {
                $langue = "FR";
            }
            $categories = $nouvelleCategorie->getAllCategories($langue);
            echo '<select name="selectCategorieMobile" class="selectCategorieMobile">';
            echo '<option value = "">Faites un choix</option>';
            foreach ($categories as $categorie) {
                echo '<option value="'.$categorie["idCategorie"].'">'.$categorie["nomCategorie$langue"].'</option>';
            }
            echo '</select>';
        }
    }
}

/**
* @brief Fonction qui affiche le bouton submit de la recherche mobile si l'utilisateur a choisi arrondissement ou catégorie
* @access public
* @author David Lachambre
* @return void
*/
function afficherBoutonRechercheMobile () {
    if ((isset($_GET["selectArrondissementMobile"]) && $_GET["selectArrondissementMobile"] != "") || (isset($_GET["selectCategorieMobile"]) && $_GET["selectCategorieMobile"] != "")) {
        echo '<input type="submit" name="boutonRechercheMobile" value="Rechercher">';
    }
}
/* --------------------------------------------------------------------
========================GOOGLE MAP PAGE TRAJET=========================
-------------------------------------------------------------------- */

function googleMapTrajet ($lat, $lng) {
	
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);
	$center_lat = $lat;
	$center_lng = $lng;
    $oeuvre = new Oeuvre();
    $infoOeuvre = $oeuvre->getOeuvresProximite($center_lat, $center_lng);
    


    // ADD TO XML DOCUMENT NODE
    for ($i = 0; $i < count($infoOeuvre); $i++) {
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("name",$infoOeuvre[$i]["titre"]);
        $newnode->setAttribute("lat", $infoOeuvre[$i]["latitude"]);
        $newnode->setAttribute("lng", $infoOeuvre[$i]["longitude"]); 
        $newnode->setAttribute("distance",$infoOeuvre[$i]['distance']);
    }
    header("Content-type: text/xml");
    //echo $dom->saveXML();
    
}

/* --------------------------------------------------------------------
================================LOGIN==================================
-------------------------------------------------------------------- */
/**
* @brief Fonction qui authentifie une connexion usager nouveau
* @access public
* @author David Lachambre
* @author Cristina Mahneke
* @return void
*/
function  connexionNouveau(){
	if (isset($_POST["passNouveau"]) && isset($_POST["userNouveau"])) {
        
        session_start();
        $utilisateur = new Utilisateur();
        if($utilisateur = $utilisateur->connexionUtilisateur($_POST["userNouveau"], $_POST["passNouveau"])) {
            
            $_SESSION["idUsager"] = $utilisateur["idUtilisateur"];
            $_SESSION["nomUsager"] = $utilisateur["nomUsager"];
            $_SESSION["admin"] = $utilisateur["administrateur"];
            echo true;
        }
        else {
            echo false;
        }
    }
}
/**
* @brief Fonction qui authentifie une connexion usager
* @access public
* @author David Lachambre
* @return void
*/
function connexion () {

    if (isset($_POST["pass"]) && isset($_POST["user"])) {
        
        session_start();
        $utilisateur = new Utilisateur();
        if($utilisateur = $utilisateur->connexionUtilisateur($_POST["user"], $_POST["pass"])) {
            
            $_SESSION["idUsager"] = $utilisateur["idUtilisateur"];
            $_SESSION["nomUsager"] = $utilisateur["nomUsager"];
            $_SESSION["admin"] = $utilisateur["administrateur"];
            echo true;
        }
        else {
            echo false;
        }
    }
}

/**
* @brief Fonction qui déconnecte l'usager
* @access public
* @author David Lachambre
* @return void
*/
function deconnexion () {
        
    session_start();
    session_destroy();
}

/* --------------------------------------------------------------------
================================PROFIL==================================
-------------------------------------------------------------------- */

/**
* @brief Fonction qui récupère les infos de l'utilisateur.
* @access public
* @author Cristina Manheke
* @return void
*/
function recupererInfoUtilisateur() {

    $utilisateur = new Utilisateur();
    $utilisateurs = $utilisateur->getUtilisateurById();
        
   echo json_encode($utilisateurs);//Encode le tableau d'oeuvres retourné par la requête en Json.
}
/**
* @brief Fonction qui modifie l'utilisateur
* @access public
* @author Cristina Manheke
* @return void
*/
function modifierUtilisateur () {   
    $utilisateur = new Utilisateur();
    $msgErreurs = $utilisateur->modifierUtilisateur($_POST["motPasse"], $_POST["prenom"], $_POST["nom"], $_POST["description"], $_POST["idUtilisateur"]);
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}
/**
* @brief Fonction qui ajoute la photo soumise
* @access public
* @author Philippe Germain
* @return void
*/
function ajouterPhotoUtilisateur () {
    
   //Insertion de la photo de profil si choisie
    $photo = new Photo();
    $typePhoto = "utilisateur";
    $msgErreurs = $photo->ajouterPhoto($_GET["idUtilisateur"], true, $typePhoto);
    echo $msgErreurs;
}
?>