<?php
/**
 * @brief Class VueTrajet
 * @author Cristina Mahneke
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-16
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueTrajet extends Vue {
    private $lat;
    private $lng;
    function __construct() {
        $this->titrePage = "MontréArt - Trajet";
        $this->descriptionPage = "La page de création d'un trajet du site MontréArt";
    }
  
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
       
    
    ?>
        <script type="text/javascript" src="js/vendor/js-marker-clusterer-gh-pages/src/markerclusterer.js"></script>
         <div id="itineraire">
            <div id="distanceMarqueur" class='distanceMarqueur'></div>
             <form id="form_itineraire">
               
                <h3>Point de départ :</h3>
                <p>Veuillez taper une adresse si votre point de départ est différent de celui qui est montré pour l'icône</p>
                <input type="text" id= "depart" name="pointA" value="" placeholder="votre localisation">
                <span id="erreurDepart" class="erreur"></span>
                <br>
                <br><br><h3>Destination :</h3>
                
                <select id= "fin" name="fin">
                    <option>Sélectionnez la fin de votre route</option>
                </select>
                 <br><span id="erreurDestination" class="erreur"></span>
                
                 <br><br><br><h3>Sélectionnez vos arrêts intermédiaires (optionel) :</h3>
                 <p>Ctrl+clic pour sélectionner plusieurs options</p>
                 <span id="erreurWaypoints" class="erreur"></span>
                 <select multiple id="waypoints">
                    
                 </select>
                <input class="submit" id="envoyerTrajetBouton" type="button" value="Envoyer" name="Envoyer">
                 <span id="erreurPasTrouve" class="erreur"></span>
            </form>
            </div>
                <div id="directions-panel">
                   
                </div>

         <div id="map">
               <script async defer src="https://maps.googleapis.com/maps/api/js?key=&signed_in=true&callback=initMapTrajet"></script>
                 
        </div>
        
        
    <?php
    }
}
    
?>