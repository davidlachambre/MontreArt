<?php

/**
* @brief class Categorie
* @author David Lachambre
* @version 1.0
* @update 2016-01-13
*/
class Categorie {
	
    private static $database;
    
	function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
		
	/**
	 * @access public
	 * @return Array
	 */
	public function getAllCategories($langue) {
				
        $infoCategories = array();
        
        self::$database->query('SELECT idCategorie, nomCategorie' . $langue . ' FROM Categories');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':langue', $langue);
        
        if ($categories = self::$database->resultset()) {
            foreach ($categories as $categorie) {
                $infoCategories[] = $categorie;
            }
        }
        return $infoCategories;
	}
    
    /**
    * @brief Méthode qui récupère l'ID en fonction du nom passé en paramètre, s'il existe.
    * @param string $nomCategorie
    * @access private
    * @return string ou boolean
    */
    public function getCategorieIdByName($nomCategorie) {
        
        self::$database->query('SELECT idCategorie FROM Categories WHERE Categories.nomCategorieFR = :nomCategorie OR Categories.nomCategorieEN = :nomCategorie');

        //Lie les paramètres aux valeurs
        self::$database->bind(':nomCategorie', $nomCategorie);

        if ($categorie = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $categorie["idCategorie"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui récupère le nom en fonction du id passé en paramètre, s'il existe.
    * @param string $idCategorie
    * @access private
    * @return string ou boolean
    */
    public function getCategorieNameById($idCategorie) {
        
        self::$database->query('SELECT nomCategorieFR FROM Categories WHERE Categories.idCategorie = :idCategorie');

        //Lie les paramètres aux valeurs
        self::$database->bind(':idCategorie', $idCategorie);

        if ($categorie = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $categorie["nomCategorieFR"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui ajoute une catégorie à la BDD.
    * @param string $nomCategorieFR
    * @param string $nomCategorieEN
    * @access public
    * @return void
    */
    public function ajouterCategorie($nomCategorieFR, $nomCategorieEN) {
        
        $msgErreurs = $this->validerFormAjoutCategorie($nomCategorieFR, $nomCategorieEN);//Validation des champs obligatoires.
        
        if (!empty($msgErreurs)) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
            try {
                self::$database->query('INSERT INTO Categories (nomCategorieFR, nomCategorieEN) VALUES (:nomCategorieFR, :nomCategorieEN)');
                self::$database->bind(':nomCategorieFR', $nomCategorieFR);
                self::$database->bind(':nomCategorieEN', $nomCategorieEN);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errRequeteAjoutCat"] = $e->getMessage();
            }
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui supprime une catégorie à la BDD.
    * @param string $id
    * @access public
    * @return void
    */
    public function supprimerCategorie($id) {
        
        $msgErreurs = $this->validerFormSuppCategorie($id);//Validation des champs obligatoires.
        
        if (!empty($msgErreurs)) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
            try {
                self::$database->query('DELETE FROM Categories WHERE idCategorie = :id');
                self::$database->bind(':id', $id);
                self::$database->execute();
            }
            catch(Exception $e) {
                $msgErreurs["errRequeteSuppCat"] = $e->getMessage();
                
            } 
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui valide les champs obligatoires lors d'un ajout.
    * @param string $nomCategorieFR
    * @param string $nomCategorieEN
    * @access private
    * @return array
    */
    private function validerFormAjoutCategorie($nomCategorieFR, $nomCategorieEN) {
        
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        self::$database->query('SELECT idCategorie FROM Categories WHERE nomCategorieFR = :categorieFR OR nomCategorieEN = :categorieEN');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':categorieFR', $nomCategorieFR);
        self::$database->bind(':categorieEN', $nomCategorieEN);
        
        if ($categorie = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $msgErreurs["errRequeteAjoutCat"] = "Cette catégorie existe déjà";
            return $msgErreurs;
        }
        
        $nomCategorieFR = trim($nomCategorieFR);
        if (empty($nomCategorieFR)) {
            $msgErreurs["errAjoutCategorieFR"] = "Veuillez entrer un nom de catégorie en français";
        }
        $nomCategorieEN = trim($nomCategorieEN);
        if (empty($nomCategorieEN)) {
            $msgErreurs["errAjoutCategorieEN"] = "Veuillez entrer un nom de catégorie en anglais";
        }
        return $msgErreurs;
    }
    
    /**
    * @brief Méthode qui valide les champs obligatoires lors d'une suppression d'oeuvre.
    * @param string $id
    * @access private
    * @return array
    */
    private function validerFormSuppCategorie($id) {
        
        $msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        self::$database->query('SELECT idOeuvre FROM Oeuvres WHERE idCategorie = :idCategorie');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':idCategorie', $id);
        
        if ($categorie = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $msgErreurs["errRequeteSuppCat"] = "Cette catégorie ne peut être supprimée car une oeuvre y réfère";
            return $msgErreurs;
        }
        
        if (empty($id)) {
            $msgErreurs["errSelectCategorieSupp"] = "Veuillez choisir une catégorie à supprimer";
        }
        return $msgErreurs;
    }
}
?>