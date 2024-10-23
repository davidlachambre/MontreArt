<?php
/**
 * @brief Class VueRecherche
 * @author Josianne Thessereault
 * @version 1.0
 * @update 2015-12-16
 * 
 */

header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueRecherche extends Vue {
    
    /**
    * @var array $oeuvre Information sur l'oeuvre
    * @access private
    */
    private $oeuvres;
    
    /**
    * @var string $typeRecherche Type de recherche lancée par l'utilisateur
    * @access private
    */
    private $typeRecherche;
    
    /**
    * @var string $nomRecherche nom recherché
    * @access private
    */
    private $nomRecherche;
    
    function __construct() {        
        $this->titrePage = "MontréArt - Recherche";
        $this->descriptionPage = "Cette page affiche une recherche spécifique du site MontréArt";
    }
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés de la vue
    * @param array $oeuvres
    * @param string $typeRecherche
    * @param string $nomRecherche
    * @access public
    * @return void
    */
    public function setData($oeuvres, $typeRecherche, $nomRecherche) {
        
        $this->oeuvres = $oeuvres;
        $this->typeRecherche = $typeRecherche;
        $this->nomRecherche = $nomRecherche;
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        
        $langue = $this->langue;

        echo "<div class='resultatsRecherche'>";
        echo "<div>";
        if (empty($this->oeuvres)) {
            echo "<p id='aucuneOeuvre'>Aucune oeuvre n'a été trouvée selon vos critères de recherche</p>";
        }
        else {
            if ( isset($this->oeuvres[0]["nomCategorie$langue"])) {
                echo "<br><h1 class='rechercheResultTitre'>Résultats de la recherche $this->typeRecherche ($this->nomRecherche):</h1><br>";
            }
            
            foreach ($this->oeuvres as $oeuvre) {
                if ( isset($oeuvre["titre"])) {
                    echo "<a href=http://".$_SERVER['HTTP_HOST']."?r=oeuvre&o=".$oeuvre["idOeuvre"]."><fieldset class='fieldsetRecherche'>";
                    if (isset($oeuvre["photo"])) {
                        echo "<img src='./" . $oeuvre["photo"] . "'>";
                    }
                    else {
                        echo "<img src='./images/thumbnailDefautFR.png'>";
                    }
                    echo "<h5 class='rechercheResultTitre'>Titre : </h5><p class='infoResult'>" . $oeuvre["titre"] . "</p>";
                }
                if (isset($oeuvre["nomArtiste"])) {
                    echo "<h5 class='rechercheResultTitre'>Artiste : </h5>";
                    if ( isset($oeuvre["prenomArtiste"])) {
                        echo  "<p class='infoResult'>".$oeuvre["prenomArtiste"]." ";
                    }
                    echo  $oeuvre["nomArtiste"]."</p>";
                }
                if ( isset($oeuvre["description$langue"])) {
                    echo "<h5 class='rechercheResultTitre'>Description :</h5>
            <p class='infoResult'>".$oeuvre["description$langue"]."</p>";
                }
                echo "</fieldset></a>";
            }
        }
        echo "</div>";
        echo "</div>";
    }
}
    
?>