<?php
/**
 * @brief Class VueAccueil
 * @author David Lachambre
 * @version 1.0
 * @update 2016-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueAccueil extends Vue {
    
    /**
    * @var array image et information de l'oeuvre en vedette
    * @access private
    */
    private $photoOeuvreVedette;

    function __construct() {
        $this->titrePage = "MontréArt - Accueil";
        $this->descriptionPage = "La page d'accueil du site MontréArt";
    }
     public function setData($photoOeuvreVedette) {
        
        $this->photoOeuvreVedette = $photoOeuvreVedette;
    }
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        
    ?>          
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX7W9IA4ew3pHEhUYUId7DYSRaVaUrDJM&signed_in=true&callback=initMap"></script>
                <script type="text/javascript" src="js/vendor/js-marker-clusterer-gh-pages/src/markerclusterer.js"></script>

                <img id="logoMobile" src="images/logo.png" alt="logoMobile">
                <p class="textStandard" id="texteAccueil">
Bienvenue sur le site de Montréart, où les oeuvres publiques les plus fantastiques en ville sont répertoriées. Idéal pour en apprendre sur les artistes les plus branchés, des techniques de création des plus diverses et des pièces d'art à couper le souffle. Vous pourrez vous balader et partager vos trouvailles avec vos propres photos, et exprimer vos opinions en ligne. En plus de découvrir l'art d'ici, vous avec la possibilité de gagner des rabais incroyables grâce à notre système dès que vous vous trouvez proche d'une oeuvre! Partez à l'aventure, ça en vaut le coup!
                </p>
            <div id="map"></div>
            <div id="distanceMarqueur" class='distanceMarqueur'></div>
                <h4 id="aProposMontreart">À propos de MontréArt</h4>
                <p class="textStandard" id="texteAccueilTablette">
Bienvenue sur le site de Montréart, où les oeuvres publiques les plus fantastiques en ville sont répertoriées. Idéal pour en apprendre sur les artistes les plus branchés, des techniques de création des plus diverses et des pièces d'art à couper le souffle. Vous pourrez vous balader et partager vos trouvailles avec vos propres photos, et exprimer vos opinions en ligne. En plus de découvrir l'art d'ici, vous avec la possibilité de gagner des rabais incroyables grâce à notre système dès que vous vous trouvez proche d'une oeuvre! Partez à l'aventure, ça en vaut le coup!
                </p>

            <?php
                if(isset($this->photoOeuvreVedette["image"])){
                   
                    echo "<div class='oeuvreVedette'><a href='http://".$_SERVER['HTTP_HOST']."?r=oeuvre&o=".$this->photoOeuvreVedette["idOeuvre"]."'><img src='".$this->photoOeuvreVedette["image"]."' alt='photo oeuvre en vedette'><div id='titreOeuvreVedette'>En Vedette: ".$this->photoOeuvreVedette["titre"]."</div></a></div>";
                }
            
           ?>

    <div class="pubAccueil">
        <img src="images/Promo.png" id="promoMobile" alt='promo'>
        <img src="images/promoDesktop.png" id="promoDesktop" alt='promo'>
    </div>
    <?php
    }
}
?>