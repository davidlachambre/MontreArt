<?php

/**
* @brief class Arrondissement
* @author David Lachambre
* @version 1.0
* @update 2016-01-13
*/
class Arrondissement {
	
    private static $database;
    
	function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
		
	/**
    * @brief Méthode qui récupère tous les arrondissements dans la BDD.
    * @access public
    * @return array
    */
	public function getAllArrondissements() 
	{
				
        $infoArrondissements = array();
        
        self::$database->query('SELECT idArrondissement, nomArrondissement FROM Arrondissements');
        
        if ($arrondissements = self::$database->resultset()) {
            foreach ($arrondissements as $arrondissement) {
                $infoArrondissements[] = $arrondissement;
            }
        }
        return $infoArrondissements;
	}
    
    /**
    * @brief Méthode qui récupère l'ID en fonction du nom passé en paramètre, s'il existe.
    * @param string $nomArrondissement
    * @access public
    * @return string ou boolean
    */
    public function getArrondissementIdByName($nomArrondissement) {
        
        self::$database->query('SELECT idArrondissement FROM Arrondissements WHERE Arrondissements.nomArrondissement = :nomArrondissement');

        //Lie les paramètres aux valeurs
        self::$database->bind(':nomArrondissement', $nomArrondissement);

        if ($Arrondissement = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $Arrondissement["idArrondissement"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui récupère le nom en fonction du id passé en paramètre, s'il existe.
    * @param string $idArrondissement
    * @access public
    * @return string ou boolean
    */
    public function getArrondissementNameById($idArrondissement) {
        
        self::$database->query('SELECT nomArrondissement FROM Arrondissements WHERE Arrondissements.idArrondissement = :idArrondissement');

        //Lie les paramètres aux valeurs
        self::$database->bind(':idArrondissement', $idArrondissement);

        if ($arrondissement = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $arrondissement["nomArrondissement"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui ajoute un arrondissement à la BDD.
    * @param string $nomArrondissement
    * @access public
    * @return void
    */
    public function ajouterArrondissement($nomArrondissement) {
        try {
            self::$database->query('INSERT INTO Arrondissements (nomArrondissement) VALUES (:nomArrondissement)');
            self::$database->bind(':nomArrondissement', $nomArrondissement);
            self::$database->execute();
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        } 
    }
}
?>