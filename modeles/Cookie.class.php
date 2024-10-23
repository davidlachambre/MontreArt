<?php
/**
* @brief class Cookie
* @author David Lachambre
* @version 1.0
* @update 2015-12-14
*/
class Cookie {

    /**
    * @var string $langue Langue d'affichage.
    * @access private
    */
    private $langue;
    
	function __construct() {
    
        if (isset($_COOKIE["langue"])) {
            $this->langue = strtoupper($_COOKIE["langue"]);//Récupération de la langue du cookie.
        }
        else {
            $this->langue = "FR";//Langue par défaut.
        }
        setcookie("langue", $this->langue, time() + (60 * 60 * 24 * 365));//Crée le cookie à chaque visite de page.
	}
    
    /**
    * @brief Méthode qui retourne le contenu de la propriété $langue
    * @access public
    * @return string
    */
    public function getLangue() {
        return $this->langue;
    }
}
?>